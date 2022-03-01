/*------------------------------------------------------------------------------

  browserSupports.js

  Returns whether a browser supports an array of features.

  See: https://philipwalton.com/articles/loading-polyfills-only-when-needed/

  Usage:
  browserSupports([
    window.Promise,
    window.fetch,
  ]);

  ----------------------------------------------------------------------------*/

export function browserSupports(features) {
  let verdict = true;

  features.forEach(feature => {
    if (!feature) verdict = false;
  });

  return verdict;
}
