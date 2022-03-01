import { Gallery } from './Gallery';

export class Galleries {
  constructor() {
    this.containers = [];
    this.galleries = [];

    this.attrs = {
      container: `data-gallery`,
    };

    //  Bind event listeners
    this.handlePageLoad = this.handlePageLoad.bind(this);
  }

  init() {
    this.listenForPageLoad();
    this.start();
  }

  listenForPageLoad() {
    document.addEventListener('page-loader:load', this.handlePageLoad);
  }

  handlePageLoad() {
    this.destroy();
    this.start();
  }

  start() {
    this.setVars();
    this.setUpGalleries();
  }

  setVars() {
    this.containers = Array.from(
      document.querySelectorAll(`[${this.attrs.container}]`)
    );
  }

  setUpGalleries() {
    this.containers.forEach(container => {
      this.setUpGallery(container);
    });
  }

  setUpGallery(container) {
    const gallery = new Gallery({
      container,
      delay: 4000,
      transitionTiming: 1000,
    });

    gallery.mount();

    this.galleries.push(gallery);
  }

  destroy() {
    this.galleries.forEach(gallery => {
      gallery.destroy();
    });
  }
}
