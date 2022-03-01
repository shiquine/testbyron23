//  Requires a sizing element and applied styles
//  See _base.scss for the corresponding breakpoint

export function getBreakpoint() {
  const sizingElement = document.querySelector('[data-sizing-element]');
  const zed = parseInt(
    window.getComputedStyle(sizingElement, null).getPropertyValue('z-index'),
    10
  );

  return zed;
}
