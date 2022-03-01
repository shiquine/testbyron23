export class Club {
  constructor() {
    this.attrs = {
      clubContainer: `data-club`,
      container: `data-club-form`,
      progressButton: `data-club-progress`,
      field: `data-club-field`,
      active: `data-active`,
      loading: `data-loading`,
    };

    this.clubContainer = document.querySelector(
      `[${this.attrs.clubContainer}]`
    );
    this.form = document.querySelector(`[${this.attrs.container}]`);
    this.progressButton = document.querySelector(
      `[${this.attrs.progressButton}]`
    );
    this.fields = Array.from(
      document.querySelectorAll(`[${this.attrs.field}]`)
    );
    this.index = 0;
    this.currentField = false;

    this.isSubmitting = false;

    //  Bind event listeners
    this.handleProgress = this.handleProgress.bind(this);
  }

  start() {
    if (!this.form || !this.progressButton) return;

    this.updateCurrentField();
    this.listenForEvents();
  }

  listenForEvents() {
    this.progressButton.addEventListener('click', this.handleProgress);
    this.form.addEventListener('submit', this.handleProgress);
  }

  handleProgress(event) {
    event.preventDefault();
    event.stopPropagation();
    this.progress();
  }

  progress() {
    const isValid = this.checkValidityOfCurrentField();
    this.toggleValidityMessage(isValid);
    if (!isValid) return;

    const isLast = this.index === this.fields.length - 1;

    //  If this is the last field
    if (isLast) {
      this.submit();
    } else {
      this.showNextField();
      this.updateCurrentField();
      this.moveFocusToCurrentField();
    }
  }

  updateCurrentField() {
    this.currentField = this.fields[this.index];
  }

  checkValidityOfCurrentField() {
    //  Assume validity
    let verdict = true;

    //  Get all inputs
    const inputs = this.currentField.querySelectorAll('input, select');

    //  Check for empty and basic HTML validity
    inputs.forEach(input => {
      if (!input.value.length || !input.checkValidity()) {
        verdict = false;
      }
    });

    return verdict;
  }

  toggleValidityMessage(isValid) {
    if (!isValid) {
      this.addErrorMessageToCurrentField();
      this.moveFocusToCurrentField();
    } else {
      this.removeErrorMessageFromCurrentField();
    }
  }

  moveFocusToCurrentField() {
    const inputs = this.currentField.querySelectorAll('input, select');
    inputs[0].focus();
  }

  addErrorMessageToCurrentField() {
    const errorID = `Club-fieldError--${this.index + 1}`;
    const inputs = this.currentField.querySelectorAll('input, select');

    //  TODO: Test this in a screenreader
    inputs.forEach(input => {
      input.setAttribute('aria-invalid', 'true');
      input.setAttribute('aria-describedby', errorID);
    });

    const errorMessage = this.currentField.querySelector(`#${errorID}`);
    if (!errorMessage) {
      //  Assume blank
      let message = 'Please enter something for this field';
      const inputTag = inputs[0].tagName;
      const inputType = inputs[0].type;

      if (inputTag === 'SELECT') {
        message = 'Please select an option to continue';
      } else if (inputType === 'email') {
        message = 'Please enter a valid email address';
      } else if (inputType === 'tel') {
        message = 'Please enter a valid telephone number';
      } else if (inputType === 'checkbox') {
        message = 'Please tick this to continue';
      }

      this.currentField.insertAdjacentHTML(
        'beforeend',
        `
        <div class="Club-fieldError" id="${errorID}">${message}</div>
      `
      );
    }
  }

  removeErrorMessageFromCurrentField() {
    const errorID = `Club-fieldError--${this.index + 1}`;
    const inputs = this.currentField.querySelectorAll('input, select');

    inputs.forEach(input => {
      input.removeAttribute('aria-invalid');
      input.removeAttribute('aria-describedby');
    });

    const errorMessage = this.currentField.querySelector(`#${errorID}`);
    if (errorMessage) errorMessage.remove();
  }

  showNextField() {
    this.index += 1;

    this.fields.forEach((field, index) => {
      if (index === this.index) {
        field.setAttribute(this.attrs.active, '');
      } else {
        field.removeAttribute(this.attrs.active);
      }
    });
  }

  submit() {
    if (this.isSubmitting) return;
    this.isSubmitting = true;

    this.enterLoadingState();

    //  Submit the form as usual and let it hard load to the Club page
    this.form.submit();
  }

  enterLoadingState() {
    this.clubContainer.setAttribute(this.attrs.loading, '');
  }
}
