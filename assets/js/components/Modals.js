import { Modal } from './Modal';

export class Modals {
  constructor() {
    this.attributes = {
      container: 'data-modal',
      close: 'data-modal-close',
      active: 'data-active',
    };

    this.containers = Array.from(
      document.querySelectorAll(`[${this.attributes.container}]`)
    );
    this.modals = [];
  }

  start() {
    if (!this.containers.length) return;

    this.createModals();

    //  There should only be one modal and we will open it after a delay
    this.openModalsAfterDelay();
  }

  createModals() {
    this.containers.forEach(container => {
      this.createModal(container);
    });
  }

  createModal(container) {
    const modal = new Modal({
      container,
      setCookie: true,
      allowScroll: true,
    });
    modal.mount();

    this.modals.push({
      container,
      modal,
    });
  }

  openModalsAfterDelay() {
    this.modals.forEach(({ modal }) => {
      modal.openAfterDelay({
        checkCookie: true,
      });
    });
  }
}
