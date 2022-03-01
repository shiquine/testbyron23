export class Gallery {
  constructor({ container, delay = 4000, transitionTiming = 1000 }) {
    this.attributes = {
      item: `data-gallery-item`,
      current: 'data-current',
      prev: 'data-prev',
    };

    this.container = container;
    this.items = Array.from(
      container.querySelectorAll(`[${this.attributes.item}]`)
    );
    this.count = this.items.length;
    this.isSingular = this.count <= 1;
    this.delay = delay;
    this.transitionTiming = transitionTiming;
    this.index = 0;

    this.timeout = false;
    this.interval = false;
  }

  mount() {
    //  There is nothing to do if there is only one item
    if (!this.container || !this.items.length || this.isSingular) return;

    this.setUpInterval();
  }

  setUpInterval() {
    this.interval = setInterval(() => {
      this.goNext();
    }, this.delay);
  }

  goNext() {
    //  Loop back round if at the start
    this.index = this.index === this.count - 1 ? 0 : this.index + 1;
    this.setActiveItem();
  }

  setActiveItem() {
    this.items.forEach((item, index) => {
      const isCurrent = index === this.index;
      const isPrev =
        index === this.index - 1 ||
        (this.index === 0 && index === this.count - 1);

      if (isCurrent) {
        this.makeItemActive(item);
      } else if (isPrev) {
        this.makeItemPrev(item);
      } else {
        this.makeItemInactive(item);
      }
    });
  }

  makeItemActive(item) {
    item.removeAttribute(this.attributes.prev);
    item.setAttribute(this.attributes.current, '');
    item.removeAttribute('hidden');
  }

  makeItemPrev(item) {
    item.removeAttribute(this.attributes.current);
    item.setAttribute(this.attributes.prev, '');

    this.timeout = setTimeout(() => {
      item.setAttribute('hidden', '');
    }, this.transitionTiming);
  }

  makeItemInactive(item) {
    item.removeAttribute(this.attributes.prev);
    item.removeAttribute(this.attributes.current);
    item.setAttribute('hidden', '');
  }

  destroy() {
    clearInterval(this.interval);
    clearTimeout(this.timeout);
  }
}
