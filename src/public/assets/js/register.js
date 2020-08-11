import {
  generateErrorMessage,
  validateEmail,
} from './utils/index.js';

(function() {
	const form = document.forms['form-register'];

	form.addEventListener('submit', function(event) {
		const errors = [];

		const inputs = document.querySelectorAll('form[name=form-register] input');
		const emptyInputs = Array.prototype.some.call(inputs, input => input.value.length === 0);


		if (emptyInputs) {
			errors.push('Fill in all fields');
		}

		const email = document.querySelector('#email').value;
		const password = document.querySelector('#password').value;
		const repeatPassword = document.querySelector('#repeatPassword').value;

		const invalidEmail = !(validateEmail(email));

		if (invalidEmail) {
			errors.push('The email provided is invalid');
		}

		if (password !== repeatPassword) {
			errors.push("Passwords don't match");
		}

		if (errors.length > 0) {
			generateErrorMessage(errors);
			event.preventDefault();
		}

	});
})();
