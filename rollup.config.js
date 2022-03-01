//
//  rollup.config.js

//  Import Rollup plugins so node modules can be imported, made compatible
//  with ES6, and used in bundles.
//  See: https://github.com/rollup/plugins/tree/master/packages/commonjs
//  See: https://github.com/rollup/plugins/tree/master/packages/node-resolve
import commonjs from '@rollup/plugin-commonjs';
import nodeResolve from '@rollup/plugin-node-resolve';

const input =
  process.env.BUILD === 'polyfills'
    ? 'assets/js/polyfills.js'
    : 'assets/js/main.js';
const sourcemap = process.env.BUILD === 'dev';

//  Polyfills should be wrapped in an IIFE to stop infinite reloading (see https://github.com/zloirock/core-js/issues/627).
//  The main bundle can be 'es' if a global function is needed
const format = process.env.BUILD === 'polyfills' ? 'iife' : 'iife';

export default {
  input,
  output: {
    format,
    sourcemap,
  },
  plugins: [
    nodeResolve(), //  import external scripts from NPM
    commonjs(), // convert CommonJS modules to ES6
  ],
};
