export function isURLFromSameDomain(url) {
  //  1. Get the URL
  const link = document.createElement('a');
  link.href = url;

  //  2. Check this domain
  const isThisDomain = link.host === window.location.host;

  //  3. Also check CDN
  const isCDN = false;

  return isThisDomain || isCDN;
}
