'use strict';
const assert = require('assert');
const core = require('../public/assets/js/calculator-core.js');

assert.strictEqual(core.isPositiveSemidefinite([[1, 0], [0, 4]]), true);
assert.strictEqual(core.isPositiveSemidefinite([[1, 2], [2, 1]]), false);
assert.strictEqual(core.isPositiveSemidefinite([[1, -1], [-1, 1]]), true);
assert.strictEqual(core.isPositiveSemidefinite([[1, 0], [1, 1]]), false);

// f=a+b, gradient=[1,1], variances 1 and 4, covariance 1 => 7.
assert.strictEqual(core.propagatedVariance([1, 1], [[1, 1], [1, 4]]), 7);
// f=a*b at a=2,b=3: gradient=[3,2], independent variances 0.04 and 0.09.
assert.ok(Math.abs(core.propagatedVariance([3, 2], [[0.04, 0], [0, 0.09]]) - 0.72) < 1e-12);

console.log('calculator-core: all tests passed');
