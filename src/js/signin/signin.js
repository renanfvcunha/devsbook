import api from '../api';

const form = document.querySelector('#signin');
const flash = document.querySelector('.flash');
const button = document.querySelector('#signin > button');

form.onsubmit = function(e) {
  e.preventDefault();

  flash.style.display = 'none';
  button.innerHTML = 'Entrando...';
  button.setAttribute('disabled', 'disabled');
  button.setAttribute('class', 'button disabled');

  api.post('/signin', {
    email: form['email'].value,
    password: form['password'].value
  })
  .then(() => {
    location.href = api.defaults.baseURL;
  })
  .catch((err) => {
    flash.style.display = 'block';
    flash.innerHTML = err.response.data.error;
    button.innerHTML = 'Entrar';
    button.removeAttribute('disabled');
    button.setAttribute('class', 'button');
  });
}