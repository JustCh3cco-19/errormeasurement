#!/usr/bin/env python
# coding: utf-8

# In[1]:


import numpy as np
from sympy import *

# ### Funzione

a,b,c,d,e = symbols('a b c d e')
diz = {0:a, 1:b, 2:c, 3:d, 4:e}

f = np.pi*(a-b)      #ESPRESSIONE FUNZIONE



# ### Valori

# In[ ]:


val = np.zeros(5)

num=int(input('Inserire numero incognite (max 5) ==> '))

print('Inserire valori')
for i in range(num):
    val[i]=float(input(f'{i+1}) '))


# ### Matrice di covarianza

# In[14]:


S=np.zeros([5,5])


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
S



# In[17]:


var=0
for i in diz:
    fi = f.diff(diz[i])
    for j in diz:
        fj = f.diff(diz[j])
        x = fi.subs([(a,val[0]),(b,val[1]),(c,val[2]),(d,val[3]),(e,val[4])]).evalf() * fj.subs([(a,val[0]),(b,val[1]),(c,val[2]),(d,val[3]),(e,val[4])]).evalf() * S[i,j]
        var+=x

dev = var**0.5

print('Varianza = ',var)
print ('Deviazione standard = ',dev)


