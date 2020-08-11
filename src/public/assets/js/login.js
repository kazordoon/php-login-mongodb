import { generateErrorMessage } from './utils/index.js';

(function() {
	const form = document.forms['form-login'];

	form.addEventListener('submit', function(event) {
		const errors = [];

		const email = document.querySelector('#email').value;
		const password = document.querySelector('#password').value;

		if (!email || !password) {
			errors.push('Fill in all fields');
		}

		if (errors.length > 0) {
			generateErrorMessage(errors);
			event.preventDefault();
		}
	});
})();
