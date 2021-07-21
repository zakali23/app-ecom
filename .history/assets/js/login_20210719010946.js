import '../styles/app.css';
import verifChamps from './modules/validate/verifChamps';
const emailVal = document.getElementById('inputEmail');
emailVal.addEventListener('input', () => {
    console.log(verifChamps(emailVal.value))
})