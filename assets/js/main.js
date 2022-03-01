//
//  Global dependencies

/* global lazySizes */
import 'lazysizes';
import 'lazysizes/plugins/parent-fit/ls.parent-fit';

//
//  Base

// import { keyboardFocus } from './global/keyboardFocus';

//
//  Components

import { Animations } from './components/Animations';
import { Club } from './components/Club';
import { CookieBanner } from './components/CookieBanner';
import { DetectTouch } from './components/DetectTouch';
import { Expanders } from './components/Expanders';
import { Galleries } from './components/Galleries';
import { Header } from './components/Header';
import { Locations } from './components/Locations';
import { Modals } from './components/Modals';
import { Nav } from './components/Nav';
import { ScrollTo } from './components/ScrollTo';
import { Sliders } from './components/Sliders';
import { Videos } from './components/Videos';

//
//  Utilities

import { browserSupports } from './global/utilities/browserSupports';
import { loadScript } from './global/utilities/loadScript';

function init() {
  //  Handle Polyfills
  //  See: https://philipwalton.com/articles/loading-polyfills-only-when-needed/
  if (
    browserSupports([
      window.Promise,
      window.fetch,
      Array.from,
      window.HTMLPictureElement,
      window.IntersectionObserver,
    ])
  ) {
    main();
  } else {
    loadScript(
      `${window.top.location.protocol.toString()}//${window.top.location.host.toString()}/assets/js/build/polyfills.js`,
      main
    );
  }
}

function main(error = false) {
  //  Error handling from polyfill script
  if (error) console.error(error);

  //  Run global first
  // keyboardFocus.init();

  //  Then components
  new Animations().init();
  new Club().start();
  new CookieBanner().start();
  new DetectTouch().start();
  new Expanders().start();
  new Galleries().init();
  new Header().start();
  new Locations().start();
  new Modals().start();
  new Nav().start();
  new ScrollTo().start();
  new Sliders().init();
  new Videos().start();

  //  Run LazySizes now all plugins from polyfills will have loaded
  lazySizes.init();
}

//  Run
init();
