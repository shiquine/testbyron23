import Cookies from 'js-cookie';
import * as focusTrap from 'focus-trap';
import { noScroll } from '../global/utilities/noScroll';

export class Modal {
  constructor({ container, setCookie = false, allowScroll = false }) {
    this.attributes = {
      container: 'data-modal',
      close: 'data-modal-close',
      inner: 'data-modal-inner',
      active: 'data-active',
      delay: 'data-delay',
    };

    this.container = container;
    this.inner = this.container
      ? container.querySelector(`[${this.attributes.inner}]`)
      : false;
    this.id = this.container
      ? this.container.getAttribute(this.attributes.container)
      : false;

    this.delayInSeconds = this.container.hasAttribute(this.attributes.delay)
      ? parseFloat(this.container.getAttribute(this.attributes.delay))
      : 0;

    this.timeout = false;

    this.allowScroll = allowScroll;
    this.focusTrap = false;

    this.setCookie = setCookie;
    this.cookieName = `byron_modal_${this.id}`;
    this.hasBeenSeenBefore = Cookies.get(this.cookieName);

    //  Bind event listeners
    this.handleClick = this.handleClick.bind(this);
    this.handleKeydown = this.handleKeydown.bind(this);
  }

  mount() {
    if (!this.container || !this.id || !this.inner) return;

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
      preventScroll: true,
    });
  }

  handleClick(event) {
    //  Run the check on a click outside before the navicon so the menu
    //  is not open by the time it runs
    this.handleOutsideClick(event);

    this.handleCloseClick(event);
  }

  handleOutsideClick(event) {
    if (!this.modalIsOpen()) return;

    const innerContainsClick = this.inner.contains(event.target);

    if (!innerContainsClick) {
      event.preventDefault();
      event.stopPropagation();

      this.close();
    }
  }

  handleCloseClick(event) {
    const button = this.getCloseButtonFromClick(event);
    if (!button) return;

    event.preventDefault();
    event.stopPropagation();

    this.close();
  }

  modalIsOpen() {
    return this.container.hasAttribute(this.attributes.active);
  }

  getCloseButtonFromClick(event) {
    return event.target.closest(`[${this.attributes.close}]`);
  }

  openAfterDelay({ checkCookie = true }) {
    if (checkCookie && this.hasBeenSeenBefore) return;

    this.timeout = setTimeout(() => {
      this.open();
    }, this.delayInSeconds * 1000);
  }

  open() {
    this.container.setAttribute(this.attributes.active, '');

    if (!this.allowScroll) noScroll(true);

    this.focusTrap.activate();

    window.addEventListener('keydown', this.handleKeydown);

    if (this.setCookie) {
      Cookies.set(this.cookieName, true, { expires: 90 });
    }
  }

  close() {
    this.container.removeAttribute(this.attributes.active);

    if (!this.allowScroll) noScroll(false);

    this.focusTrap.deactivate();

    window.removeEventListener('keydown', this.handleKeydown);
  }

  handleKeydown(event) {
    if (event.keyCode === 27) {
      this.close();
    }
  }

  destroy() {
    clearTimeout(this.timeout);
    this.close();
  }
}
