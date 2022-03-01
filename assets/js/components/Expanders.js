import { debounce } from 'lodash-es';
import { slideUp, slideDown } from '../global/utilities/slideUpDown';

export class Expanders {
  constructor() {
    this.attributes = {
      container: 'data-expander',
      button: 'data-expander-button',
      parent: 'data-expander-parent',
      child: 'data-expander-child',
    };

    //  Bind event listeners
    this.handleClick = this.handleClick.bind(this);
    this.handleResize = debounce(this.handleResize.bind(this), 250);
  }

  start() {
    this.listenForClick();
    this.listenForResize();
  }

  listenForClick() {
    document.body.addEventListener('click', this.handleClick, {
      capture: true,
    });
  }

  handleClick(event) {
    const button = this.getButtonFromClick(event);
    const container = this.getContainerFromElement(event.target);
    if (!button || !container) return;

    event.preventDefault();
    event.stopPropagation();

    this.toggleExpander(button, container);
  }

  getButtonFromClick(event) {
    return event.target.closest(`[${this.attributes.button}]`);
  }

  getContainerFromElement(element) {
    return element.closest(`[${this.attributes.container}]`);
  }

  toggleExpander(button, container) {
    const shouldExpand = button.getAttribute('aria-expanded') !== 'true';

    if (shouldExpand) {
      this.expand(button, container);
    } else {
      this.contract(button, container);
    }
  }

  expand(button, container) {
    const parent = container.querySelector(`[${this.attributes.parent}]`);
    const child = container.querySelector(`[${this.attributes.child}]`);
    if (!parent || !child) return console.error('Parent or child not found');

    slideDown(parent, child);

    button.setAttribute('aria-expanded', 'true');
  }

  contract(button, container) {
    const parent = container.querySelector(`[${this.attributes.parent}]`);
    if (!parent) return console.error('Parent not found');

    slideUp(parent);

    button.setAttribute('aria-expanded', 'false');
    button.focus();
  }

  listenForResize() {
    window.addEventListener('resize', this.handleResize);
  }

  handleResize() {
    const openButtons = Array.from(
      document.querySelectorAll(
        `[${this.attributes.button}][aria-expanded="true"]`
      )
    );

    openButtons.forEach(button => {
      const container = this.getContainerFromElement(button);
      if (!container) return;

      this.expand(button, container);
    });
  }
}
