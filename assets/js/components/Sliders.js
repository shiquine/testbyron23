//  See: https://splidejs.com/

import Splide from '@splidejs/splide';

export class Sliders {
  constructor() {
    this.splides = [];
    this.containers = [];

    this.attrs = {
      container: `data-slider`,
      slide: `data-slide`,
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
    this.setUpSplides();
  }

  setVars() {
    this.containers = Array.from(
      document.querySelectorAll(`[${this.attrs.container}]`)
    );
  }

  setUpSplides() {
    this.containers.forEach(container => {
      this.setUpSplide(container);
    });
  }

  setUpSplide(container) {
    const type = container.getAttribute(this.attrs.container) || 'menu';
    const options = this.getOptions(container, type);

    const slider = new Splide(container, options);

    slider.mount();

    this.splides.push(slider);
  }

  getOptions(container, type) {
    const isMenu = type === 'menu';
    const isCampaigns = type === 'campaigns';
    const isStories = type === 'stories';

    const slideCount = Array.from(
      container.querySelectorAll(`[${this.attrs.slide}]`)
    ).length;
    const isSingular = slideCount <= 1;

    if (isMenu) {
      return {
        drag: !isSingular,
        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
        pagination: false,
        type: isSingular ? 'slide' : 'loop',

        autoWidth: true,
        padding: 0,
        focus: 'center',
        gap: 'var(--gridGap)',

        breakpoints: {
          799: {
            autoWidth: false,
            width: '100%',
            padding: {
              right: 'var(--slidePaddingRight)',
              left: 'var(--slidePaddingLeft)',
            },
            focus: 0,
          },
        },
      };
    }

    if (isStories) {
      return {
        drag: !isSingular,
        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
        pagination: false,
        type: isSingular ? 'slide' : 'loop',

        autoWidth: true,
        padding: {
          left: 'var(--outsideEdge)',
          right: 'var(--outsideEdge)',
        },
        gap: 'var(--gridGap)',

        breakpoints: {
          // --maxWidthBasis + --margin + --margin
          1140: {
            padding: {
              left: 'var(--margin)',
              right: 'var(--margin)',
            },
          },
          799: {
            focus: 'center',
            padding: 0,
          },
        },
      };
    }

    if (isCampaigns) {
      return {
        drag: !isSingular,
        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
        pagination: false,
        type: isSingular ? 'slide' : 'loop',
        perPage: 1,
        padding: {
          left: 'var(--outsideEdge)',
          right: 'var(--outsideEdge)',
        },
        gap: 'var(--outsideEdge)',

        breakpoints: {
          // --maxWidthBasis + --margin + --margin
          1140: {
            padding: 0,
            gap: 0,
          },
        },
      };
    }
  }

  destroy() {
    this.splides.forEach(slider => {
      slider.destroy();
    });
  }
}
