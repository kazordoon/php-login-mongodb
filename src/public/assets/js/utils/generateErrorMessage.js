export default function generateErrorMessage(errors) {
  let divError = document.querySelector('div.error');
  if (divError) {
    divError.remove();
  }

  divError = document.createElement('div');
  divError.classList.add('alert alert-danger');

  const pError = document.createElement('p');
  const textError = document.createTextNode(errors[0]);
  pError.appendChild(textError);
  divError.appendChild(pError);

  document.body.prepend(divError);
}
