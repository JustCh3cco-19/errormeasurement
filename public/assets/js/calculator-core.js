(function (root, factory) {
  var api = factory();
  if (typeof module === 'object' && module.exports) module.exports = api;
  else root.CalculatorCore = api;
}(typeof self !== 'undefined' ? self : this, function () {
  'use strict';
  function isPositiveSemidefinite(matrix, tolerance) {
    tolerance = tolerance === undefined ? 1e-10 : tolerance;
    var n = matrix.length;
    if (!n || matrix.some(function (row) { return row.length !== n; })) return false;
    var lower = Array.from({length: n}, function () { return Array(n).fill(0); });
    for (var i = 0; i < n; i++) {
      for (var j = 0; j <= i; j++) {
        if (!Number.isFinite(matrix[i][j]) || Math.abs(matrix[i][j] - matrix[j][i]) > tolerance) return false;
        var sum = matrix[i][j];
        for (var k = 0; k < j; k++) sum -= lower[i][k] * lower[j][k];
        if (i === j) {
          if (sum < -tolerance) return false;
          lower[i][j] = Math.sqrt(Math.max(0, sum));
        } else if (lower[j][j] > tolerance) lower[i][j] = sum / lower[j][j];
        else if (Math.abs(sum) > tolerance) return false;
      }
    }
    return true;
  }
  function propagatedVariance(gradient, covariance) {
    if (gradient.length !== covariance.length) throw new Error('Incompatible dimensions.');
    var result = 0;
    for (var i = 0; i < gradient.length; i++) {
      for (var j = 0; j < gradient.length; j++) result += gradient[i] * covariance[i][j] * gradient[j];
    }
    return result;
  }
  return {isPositiveSemidefinite: isPositiveSemidefinite, propagatedVariance: propagatedVariance};
}));
