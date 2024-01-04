window.addEventListener('DOMContentLoaded', function () {
  const origin = location.origin;
  const $nav = document.querySelector('.navbar');
  const regLocal = new RegExp('localhost');
  const regDev = new RegExp('dev');
  const matchLocalOrigin = origin.match(regLocal);
  const matchDevOrigin = origin.match(regDev);
  if (matchLocalOrigin) {
    $nav.classList.remove('red');
    $nav.classList.add('nav--local');
  } else if (matchDevOrigin) {
    $nav.classList.remove('red');
    $nav.classList.add('nav--dev');
  }
}, false);