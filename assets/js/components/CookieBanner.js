//  See: https://github.com/michnhokn/kirby3-cookie-banner

import Cookies from 'js-cookie';

export class CookieBanner {
  constructor() {
    this.attributes = {
      container: 'data-cookie-banner',
      close: 'data-cookie-close',
      hidden: 'data-hidden',
    };

    this.container = document.querySelector(`[${this.attributes.container}]`);
    this.close = document.querySelector(`[${this.attributes.close}]`);

    this.cookieName = 'byron_cookie_notice';

    //  Bind event listeners
    this.handleClick = this.handleClick.bind(this);
  }

  start() {
    this.checkCookiesOnLoad();
    this.listenForClick();
  }

  checkCookiesOnLoad() {
    //  Check for the cookie up front, and if it doesn’t exist quit, because
    //  the banner should be showing
    const cookie = Cookies.get(this.cookieName);

    if (cookie) {
      //  If the cookie is set, make sure the banner is hidden. It should be.
      this.container.setAttribute(this.attributes.hidden, '');
    } else {
      //  Else, show it
      this.container.removeAttribute(this.attributes.hidden);
    }
  }

  listenForClick() {
    document.body.addEventListener('click', this.handleClick, {
      capture: true,
    });
  }

  handleClick(event) {
    const button = this.getCloseButtonFromClick(event);
    if (!button) return;

    event.preventDefault();
    event.stopPropagation();

    this.closeCookieBanner();
  }

  getCloseButtonFromClick(event) {
    return event.target.closest(`[${this.attributes.close}]`);
  }

  closeCookieBanner() {
    Cookies.set(this.cookieName, true, { expires: 90 });
    this.container.setAttribute(this.attributes.hidden, '');
  }
}
