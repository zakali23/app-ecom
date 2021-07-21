import '../styles/app.css';
import verifChamps from './modules/validate/verifChamps';
const emailVal = document.getElementById('inputEmail');
const erroremail = document.getElementsByClassName('error-email');
emailVal.addEventListener('input', () => {
    const res = verifChamps.verifEmail(emailVal.value);
    console.log(res)
    if (res.statut) {
        erroremail.innerHTML = res.helper;
    }
})