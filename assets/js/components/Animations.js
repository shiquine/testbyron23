//  See: https://airbnb.io/lottie/#/web
//  TODO: Get the Focus/Blur animation to work on hover too — once the navicon animation comes in

import lottie from 'lottie-web/build/player/lottie_light';
import { debounce, throttle } from 'lodash-es';
import { isURLFromSameDomain } from '../global/utilities/isURLFromSameDomain';
import { getWindowDimensions } from '../global/utilities/getWindowDimensions';

export class Animations {
  constructor() {
    this.attributes = {
      autoplay: 'data-autoplay',
      container: 'data-animation',
      path: 'data-path',
      hover: 'data-hover',
      loop: 'data-loop',
      reveal: 'data-reveal',
      scroll: 'data-scroll',
    };

    this.containers = [];
    this.animations = [];

    this.observer = false;

    this.windowDimensions = getWindowDimensions();
    this.lastScrollPosition = window.scrollY;

    this.prefersReducedMotion = window.matchMedia(
      '(prefers-reduced-motion: reduce)'
    ).matches;

    //  Bind event listeners
    this.handleIntersection = this.handleIntersection.bind(this);
    this.handleResize = debounce(this.handleResize.bind(this), 250);
    this.handleFocus = this.handleFocus.bind(this);
    this.handleBlur = this.handleBlur.bind(this);

    //  Throttle the animate function to 60fps
    this.animate = throttle(this.animate.bind(this), 16);

    //  Set animation quality to low to improve performance
    lottie.setQuality('low');
  }

  init() {
    this.start();
    this.listenForResize();
  }

  start() {
    this.setVars();
    if (!this.containers.length) return;

    this.setUpObserver();
    this.setUpAnimations();
  }

  setVars() {
    this.containers = Array.from(
      document.querySelectorAll(`[${this.attributes.container}]`)
    );
    this.animations = [];
    this.observer = false;
  }

  setUpObserver() {
    this.observer = new IntersectionObserver(this.handleIntersection, {
      rootMargin: `0px 0px 0px 0px`, // use the whole window
      threshold: 1, // whole animation must be in view
    });
  }

  handleIntersection(entries) {
    entries.forEach(entry => {
      const { target: container, isIntersecting } = entry;

      const animationObject = this.findAnimationByContainer(container);
      if (!animationObject) return console.error('animation not found');

      //  Update whether the animation is currently visible
      animationObject.isVisible = isIntersecting;

      const { animation, isScrolling } = animationObject;

      //  Scrolling Animation
      if (isIntersecting && isScrolling) this.animate(animationObject);

      //  Static Animation
      if (isIntersecting && !isScrolling && !this.prefersReducedMotion) {
        animation.goToAndPlay(1, true);
      } else if (!isIntersecting && !isScrolling) {
        animation.goToAndStop(1, true);
      }
    });
  }

  animate(animationObject) {
    const { animation, isVisible } = animationObject;

    //  Stop running if this animation is no longer visible
    if (!isVisible) return;

    //  Quit if the scroll hasn’t changed
    if (this.scrollIsUnchanged())
      return this.animateOnNextFrame(animationObject);

    this.updateScrollPosition();

    const frame = this.getAnimationFrame(animationObject);
    animation.goToAndStop(frame, true);

    //  Keep calling
    this.animateOnNextFrame(animationObject);
  }

  scrollIsUnchanged() {
    const latestScroll = window.scrollY;
    return this.lastScrollPosition === latestScroll;
  }

  animateOnNextFrame(animationObject) {
    return window.requestAnimationFrame(() => {
      this.animate(animationObject);
    });
  }

  updateScrollPosition() {
    this.lastScrollPosition = window.scrollY;
  }

  getAnimationScrollDistance(animationObject, { top: containerTop }) {
    const { containerHeight } = animationObject;
    const pageHeight = document.documentElement.scrollHeight;

    //  The whole animation should be visible as it animates, so it should take
    //  place within the difference between the container height and the
    //  window height
    const containerToWindowHeightDifference =
      this.windowDimensions.height - containerHeight;

    //  If the animation is at the end of the page though, the rest of the
    //  distance available could be less than this
    const containerToPageEndDistance =
      pageHeight - (containerTop + this.lastScrollPosition + containerHeight);

    //  Find the minimum between these two
    const scrollDistance = Math.min(
      containerToWindowHeightDifference,
      containerToPageEndDistance
    );

    return scrollDistance;
  }

  getAnimationFrame(animationObject) {
    const { container, animation } = animationObject;
    const { totalFrames } = animation;
    const containerBounds = container.getBoundingClientRect();
    const windowHeight = this.windowDimensions.height;
    const { bottom: containerBottom } = containerBounds;

    //  Find how far we are scrolled since the animation has been in full view
    const distanceScrolled = windowHeight - containerBottom;

    //  Find the total distance the animation should take place within
    const totalScrollDistance = this.getAnimationScrollDistance(
      animationObject,
      containerBounds
    );

    //  The percentage is between 0 and 1
    const percentageScrolled = distanceScrolled / totalScrollDistance;

    const targetFrame = (totalFrames * percentageScrolled).toFixed();

    //  Cap the frame between the first and last
    const frame = Math.min(Math.max(targetFrame, 1), totalFrames - 1);

    return frame;
  }

  setUpAnimations() {
    this.containers.forEach(container => {
      this.setUpAnimation(container);
    });
  }

  setUpAnimation(container) {
    const inner = container.querySelector(`[${this.attributes.path}]`);
    const animationContainer = inner || container;

    const path =
      animationContainer.getAttribute(this.attributes.container) ||
      animationContainer.getAttribute(this.attributes.path);
    const autoplay =
      animationContainer.getAttribute(this.attributes.autoplay) === 'true' &&
      !this.prefersReducedMotion;
    const loop =
      animationContainer.getAttribute(this.attributes.loop) === 'true' &&
      !this.prefersReducedMotion;

    if (!isURLFromSameDomain(path))
      return console.log('path from wrong domain');

    const animation = lottie.loadAnimation({
      container: animationContainer,
      renderer: 'svg',
      loop,
      autoplay,
      path,
      rendererSettings: {
        preserveAspectRatio: 'xMidYMid meet',
        className: 'Animation',
      },
    });

    animation.addEventListener('data_ready', () => {
      this.handleLottieLoad(container, animationContainer, animation);
    });
  }

  handleLottieLoad(container, animationContainer, animation) {
    this.setContainerClass(container, animation);

    const isRevealing =
      animationContainer.getAttribute(this.attributes.reveal) === 'true';

    const isScrolling =
      animationContainer.getAttribute(this.attributes.scroll) === 'true';

    const isHover =
      animationContainer.getAttribute(this.attributes.hover) === 'true';

    //  Wait a hot second for the CSS change to take effect before measuring
    //  the height of the container
    setTimeout(() => {
      this.animations.push({
        container,
        animationContainer,
        containerHeight: animationContainer.offsetHeight,
        animation,
        isVisible: false,
        isScrolling,
        isHover,
      });

      if (isRevealing) {
        this.observer.observe(container);
      }

      if (isHover) {
        container.addEventListener('focus', this.handleFocus);
        container.addEventListener('blur', this.handleBlur);
      }
    }, 100);
  }

  setContainerClass(container, animation) {
    const { w: animationWidth, h: animationHeight } = animation.animationData;
    const ratio = animationHeight / animationWidth;

    if (ratio > 1.2) {
      container.setAttribute('data-tall', '');
    } else if (ratio < 0.8) {
      container.setAttribute('data-short', '');
    }
  }

  findAnimationByContainer(container) {
    return this.animations.find(item => item.container === container);
  }

  handleFocus(event) {
    const { target } = event;
    const animationObject = this.findAnimationByContainer(target);
    if (!animationObject) return console.error('animation not found');

    const { animation } = animationObject;
    animation.setDirection(1);
    animation.play();
  }

  handleBlur(event) {
    const { target } = event;
    const animationObject = this.findAnimationByContainer(target);
    if (!animationObject) return console.error('animation not found');

    const { animation } = animationObject;
    animation.setDirection(-1);
    animation.play();
  }

  listenForResize() {
    window.addEventListener('resize', this.handleResize);
  }

  handleResize() {
    this.windowDimensions = getWindowDimensions();

    this.animations.forEach(animationObject => {
      const { container } = animationObject;

      animationObject.containerHeight = container.offsetHeight;
    });
  }

  destroy() {
    lottie.destroy();
    if (this.observer) this.observer.disconnect();
  }
}
