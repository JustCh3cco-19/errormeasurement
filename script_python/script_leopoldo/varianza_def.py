#!/usr/bin/env python
# coding: utf-8

# In[43]:


#!/usr/bin/env python
# coding: utf-8

# In[1]:

import numpy as np
import sympy
from sympy import *

N = 10
# ### Funzione

stringa = 'a b c d e f g h i j'
a,b,c,d,e,f,g,h,i,j = symbols(stringa)
diz = {0:a,1:b,2:c,3:d,4:e,5:f,6:g,7:h,8:i,9:j}

funzione = str(input('Inserisci funzione: ')) #ESPRESSIONE FUNZIONE
f = eval(funzione)
   
# ### Valori

# In[ ]:


val = np.zeros(N)

num=int(input('Inserire numero incognite (max 10) ==> '))

print('Inserire valori')
for i in range(num):
    val[i]=float(input(f'{i+1}) '))


# ### Matrice di covarianza

# In[14]:


S=np.zeros([N,N])


print('Inserire VARIANZE (non dev)')
for i in range(num):
    S[i,i]=float(input(f'Varianza {i+1} ==> '))

test=input('Sicuro di aver messo le varianze? ')

for i in range(num-1):
    for j in range(i+1,num,1):
        S[i,j]=float(input(f'Covarianza {i+1}-{j+1} ==> '))


for i in range(len(S)):
    for j in range(len(S)):
        S[j,i]=S[i,j]

# In[17]:


var=0
for i in diz:
    fi = f.diff(diz[i])
    for j in diz:
        fj = f.diff(diz[j])
        xi = fi.subs([(a,val[0]),(b,val[1]),(c,val[2]),(d,val[3]),(e,val[4]),
            (f,val[5]),(g,val[6]),(h,val[7]),(i,val[8]),(j,val[9]),]).evalf() 
        xj = fj.subs([(a,val[0]),(b,val[1]),(c,val[2]),(d,val[3]),(e,val[4]),
            (f,val[5]),(g,val[6]),(h,val[7]),(i,val[8]),(j,val[9]),]).evalf()
        var+=(xi*xj*S[i,j])

dev = var**0.5

print('Varianza = ',var)
print ('Deviazione standard = ',dev)

