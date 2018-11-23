export function isFilled(value) {
    return value !== '';
}

export function isEmailValid(value) {
    var emailRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    return emailRegExp.test(value);
}

export function isQuantityValid(value) {
    return value >= 1;
}

export function isRatingValid(value) {
    return value >= 1 && value <= 5;
}

export function isNameValid(value) {
    return value.length <= 20;
}

export function isPhoneNumberValid(value) {
    return value.length >= 9 && value.length <= 12;
}

export function addValidation(form, id, error, checkValidity, message = '', required = true) {
    error.className = 'error';

    var input = form.querySelector(id);
    input.addEventListener('input', function (event) {
        if (!required || isFilled(this.value)) {
            if (!checkValidity || checkValidity(this.value)) {
                this.className = 'valid';
                error.innerHTML = '';
                error.className = 'error'
            } else {
                this.className = 'invalid';
                error.innerHTML = message;
                error.className = 'error active';
            }
        } else {
            this.className = 'invalid';
            error.innerHTML = 'This field is required';
            error.className = 'error active';
        }
    });

    if (form.validation == undefined) {
        form.validation = [];
        form.addEventListener('submit', function (event) {
            this.validation.some(element => {
                if (!element.test(element.input.value)) {
                    event.preventDefault();
                    return true;
                }
            });
        });
    }

    if (required) {
        form.validation.push({input, test: isFilled});
    }

    if (checkValidity) {
        form.validation.push({input, test: checkValidity});
    }
}