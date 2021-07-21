import '../styles/app.css';
import verifChamps from './modules/validate/verifChamps';
const emailVal = document.getElementById('inputEmail');
const erroremail = document.getElementsByClassName('error-email');
erroremail.innerHTML = 'res.helper';
console.log(erroremail)
emailVal.addEventListener('input', () => {
    const res = verifChamps.verifEmail(emailVal.value);
    if (res.statut) {
        console.log("erreur")
    }
})