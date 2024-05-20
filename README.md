# propagazione_errori
# Calculation of Variance of a Function
## This code allows you to calculate the variance of a mathematical function. Variance is a measure of the variability of values assumed by a function.

## How it works:
The user needs to input the following information:

- The number of variables of the function;
- The mathematical function;
- The values of the variables;
- The variances of the variables;
- The covariances of the variables;
- The code then calculates the variance of the function using the following formula: var = Σ(xi * xj * cov_mat[i,j]);

where:

- xi is the first derivative of f() with respect to variable i;
- xj is the first derivative of f() with respect to variable j;
- cov_mat[i,j] is the covariance between variables i and j;
- The first derivative of f() with respect to each variable is calculated using the SymPy module.

- The covariance between two variables is calculated as the average of the squared products of the variable values.

# Output:
## The code prints the following results:

- The mathematical function entered by the user;
- The values of the variables entered by the user;
- The variances entered by the user;
- The covariances entered by the user;
- The calculated variance of the function;
- The standard deviation of the function;

# Data Download:
## The code also provides an option to download the user-entered data. To do this, the user must click the "Download Data" button. The code creates a text file with the user-entered data and downloads it to the user's computer.

# Requirements:
## The code requires the following prerequisites:

Python 3.6 or higher;
NumPy module;
SymPy module;

# Example
## Here's an example of using the code:

- Inserisci numero incognite (max 10): 2
- Inserisci funzione: a + b
- Valore incognita "a" ==> 1
- Valore incognita "b" ==> 2
- Sicuro di aver messo le varianze? (Rispondi si per continuare, altrimenti ricarica la pagina per ricominciare): si
- Varianza "a" ==> 1
- Varianza "b" ==> 4
- Covarianza "a-b" ==> 3

- Funzione: a + b
- Valori delle incognite:
- a: 1
- b: 2
- Varianze:
- a: 1
- b: 4
- Covarianze:
- a-b: 3

- Varianza = 10
- Deviazione standard = 3.162277660168379
