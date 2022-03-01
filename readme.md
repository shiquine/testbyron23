# Byron

**Byron** is the Kirby build for https://byron.co.uk.

## Requirements

- Node JS <https://nodejs.org/>
- NPM <https://www.npmjs.com/>
- Yarn <https://yarnpkg.com/>
- Browser Sync <https://www.browsersync.io/>
- MAMP <https://www.mamp.info/>
- For Kirby requirements, see: https://getkirby.com/docs/guide/quickstart

## Installation

To clone the site to your local machine, open your terminal, navigate to the appropriate parent folder and run: `git clone --recursive https://github.com/chris-corby/byron.git`.

## Development Setup

- To install all development dependencies, navigate to this folder in your terminal and run `yarn install`.
- To watch and compile CSS and JS files during development, run `yarn start`.
- To use BrowserSync, spin up MAMP running on localhost:8888. Run `yarn run sync` and open [http://localhost:3000](http://localhost:3000) in your browser.
- Visit `/panel` on the 8888 port to set up the first user and make content changes
- To create the CSS and JS files for production, run `yarn run build:css`, `yarn run build:js`, and `yarn run build:js:polyfills`.

## Hosting & Domain

The server is managed by mnit.co.uk.

- Based around London (no CDN)
- Runs Litespeed as the server software
- Takes daily backups and stores them for two weeks
- Is pretty well powered, has a large SSD

cPanel URL: https://host01.byron.co.uk:2083/

For any issues, contact Cristian Mocanu, `Cristian@mnit.co.uk`

SSH/SFTP is blocked on the server unless the IP address is whitelisted. FTP is open instead, but it may have been closed for security reasons. If it is closed, contact Cristian to open it up, or just try and use the cPanel file uploader instead.

## Updating

1. Check you are working on the correct branch
1. Check for updates to packages by running `yarn upgrade-interactive --latest`
1. Run `yarn upgrade` to upgrade individual packages
1. Check that all packages are as up to date on security releases by running `yarn audit`
1. To update the Kirby installation, run `./update.sh`.

## Users

chris / cc@chris-corby.com / `hoizddaVqHGZmTPK7qVq7M3AZvCVCTETwWcY6ounZfdWuAAQAQvXp3JKnTBDdrfQ`

guillem / info@matallanas.com / `kzDU4K8hVcWxeVkY337H4gFrXHGsDQufAwwBMYdwWovXM8gHunWUuva8osCTaQ8D`

Natalie Beer / NBeer@famouslyproper.co.uk / `AcsdGQ4gAe4ybvZsTzKErfxt8RzzWdcMExRDpryN7HATAd9ge4V6cNFcozPDsqHm`

Shauna Barry / SBarry@famouslyproper.co.uk / `webJGs8oXk3pg3mjZPZ7zwjKZCKWEzsCED8gByntBtPQtWwDgvHcZjYN7wLuWqa7`

Denis Lak / Dlak@famouslyproper.co.uk / `cWEG2y9J7orenRMaLkBtsUZCMjNartpAJGdZvxvPTKNoGAVs4mobNv9NRAfUuVMf`

Santi / Sochoa@famouslyproper.co.uk / `fgixWyUy6jPdi8hKkN7rMCL2VLPdvybgkBDoBdhEUXg3p8faMoaXGzRwUYvXozVC`

## Staging

- URL: staging.byron.co.uk
- Panel: staging.byron.co.uk/panel
- Username: `staging`
- Password: `staging`

## Contacts

- Project Management: Simran Sablok (Byron): <SSablok@famouslyproper.co.uk>
- Design: Guillem Matallanas (freelance): <info@matallanas.com>
- Development: Chris Corby (freelance): <cc@chris-corby.com>

## Useful Links

- Byron on Deliveroo: https://byron.order.deliveroo.co.uk/
- Byron Click & Collect link: https://byron.wlwo-iorder.zonalconnect.com/#/venues/list

## Copyright and License

© 2021–present Chris Corby. All rights reserved.
