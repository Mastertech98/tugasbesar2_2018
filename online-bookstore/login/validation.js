import { addValidation } from '/validation.js';

var form = document.querySelector('form');

var usernameError = document.querySelector('#username-error');
var passwordError = document.querySelector('#password-error');

addValidation(form, '#username', usernameError);
addValidation(form, '#password', passwordError);