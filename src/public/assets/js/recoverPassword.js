import generateErrorMessage from './utils/generateErrorMessage.js';
import UserValidator from './validators/UserValidator.js';

(function () {
  const form = document.forms['form-recover-password'];

  form.addEventListener('submit', function (event) {
    const errors = [];

    const email = document.querySelector('#email').value;
    if (!email) {
      errors.push('Fill in the email field.');
    }

    const isAnInvalidEmail = !UserValidator.isAValidEmail(email);
    if (isAnInvalidEmail) {
      errors.push('The provided email is invalid.');
    }

    if (errors.length > 0) {
      generateErrorMessage(errors[0]);
      event.preventDefault();
    }
  });
})();
