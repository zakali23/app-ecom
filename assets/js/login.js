import '../styles/app.css';
import verifChamps from './modules/validate/verifChamps';
const emailVal = document.getElementById('inputEmail');
const erroremail = document.getElementById('error-email');

console.log(erroremail)
emailVal.addEventListener('input', () => {
    const res = verifChamps.verifEmail(emailVal.value);
    if (res.state) {
        erroremail.innerText = res.helper;
    } else {
        erroremail.innerText = '';
    }
})