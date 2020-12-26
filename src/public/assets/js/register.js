import generateErrorMessage from './utils/generateErrorMessage.js';
import UserValidator from './validators/UserValidator.js';

(function () {
  const form = document.forms['form-register'];

  form.addEventListener('submit', function (event) {
    const errors = [];

    const inputs = document.querySelectorAll('form[name=form-register] input');
    const hasEmptyFields = Array.prototype.some.call(
      inputs,
      (input) => input.value.length === 0
    );

    if (hasEmptyFields) {
      errors.push('Fill in all fields');
    }

    const email = document.querySelector('#email').value;
    const password = document.querySelector('#password').value;
    const repeatedPassword = document.querySelector('#repeatedPassword').value;

    const isAnInvalidEmail = !UserValidator.isAValidEmail(email);
    if (isAnInvalidEmail) {
      errors.push('The provided email is invalid');
    }

    const hasAnInvalidPasswordLength = !UserValidator.hasAValidPasswordLength(
      password
    );
    if (hasAnInvalidPasswordLength) {
      errors.push('The password must have between 8 and 50 characters');
    }

    const passwordsAreDifferent = !UserValidator.areThePasswordsTheSame(
      password,
      repeatedPassword
    );
    if (passwordsAreDifferent) {
      errors.push('The passwords don\'t match');
    }

    if (errors.length > 0) {
      generateErrorMessage(errors[0]);
      event.preventDefault();
    }
  });
})();
