import generateErrorMessage from './utils/generateErrorMessage.js';

(function () {
  const form = document.forms['form-reset-password'];

  form.addEventListener('submit', function(event) {
    const errors = [];

    const password = document.querySelector('#password').value;
    const repeatedPassword = document.querySelector('#repeatPassword').value;

    const inputs = document.querySelectorAll(
      'form[name=form-reset-password] input'
    );
    const emptyInputs = Array.prototype.some.call(
      inputs,
      (input) => input.value.length === 0
    );

    if (emptyInputs) {
      errors.push('Fill in all fields');
    }

    if (password !== repeatedPassword) {
      errors.push("Passwords don't match");
    }

    if (errors.length > 0) {
      generateErrorMessage(errors);
      event.preventDefault();
    }
  });
})();
