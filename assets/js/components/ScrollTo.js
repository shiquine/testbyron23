import { scrollToY } from '../global/utilities/scrollToY';

export class ScrollTo {
  constructor() {
    //  elementsToSkip should be a querySelector string
    this.elementsToSkip = '[data-header]';

    this.timing = {
      min: 0.75,
      max: 1.25,
    };
    this.timeout = false;

    this.attrs = {
      link: 'data-scroll-to',
      scrolledTo: 'data-scrolled-to',
    };

    this.supportsSmoothScrolling =
      'scrollBehavior' in document.documentElement.style;

    //  Bind events
    this.handleClick = this.handleClick.bind(this);
  }

  start() {
    this.listenForClick();
  }

  listenForClick() {
    document.body.addEventListener('click', this.handleClick, {
      capture: true,
    });
  }

  handleClick(event) {
    const link = this.getLinkFromClick(event);
    if (!link) return;

    const id = this.getIDFromLink(link);
    if (!id) return console.warn('id not found');

    this.scrollToSelector({ id, event });
  }

  getLinkFromClick(event) {
    return event.target.closest(`[${this.attrs.link}]`);
  }

  getIDFromLink(link) {
    const id = link.getAttribute(this.attrs.link) || link.getAttribute('href');
    if (!id) return false;

    const cleanedID = this.cleanID(id);
    return cleanedID;
  }

  cleanID(id) {
    //  Remove '#' character from the start of the string
    if (id.charAt(0) === '#') {
      id = id.substring(1);
    }

    //  Escape ':' in ID otherwise querySelector won’t work
    //  See: https://developer.mozilla.org/en-US/docs/Web/API/Document/querySelector
    id = id.replace(':', '\\:');

    return id;
  }

  scrollToSelector({
    el = false,
    id = false,
    event = false,
    scrollTiming = false,
  }) {
    const element = el || document.querySelector(`#${id}`);
    if (!element) return console.warn('element not found');

    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }

    const scrollTarget = this.getScrollTarget(element);
    const timing = scrollTiming || this.getTiming(scrollTarget);

    this.scrollToTarget({
      element,
      target: scrollTarget,
      timing,
    });
  }

  getScrollTarget(target) {
    const padding = this.getElementsToSkipHeight();
    return target.getBoundingClientRect().top + window.scrollY - padding;
  }

  getElementsToSkipHeight() {
    let padding = 0;

    const elements = Array.from(
      document.querySelectorAll(`${this.elementsToSkip}`)
    );

    elements.forEach(element => {
      if (!element) return;
      padding += element.offsetHeight;
    });

    return padding;
  }

  getTiming(scrollTarget) {
    //  Every 1000 px scroll gives 500ms
    let timing = (0.5 * (scrollTarget / 1000)).toFixed(1);

    if (timing < this.timing.min) {
      timing = this.timing.min;
    }

    if (timing > this.timing.max) {
      timing = this.timing.max;
    }

    return timing;
  }

  scrollToTarget({ element, target, timing }) {
    //  Focus the element before scrollToY because Safari does not yet (06/21)
    //  support the `preventScroll` option. Otherwise scroll will jump after
    //  the smooth scroll has finished
    this.focusElement(element);

    if (this.supportsSmoothScrolling) {
      scrollToY(target, timing, 'easeInOutQuint').then(() => {
        this.handleScrolledToAttribute(element, timing);
      });
    } else {
      window.scrollTo({ top: target, left: 0 });
      this.handleScrollToAttribute(element, 0.5);
    }
  }

  focusElement(element) {
    //  Make sure the element is focusable by adding tabindex
    element.setAttribute('tabindex', '-1');
    element.focus({ preventScroll: true });
  }

  handleScrolledToAttribute(target, timing) {
    target.setAttribute(this.attrs.scrolledTo, '');

    this.timeout = setTimeout(() => {
      //  Check the target as it could’ve been removed during this timeout
      if (target) target.removeAttribute(this.attrs.scrolledTo);
    }, timing * 1000); // convert to ms
  }

  //  ? This can be used post PageLoad to scroll to a hash
  scrollToHashFromURL(url) {
    const { hash } = new URL(url);

    if (hash) {
      //  Cut the '#' off the beginning of the hash, send 'the-id'
      //  not '#the-id'
      this.scrollToSelector({ id: hash.substr(1) });
    }
  }
}
