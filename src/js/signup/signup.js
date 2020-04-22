import IMask from 'imask';
import api from '../api';

const form = document.querySelector('#signup');
const flash = document.querySelector('.flash');
const button = document.querySelector('#signup > button');

IMask(
  document.querySelector('#birthdate'), {
      mask: '00/00/0000'
  }
);

form.onsubmit = function(e) {
  e.preventDefault();

  flash.style.display = 'none';
  button.innerHTML = 'Cadastrando...';
  button.setAttribute('disabled', 'disabled');
  button.setAttribute('class', 'button disabled');

  api.post('/signup', {
    name: form['name'].value,
    email: form['email'].value,
    password: form['password'].value,
    birthdate: form['birthdate'].value
  })
  .then(() => {
    location.href = api.defaults.baseURL;
  })
  .catch((err) => {
    flash.style.display = 'block';
    flash.innerHTML = err.response.data.error;
    button.innerHTML = 'Cadastrar';
    button.removeAttribute('disabled');
    button.setAttribute('class', 'button');
  });
}
