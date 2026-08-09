'use strict';
const assert = require('assert');
const math = require('mathjs');
const core = require('../public/assets/js/calculator-core.js');

function calculate(expression, names, scope, covariance) {
  const node = math.parse(expression);
  const gradient = names.map(name => math.derivative(node, name).compile().evaluate(scope));
  return core.propagatedVariance(gradient, covariance);
}

assert.strictEqual(calculate('a + b', ['a', 'b'], {a: 1, b: 2}, [[1, 1], [1, 4]]), 7);
assert.ok(Math.abs(calculate('a * b', ['a', 'b'], {a: 2, b: 3}, [[0.04, 0], [0, 0.09]]) - 0.72) < 1e-12);
assert.ok(Math.abs(calculate('sin(a)', ['a'], {a: 0}, [[0.25]]) - 0.25) < 1e-12);
console.log('calculator-symbolic: all tests passed');
