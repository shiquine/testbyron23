export class DetectTouch {
  constructor() {
    this.attributes = {
      touch: 'data-touch',
    };

    //  Bind event listeners
    this.handleTouchStart = this.handleTouchStart.bind(this);
  }

  start() {
    this.listenForTouchStart();
  }

  listenForTouchStart() {
    document.body.addEventListener('touchstart', this.handleTouchStart, {
      capture: true,
    });
  }

  handleTouchStart() {
    document.body.setAttribute(this.attributes.touch, '');
    document.body.removeEventListener('touchstart', this.handleTouchStart, {
      capture: true,
    });
  }
}
