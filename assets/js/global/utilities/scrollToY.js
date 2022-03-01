/*------------------------------------------------------------------------------

  scrollToY.js

  Based on: http://stackoverflow.com/questions/8917921/cross-browser-javascript-
  not-jquery-scroll-to-top-animation#answer-26808520

  Usage:
  scrollToY(0, 0.8, 'easeInOutQuint');

  ----------------------------------------------------------------------------*/

export function scrollToY(target = 0, timing = 0, easing = 'easeInOutQuint') {
  return new Promise(resolve => {
    const scrollY = window.scrollY || document.documentElement.scrollTop;
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
        window.scrollTo(0, scrollY + (target - scrollY) * t);
      } else {
        window.scrollTo(0, target);
        resolve();
      }
    }

    //  Call animation loop once to begin
    tick();
  });
}
