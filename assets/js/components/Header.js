//  See: https://css-tricks.com/how-to-detect-when-a-sticky-element-gets-pinned/

export class Header {
  constructor() {
    this.attributes = {
      container: 'data-header',
      sticky: 'data-sticky',
    };

    this.container = document.querySelector(`[${this.attributes.container}]`);

    this.observer = false;

    //  Bind event listeners
    this.handleIntersection = this.handleIntersection.bind(this);
  }

  start() {
    if (!this.container) return;

    this.setUpObserver();
    this.observeHeader();
  }

  setUpObserver() {
    this.observer = new IntersectionObserver(this.handleIntersection, {
      rootMargin: `0px 0px 0px 0px`, // use the whole window
      threshold: 1, // whole animation must be in view
    });
  }

  handleIntersection(entries) {
    entries.forEach(entry => {
      const { target, isIntersecting } = entry;

      if (isIntersecting) {
        target.removeAttribute(this.attributes.sticky);
      } else {
        target.setAttribute(this.attributes.sticky, '');
      }
    });
  }

  observeHeader() {
    this.observer.observe(this.container);
  }
}
