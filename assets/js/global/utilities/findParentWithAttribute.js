/*------------------------------------------------------------------------------

  findParentWithAttribute.js

  Given an element, this function will return the closest parent with
  a given attribute, or otherwise null.

  By default it will check itself, but can switch off

  Usage:
  findParentWithAttribute(el, 'data-index');

  ----------------------------------------------------------------------------*/

export function findParentWithAttribute(
  element,
  targetAttribute,
  includingSelf = true
) {
  const theAttribute = targetAttribute;
  let el = element;

  //  Check self
  if (includingSelf && el.hasAttribute(theAttribute)) {
    return el;
  }

  //  Otherwise check parents
  while (el.parentNode) {
    el = el.parentNode;

    if (el.hasAttribute(theAttribute)) {
      return el;
    }
  }

  //  Failure
  return null;
}
