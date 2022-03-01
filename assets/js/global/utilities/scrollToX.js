/*------------------------------------------------------------------------------

  scrollToX.js

  Based on: http://stackoverflow.com/questions/8917921/cross-browser-javascript-
  not-jquery-scroll-to-top-animation#answer-26808520

  Usage:
  scrollToX(el, 0, 0.8, 'easeInOutQuint');

  ----------------------------------------------------------------------------*/

export function scrollToX(
  el,
  target = 0,
  timing = 0.8,
  easing = 'easeInOutQuint'
) {
  //  Only continue if required params are passed
  if (!el) return console.warn('scrollToX — no element found');

  return new Promise(resolve => {
    const scrollX = el.scrollLeft;
    let currentTime = 0;

    //  Easing equations
    //  https://github.com/danro/easing-js/blob/master/easing.js
    const easingEquations = {
      easeOutSine(pos) {
        return Math.sin(pos * (Math.PI / 2));
      },
      easeInOutSine(pos) {
        return -0.5 * (Math.cos(Math.PI * pos) - 1);
      },
      easeInOutQuint(pos) {
        if ((pos /= 0.5) < 1) {
          return 0.5 * Math.pow(pos, 5);
        }
        return 0.5 * (Math.pow(pos - 2, 5) + 2);
      },
    };

    //  Animation loop
    function tick() {
      currentTime += 1 / 60;

      const p = currentTime / timing;
      const t = easingEquations[easing](p);

      if (p < 1) {
        requestAnimationFrame(tick);
        el.scrollLeft = scrollX + (target - scrollX) * t;
      } else {
        el.scrollLeft = target;
        resolve();
      }
    }

    //  Call animation loop once to begin
    tick();
  });
}
