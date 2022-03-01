import { cleanDOM } from '../global/utilities/cleanDOM';
import { fetchWithTimeout } from '../global/utilities/fetchWithTimeout';
import { parseHTMLDocument } from '../global/utilities/parseHTMLDocument';

export class Locations {
  constructor() {
    this.attributes = {
      container: 'data-locations',
      button: 'data-location-button',
      form: 'data-location-form',
      results: 'data-locations-results',
      loading: 'data-loading',
    };

    this.container = document.querySelector(`[${this.attributes.container}]`);
    this.results = false;

    //  Bind event listeners
    this.handleClick = this.handleClick.bind(this);
    this.handleCoordinates = this.handleCoordinates.bind(this);
    this.handleError = this.handleError.bind(this);
  }

  start() {
    this.getResults();
    this.listenForClick();
  }

  getResults() {
    this.results = document.querySelector(`[${this.attributes.results}]`);
  }

  listenForClick() {
    document.body.addEventListener('click', this.handleClick, {
      capture: true,
    });
  }

  handleClick(event) {
    const button = this.getButtonFromClick(event);
    if (!button) return;

    event.preventDefault();
    event.stopPropagation();

    this.enterLoadingState();
    this.requestLocation();
  }

  getButtonFromClick(event) {
    return event.target.closest(`[${this.attributes.button}]`);
  }

  requestLocation() {
    navigator.geolocation.getCurrentPosition(
      this.handleCoordinates,
      this.handleError
    );
  }

  async handleCoordinates(position) {
    try {
      const DOM = await this.fetchLocations(position);
      this.swapLocationsFromDOM(DOM);
      this.exitLoadingState();
    } catch (error) {
      this.handleError();
    }
  }

  enterLoadingState() {
    this.container.setAttribute(this.attributes.loading, '');
  }

  exitLoadingState() {
    this.container.removeAttribute(this.attributes.loading);
  }

  async fetchLocations(position) {
    const { latitude, longitude } = position.coords;
    const url = `${this.getRequestURL()}/lng:${longitude}/lat:${latitude}`;

    const response = await fetchWithTimeout(url, {
      timeout: 8000,
      method: 'GET',
      credentials: 'same-origin',
      headers: {
        Accept: 'text/html, application/xhtml+xml',
      },
    });

    const networkError = await !response.ok;
    if (networkError) {
      throw new Error('Network error');
    }

    const rawDOM = parseHTMLDocument(await response.text());
    const DOM = cleanDOM(rawDOM);

    return DOM;
  }

  swapLocationsFromDOM(DOM) {
    const newResults = DOM.querySelector(`[${this.attributes.results}]`);

    if (!newResults) {
      throw new Error('Results not found');
    }

    this.results.parentNode.replaceChild(newResults, this.results);
    this.getResults();
  }

  getRequestURL() {
    const form = document.querySelector(`[${this.attributes.form}]`);
    const base = form.action;

    return base;
  }

  //  There a few different errors here but in any case, it hasn’t worked
  //  See: https://developer.mozilla.org/en-US/docs/Web/API/GeolocationPositionError
  handleError() {
    const message =
      'Your location could not be accessed. Please try searching instead.';

    const url = `${this.getRequestURL()}/error:${encodeURI(message)}`;

    //  Go to this location
    //  TODO: AJAX load it, or send to PageLoader?
    window.location.href = url;
  }
}
