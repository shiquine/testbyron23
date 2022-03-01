import * as focusTrap from 'focus-trap';
import { noScroll } from '../global/utilities/noScroll';

export class Nav {
  constructor() {
    this.attributes = {
      button: 'data-nav-button',
      container: 'data-nav',
      open: 'data-has-nav-open',
    };

    this.container = document.querySelector(`[${this.attributes.container}]`);
    this.navicon = document.querySelector(
      `[${this.attributes.button}="navicon"]`
    );

    this.focusTrap = false;

    //  Bind event listeners
    this.handleClick = this.handleClick.bind(this);
    this.handleKeydown = this.handleKeydown.bind(this);
  }

  start() {
    if (!this.container || !this.navicon) return;

    this.listenForClick();
    this.setUpFocusTrap();
  }

  listenForClick() {
    document.body.addEventListener('click', this.handleClick, {
      capture: true,
    });
  }

  setUpFocusTrap() {
    this.focusTrap = focusTrap.createFocusTrap(this.container, {
      initialFocus: this.container,
      fallbackFocus: this.container,
      escapeDeactivates: false,
      clickOutsideDeactivates: false,
      setReturnFocus: this.navicon,
      preventScroll: true,
    });
  }

  handleClick(event) {
    const button = this.getButtonFromClick(event);
    if (!button) return;

    event.preventDefault();
    event.stopPropagation();

    const forceClose = button.getAttribute(this.attributes.button) === 'close';

    this.toggleNav(forceClose);
  }

  getButtonFromClick(event) {
    return event.target.closest(`[${this.attributes.button}]`);
  }

  toggleNav(forceClose = false) {
    if (this.menuIsOpen() || forceClose) {
      this.closeMenu();
    } else {
      this.openMenu();
    }
  }

  menuIsOpen() {
    return document.body.hasAttribute(this.attributes.open);
  }

  closeMenu() {
    document.body.removeAttribute(this.attributes.open);

    this.navicon.setAttribute('aria-expanded', 'false');

    this.navicon.focus({
      preventScroll: true,
    });

    noScroll(false);

    this.focusTrap.deactivate();

    window.removeEventListener('keydown', this.handleKeydown);
  }

  openMenu() {
    document.body.setAttribute(this.attributes.open, '');

    this.navicon.setAttribute('aria-expanded', 'true');

    noScroll(true);

    this.focusTrap.activate();

    window.addEventListener('keydown', this.handleKeydown);
  }

  handleKeydown(event) {
    if (event.keyCode === 27) {
      this.closeMenu();
    }
  }
}
