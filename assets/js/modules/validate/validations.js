function emptyInput(input) {
    const res = (!input || /^\s*$/.test(input));
    if (res) {
        return {
            state: res,
            helper: 'ce champ est obligatoire'
        };
    }
    return false;
}

function minLenghtInput(input, min = 1) {
    const inputTrim = input.trim();
    if (inputTrim.length < min) {
        return {
            state: true,
            helper: `Veuillez saisir minimum ${min} caractaires`
        };
    }
    return false;
}

function maxLenghtInput(input, max = 80) {
    const inputTrim = input.trim();
    if (inputTrim.length <= max) {
        return false;
    }
    return {
        state: true,
        helper: `Veuillez saisir maximum ${max} caractaires`
    };

}

function numberOnly(input) {
    const res = !(/^\d+$/.test(input));
    if (res) {
        return {
            state: res,
            helper: 'Seulement les numero sont autorisé'
        };
    }
    return false;
}

function emailInput(input) {
    const res = !(/\S+@\S+\.\S+/.test(input));
    if (res) {
        return {
            state: res,
            helper: `${input} : email non valid`
        };
    }
    return false;
}

function phoneInput(input) {
    const res = !(/^((\+)33|0)[1-9](\d{2}){4}$/.test(input));
    if (res) {
        return {
            state: res,
            helper: `${input} : phone non valid`
        };
    }
    return false;
}

function passwordInput(input) {
    const res = !(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/.test(input));
    if (res) {
        return {
            state: res,
            helper: `minimum 8 caractères, un majuscule et un minuscule ainsi qu'un nombre sans caractères spéciaux`
        };
    }
    return false;
}

function dateInput(date) {
    const res = !(/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|1\d|2\d|3[01])$/.test(date));
    const birthday = new Date(date);
    const today = new Date();
    if (res) {
        return {
            state: res,
            helper: `La date saisie n'est pas valide`
        };
    }
    if (birthday > today) {
        return {
            state: true,
            helper: `Veuillez entrer une date de naissance valide. `
        };
    }

    return false;
}
export default {
    emptyInput,
    minLenghtInput,
    maxLenghtInput,
    numberOnly,
    emailInput,
    phoneInput,
    passwordInput,
    dateInput
}