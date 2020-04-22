import IMask from 'imask';
import api from '../api';

const tabItemAll = document.querySelectorAll('.tab-item');
const tabItem = document.querySelector('.tab-item');
const tabBodyAll = document.querySelectorAll('.tab-body');
const feedInput = document.querySelector('.feed-new-input');
const feedPlaceholder = document.querySelector('.feed-new-input-placeholder');
const feedSubmit = document.querySelector('.feed-new-send');
const feedForm = document.querySelector('.feed-new-form');
const follow = document.querySelector('#follow');
const followers = document.querySelector('#followers');
const birthdate = document.querySelector('#birthdate');
const updateProfile = document.querySelector('#updateProfile');
const flashMsg = document.querySelector('.flashMsg');
const button = document.querySelector('#updateProfile > button');

function setActiveTab(tab) {
  tabItemAll.forEach(function(e){
    if(e.getAttribute('data-for') == tab) {
      e.classList.add('active');
    } else {
      e.classList.remove('active');
    }
  });
}
function showTab() {
  if(tabItem) {
    let activeTab = document.querySelector('.tab-item.active').getAttribute('data-for');
    tabBodyAll.forEach(function(e){
      if(e.getAttribute('data-item') == activeTab) {
          e.style.display = 'block';
      } else {
          e.style.display = 'none';
      }
    });
  }
}

if(tabItem) {
  showTab();
  tabItemAll.forEach(function(e){
    e.addEventListener('click', function(r) {
        setActiveTab( r.target.getAttribute('data-for') );
        showTab();
    });
  });
}

if (feedPlaceholder) {
  feedPlaceholder.addEventListener('click', function(obj){
      obj.target.style.display = 'none';
      feedInput.style.display = 'block';
      feedInput.focus();
      feedInput.innerText = '';
  });
}

if (feedInput) {
  feedInput.addEventListener('blur', function(obj) {
      let value = obj.target.innerText.trim();
      if(value == '') {
          obj.target.style.display = 'none';
          feedPlaceholder.style.display = 'block';
      }
  });
}

if (feedSubmit) {
  feedSubmit.addEventListener('click', function() {
      let value = feedInput.innerText.trim();
  
      if (value != '') {
          feedForm.querySelector('input[name=body]').value = value;
          feedForm.submit();
      }
  });
}

if (follow) {
  follow.addEventListener('click', function() {
    const userId = follow.getAttribute('userid');
  
    api.get(`/profile/${userId}/follow`)
    .then((response) => {
      follow.innerHTML = response.data.btn;
      followers.innerHTML = response.data.flwCnt;
    })
    .catch((err) => {
      alert(err.response.data.error);
    });
  });
}

if (birthdate) {
  IMask(
    birthdate, {
        mask: '00/00/0000'
    }
  );
}

if (updateProfile) {
  updateProfile.onsubmit = function(e) {
    e.preventDefault();
  
    flashMsg.style.display = 'none';
    button.innerHTML = 'Salvando...';
    button.setAttribute('disabled', 'disabled');
    button.setAttribute('class', 'button disabled');
  
    api.put('/profile', {
      name: updateProfile['name'].value,
      birthdate: updateProfile['birthdate'].value,
      email: updateProfile['email'].value,
      city: updateProfile['city'].value,
      work: updateProfile['work'].value,
      password: updateProfile['password'].value,
      confPassword: updateProfile['confPassword'].value
    })
    .then((response) => {
      flashMsg.setAttribute('class', 'flashMsg bgSuccess');
      flashMsg.style.display = 'block';
      flashMsg.innerHTML = response.data.msg;
      button.innerHTML = 'Salvar';
      button.removeAttribute('disabled');
      button.setAttribute('class', 'button');
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    })
    .catch((err) => {
      flashMsg.setAttribute('class', 'flashMsg bgError');
      flashMsg.style.display = 'block';
      flashMsg.innerHTML = err.response.data.error;
      button.innerHTML = 'Salvar';
      button.removeAttribute('disabled');
      button.setAttribute('class', 'button');
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
}
