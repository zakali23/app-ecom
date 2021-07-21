import validations from './validations'
const verifFirstName = (name, min) => {
    const empt = validations.emptyInput(name);
    const minLen = validations.minLenghtInput(name, min);
    if (empt) {
        return empt;
    }
    if (minLen) {
        return minLen;
    }
    return {
        state: false,
        helper: ""
    }
}
const verifLastName = (name, min) => {
    const empt = validations.emptyInput(name);
    const minLen = validations.minLenghtInput(name, min);
    if (empt) {
        return empt;
    }
    if (minLen) {
        return minLen;
    }
    return {
        state: false,
        helper: ""
    }
}
const verifEmail = (email) => {
    const empt = validations.emptyInput(email);
    const em = validations.emailInput(email);
    if (empt) {
        return empt;
    }
    if (em) {
        return em;
    }
    return {
        state: false,
        helper: ""
    }
}
const verifPhone = (number) => {
    const empt = validations.emptyInput(number);
    const num = validations.phoneInput(number);
    if (empt) {
        return empt;
    }
    if (num) {
        return num;
    }
    return {
        state: false,
        helper: ""
    }
}
const verifPassword = (password) => {
    const empt = validations.emptyInput(password);
    const minLen = validations.passwordInput(password);
    if (empt) {
        return empt;
    }
    if (minLen) {
        return minLen;
    }
    return {
        state: false,
        helper: ""
    }
}
const verifAddress = (address, min, max) => {
    const empt = validations.emptyInput(address);
    const minLen = validations.minLenghtInput(address, min);
    const maxLen = validations.maxLenghtInput(address, max)
    if (empt) {
        return empt;
    }
    if (minLen) {
        return minLen;
    }
    if (maxLen) {
        return maxLen;
    }
    return {
        state: false,
        helper: ""
    }
}
const verifCity = (city, min) => {
    const empt = validations.emptyInput(city);
    const minLen = validations.minLenghtInput(city, min);
    if (empt) {
        return empt;
    }
    if (minLen) {
        return minLen;
    }
    return {
        state: false,
        helper: ""
    }
}
const verifBirthday = (day) => {
    const empt = validations.emptyInput(day);
    const date = validations.dateInput(day);
    if (empt) {
        return empt;
    }
    if (date) {
        return date;
    }
    return {
        state: false,
        helper: ""
    }
}
const verifZipCode = (zipCode, min, max) => {
    const empt = validations.emptyInput(zipCode);
    const minLen = validations.minLenghtInput(zipCode, min);
    const maxLen = validations.maxLenghtInput(zipCode, max)
    if (empt) {
        return empt;
    }
    if (minLen) {
        return minLen;
    }
    if (maxLen) {
        return maxLen;
    }
    return {
        state: false,
        helper: ""
    }
}
export default {
    verifFirstName,
    verifLastName,
    verifEmail,
    verifPhone,
    verifPassword,
    verifAddress,
    verifCity,
    verifZipCode,
    verifBirthday
}