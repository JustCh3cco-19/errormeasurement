# Error Measurement - Function Variance Calculator

A Python tool for calculating the variance and standard deviation of mathematical functions with multiple variables, using error propagation theory.

## 📋 Overview

This application computes the variance of a mathematical function by analyzing how uncertainties in input variables propagate through the function. It uses partial derivatives and covariance matrices to provide accurate uncertainty measurements.

## 🔧 How It Works

The variance calculation is based on the error propagation formula:

```
var(f) = Σᵢⱼ (∂f/∂xᵢ)(∂f/∂xⱼ) · cov(xᵢ, xⱼ)
```

Where:
- `∂f/∂xᵢ` is the partial derivative of function f with respect to variable xᵢ
- `∂f/∂xⱼ` is the partial derivative of function f with respect to variable xⱼ  
- `cov(xᵢ, xⱼ)` is the covariance between variables xᵢ and xⱼ
- For i = j, `cov(xᵢ, xᵢ) = var(xᵢ)` (variance of variable xᵢ)

The partial derivatives are computed automatically using SymPy's symbolic differentiation.

## 🚀 Features

- **Multi-variable support**: Handle functions with up to 10 variables
- **Automatic differentiation**: Partial derivatives computed symbolically
- **Interactive input**: Step-by-step data entry with validation
- **Comprehensive output**: Displays function, variables, variances, covariances, and results
- **Data export**: Download input data and results as a text file
- **Error propagation**: Accurate uncertainty calculation using covariance matrices

## 📦 Requirements

- Python 3.6 or higher
- NumPy
- SymPy

Install dependencies:
```bash
pip install numpy sympy
```

## 🎯 Usage

1. Run the application
2. Enter the number of variables (maximum 10)
3. Input your mathematical function using variable names (a, b, c, etc.)
4. Provide values for each variable
5. Enter variances for each variable
6. Input covariances between variable pairs
7. View calculated variance and standard deviation
8. Optionally download the results

## 📊 Example

**Input:**
```
Number of variables: 2
Function: a + b
Variable values: a = 1, b = 2
Variances: var(a) = 1, var(b) = 4
Covariances: cov(a,b) = 3
```

**Output:**
```
Function: a + b
Variable values:
  a: 1
  b: 2
Variances:
  a: 1
  b: 4
Covariances:
  a-b: 3

Variance = 10
Standard deviation = 3.162277660168379
```

**Calculation breakdown:**
- ∂f/∂a = 1, ∂f/∂b = 1
- var(f) = (1×1×1) + (1×1×4) + (1×1×3) + (1×1×3) = 1 + 4 + 3 + 3 = 10

## 🔬 Applications

This tool is useful for:
- **Scientific measurements**: Propagating experimental uncertainties
- **Engineering calculations**: Analyzing measurement errors in complex systems
- **Statistical analysis**: Understanding how input uncertainties affect results
- **Quality control**: Assessing precision in manufacturing processes
- **Research**: Error analysis in mathematical modeling

## 📁 File Structure

```
error-measurement/
├── README.md
├── main.py              # Core calculation logic
├── requirements.txt     # Dependencies
└── examples/           # Usage examples
```
