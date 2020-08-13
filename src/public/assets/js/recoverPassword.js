import { generateErrorMessage } from './utils/index.js';

(function() {
	const form = document.forms['form-recover-password'];

	form.addEventListener('submit', function(event) {
		const email = document.querySelector('#email').value;
		if (!email) {
			event.preventDefault();
			const error = 'Fill in the email field.';
      generateErrorMessage([error]);
		}
	});
})();
