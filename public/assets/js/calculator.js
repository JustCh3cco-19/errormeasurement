(() => {
  'use strict';
  const names = ['a','b','c','d','e','f','g','h','i','j'];
  const allowedFunctions = new Set(['sin','cos','tan','exp','log','sqrt','abs']);
  const count = document.querySelector('#variable-count');
  const variables = document.querySelector('#variables');
  const covarianceTable = document.querySelector('#covariance-table');
  const form = document.querySelector('#calculator-form');
  const errorBox = document.querySelector('#form-error');
  let lastResult = null;

  for (let i = 1; i <= 10; i++) count.add(new Option(String(i), String(i), i === 2, i === 2));
  const numberInput = (id, value, min = null) => {
    const input = document.createElement('input');
    Object.assign(input, {type: 'number', id, name: id, value: String(value), required: true, step: 'any'});
    if (min !== null) input.min = String(min);
    return input;
  };
  const renderInputs = () => {
    const n = Number(count.value); variables.replaceChildren(); covarianceTable.replaceChildren();
    names.slice(0, n).forEach((name, index) => {
      const group = document.createElement('div'); group.className = 'variable-card';
      const heading = document.createElement('strong'); heading.textContent = name;
      const valueLabel = document.createElement('label'); valueLabel.textContent = 'Value'; valueLabel.append(numberInput(`value-${index}`, index + 1));
      const varianceLabel = document.createElement('label'); varianceLabel.textContent = 'Variance'; varianceLabel.append(numberInput(`variance-${index}`, 1, 0));
      group.append(heading, valueLabel, varianceLabel); variables.append(group);
    });
    const head = document.createElement('tr'); head.append(document.createElement('th'));
    names.slice(0,n).forEach(name => { const th=document.createElement('th'); th.textContent=name; head.append(th); });
    const thead=document.createElement('thead'); thead.append(head); covarianceTable.append(thead);
    const body=document.createElement('tbody');
    for (let row=0; row<n; row++) {
      const tr=document.createElement('tr'); const label=document.createElement('th'); label.textContent=names[row]; tr.append(label);
      for (let col=0; col<n; col++) {
        const td=document.createElement('td');
        if (row === col) { td.className='diagonal'; td.dataset.index=String(row); td.textContent='1'; }
        else if (col > row) td.append(numberInput(`cov-${row}-${col}`, 0));
        else { td.className='mirror'; td.textContent='—'; }
        tr.append(td);
      }
      body.append(tr);
    }
    covarianceTable.append(body);
    names.slice(0,n).forEach((_, i) => document.querySelector(`#variance-${i}`).addEventListener('input', event => {
      covarianceTable.querySelector(`.diagonal[data-index="${i}"]`).textContent=event.target.value;
    }));
  };

  const assertSafeExpression = (node, activeNames) => {
    node.traverse(child => {
      const type = child.type;
      if (!['OperatorNode','ConstantNode','SymbolNode','FunctionNode','ParenthesisNode'].includes(type)) throw new Error(`Unsupported element: ${type}`);
      if (type === 'SymbolNode' && !activeNames.has(child.name) && !allowedFunctions.has(child.name)) throw new Error(`Unsupported symbol: ${child.name}`);
      if (type === 'FunctionNode' && (child.fn.type !== 'SymbolNode' || !allowedFunctions.has(child.fn.name))) throw new Error('Unsupported function.');
      if (type === 'OperatorNode' && !['+','-','*','/','^'].includes(child.op)) throw new Error(`Unsupported operator: ${child.op}`);
    });
  };
  const finite = (value, label) => { if(String(value).trim()==='') throw new Error(`${label} is required.`); const n=Number(value); if(!Number.isFinite(n)) throw new Error(`${label} must be a finite number.`); return n; };
  const format = value => Number(value).toPrecision(10).replace(/(?:\.0+|(?:(\.\d*?)0+))$/, '$1');

  form.addEventListener('submit', event => {
    event.preventDefault(); errorBox.classList.add('hidden');
    try {
      const n=Number(count.value), active=names.slice(0,n), scope={}, variances=[];
      active.forEach((name,i) => { scope[name]=finite(document.querySelector(`#value-${i}`).value, `Value ${name}`); variances[i]=finite(document.querySelector(`#variance-${i}`).value, `Variance ${name}`); if(variances[i]<0) throw new Error(`The variance of ${name} cannot be negative.`); });
      const expression=document.querySelector('#expression').value.trim(); if(!expression || expression.length>200) throw new Error('The function must contain 1–200 characters.');
      const node=math.parse(expression); assertSafeExpression(node,new Set(active));
      const matrix=Array.from({length:n},(_,i)=>Array.from({length:n},(_,j)=>i===j?variances[i]:0));
      for(let i=0;i<n-1;i++) for(let j=i+1;j<n;j++) matrix[i][j]=matrix[j][i]=finite(document.querySelector(`#cov-${i}-${j}`).value,`Covariance ${active[i]}-${active[j]}`);
      if(!CalculatorCore.isPositiveSemidefinite(matrix)) throw new Error('The covariance matrix is not positive semidefinite. Check the variances and covariances.');
      const value=finite(node.compile().evaluate(scope),'Result');
      const derivatives=active.map(name=>math.derivative(node,name));
      const gradient=derivatives.map((derivative,i)=>finite(derivative.compile().evaluate(scope),`Derivative with respect to ${active[i]}`));
      let variance=CalculatorCore.propagatedVariance(gradient,matrix);
      if(variance<0 && variance>-1e-10) variance=0; if(variance<0) throw new Error('The calculated variance is negative. Check the input data.');
      lastResult={expression,variables:scope,covarianceMatrix:matrix,gradient:Object.fromEntries(active.map((name,i)=>[name,gradient[i]])),functionValue:value,variance,standardDeviation:Math.sqrt(variance)};
      document.querySelector('#expression-result').textContent=expression; document.querySelector('#function-value').textContent=format(value); document.querySelector('#variance-result').textContent=format(variance); document.querySelector('#deviation-result').textContent=format(Math.sqrt(variance));
      document.querySelector('#formula-result').textContent=`∇fᵀ Σ ∇f = ${format(variance)}`;
      document.querySelector('#gradient-result').textContent=active.map((name,i)=>`∂f/∂${name} = ${derivatives[i].toString()} → ${format(gradient[i])}`).join('\n');
      document.querySelector('#result').classList.remove('hidden'); document.querySelector('#result').scrollIntoView({behavior:'smooth'});
    } catch(error) { document.querySelector('#result').classList.add('hidden'); errorBox.textContent=error.message; errorBox.classList.remove('hidden'); }
  });
  const download=(content,type,filename)=>{const url=URL.createObjectURL(new Blob([content],{type}));const link=document.createElement('a');link.href=url;link.download=filename;link.click();URL.revokeObjectURL(url);};
  document.querySelector('#download-json').addEventListener('click',()=>lastResult&&download(JSON.stringify(lastResult,null,2),'application/json','uncertainty-propagation.json'));
  document.querySelector('#download-csv').addEventListener('click',()=>{if(!lastResult)return;const rows=[['metric','value'],['function',lastResult.expression],['function value',lastResult.functionValue],['variance',lastResult.variance],['standard deviation',lastResult.standardDeviation],...Object.entries(lastResult.variables).map(([k,v])=>[`value ${k}`,v]),...Object.entries(lastResult.gradient).map(([k,v])=>[`derivative ${k}`,v]),...lastResult.covarianceMatrix.flatMap((row,i)=>row.map((v,j)=>[`covariance ${names[i]}-${names[j]}`,v]))];download(rows.map(r=>r.map(v=>`"${String(v).replace(/"/g,'""')}"`).join(',')).join('\n'),'text/csv','uncertainty-propagation.csv');});
  count.addEventListener('change',renderInputs); renderInputs();
})();
