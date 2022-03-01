/*------------------------------------------------------------------------------

  loadScript.js

  Creates a script with a given src and loads it in the head of the page. Will
  optionally run a callback function when loaded.

  See: https://philipwalton.com/articles/loading-polyfills-only-when-needed/

  Usage:
  loadScript('./assets/js/build/polyfills.js', main);

  ----------------------------------------------------------------------------*/

export function loadScript(src, done = false) {
  console.log('load script');

  const js = document.createElement('script');
  js.src = src;

  if (done) {
    js.onload = function() {
      done();
    };

    js.onerror = function() {
      done(`Failed to load script ${src}`);
    };
  }

  document.head.appendChild(js);
}
