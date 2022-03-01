//
//  polyfills.js

//  Stable JavaScript features
import 'core-js/es';

//  Required methods only
// import "core-js/es/array/from";
// import "core-js/es/array/find";
// import "core-js/es/array/find-index";

//  Fetch
import 'whatwg-fetch';

//  Intersection Observer
import 'intersection-observer';

//  Responsive Images (srcset and <picture>)
import 'lazysizes/plugins/respimg/ls.respimg';

//  Remove
//  https://developer.mozilla.org/en-US/docs/Web/API/ChildNode/remove
//  https://github.com/zloirock/core-js/issues/718

/* eslint-disable */
(function (arr) {
  arr.forEach(function (item) {
    if (item.hasOwnProperty("remove")) {
      return;
    }
    Object.defineProperty(item, "remove", {
      configurable: true,
      enumerable: true,
      writable: true,
      value: function remove() {
        if (this.parentNode === null) {
          return;
        }
        this.parentNode.removeChild(this);
      },
    });
  });
})([Element.prototype, CharacterData.prototype, DocumentType.prototype]);
/* eslint-enable */
