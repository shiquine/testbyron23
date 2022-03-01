/*------------------------------------------------------------------------------

  slideUpDown.js

  Usage:
  slideUp(parent);
  slideDown(parent, child);

  ----------------------------------------------------------------------------*/

/*
 *  slideUp
 */

export function slideUp(parent) {
  //  Remove the active class from the parent
  if (parent.hasAttribute('data-active')) {
    parent.removeAttribute('data-active');
  }

  //  Reset the max-height of the parent
  parent.style.maxHeight = '0px';
}

/*
 *  slideDown
 */

export function slideDown(parent, child) {
  //  Get current max-height of parent (used on resize)
  const parentMax = parent.style.maxHeight;
  //  Get the height of the child
  const childHeight = child.offsetHeight;

  //  If parent max-height is not enough, reset
  if (parseInt(parentMax, 10) !== childHeight) {
    //  Add the active class to the parent
    if (!parent.hasAttribute('data-active')) {
      parent.setAttribute('data-active', '');
    }

    //  Set the max-height of the parent to the height of the child
    parent.style.maxHeight = `${childHeight}px`;
  }
}
