//  See: https://hackernoon.com/removing-that-ugly-focus-ring-and-keeping-it-too-6c8727fefcd2

export class keyboardFocus {
  constructor() {
    this.tabbingAttr = 'data-tabbing';

    this.handleKeydown = this.handleKeydown.bind(this);
    this.handleMousedown = this.handleMousedown.bind(this);
  }

  init() {
    this.listenForKeydown();
  }

  listenForKeydown() {
    window.addEventListener('keydown', this.handleKeydown);
  }

  handleKeydown(event) {
    //  Look for tab key
    if (event.keyCode !== 9) return;

    document.documentElement.setAttribute(this.tabbingAttr, '');

    window.removeEventListener('keydown', this.handleKeydown);
    window.addEventListener('mousedown', this.handleMousedown);
  }

  handleMousedown() {
    document.documentElement.removeAttribute(this.tabbingAttr);

    window.removeEventListener('mousedown', this.handleMousedown);
    this.listenForKeydown();
  }
}
