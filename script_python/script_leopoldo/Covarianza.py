#!/usr/bin/env python
# coding: utf-8

# In[2]:


import numpy as np
from sympy import *
from math import sqrt

# In[6]:


x,y,z = symbols('x y z')
diz = {0:x, 1:y, 2:z}
f =  3*x**2 +x*y -7*y**2       #espressione FUNZIONE 1
g =  y                   #espressione FUNZIONE 2


# In[4]:


val = np.zeros(3)
num=int(input('Inserire numero incognite (max 3) ==> '))
print('Inserire valori')
for i in range(num):
    val[i]=float(input(f'{i+1}) '))


# In[5]:


S=np.zeros([3,3])

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



# In[7]:


cov=0
for i in diz:
    fi = f.diff(diz[i])
    for j in diz:
        gj = g.diff(diz[j])
        a = fi.subs([(x,10.5),(y,4.3),(z,0)]).evalf() * gj.subs([(x,10.5),(y,4.3),(z,0)]).evalf() * S[i,j]
        cov+=a
print('covarianza = ',cov)


# %%
