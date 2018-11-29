import { isNameValid, isEmailValid, isPhoneNumberValid, addValidation } from '/validation.js';

var form = document.querySelector('form');

var nameError = document.querySelector('#name-error');
var usernameError = document.querySelector('#username-error');
var emailError = document.querySelector('#email-error');
var passwordError = document.querySelector('#password-error');
var confirmPasswordError = document.querySelector('#confirm-password-error');
var addressError = document.querySelector('#address-error');
var phoneNumberError = document.querySelector('#phone-number-error');
var cardNumberError = document.querySelector('#phone-number-error');

addValidation(form, '#name', nameError, isNameValid, 'Your name needs to be between 20 characters long or less');
addValidation(form, '#username', usernameError);
addValidation(form, '#email', emailError, isEmailValid, 'Please enter a valid e-mail address');
addValidation(form, '#password', passwordError);
addValidation(form, '#confirm-password', confirmPasswordError);
addValidation(form, '#address', addressError);
addValidation(form, '#phone-number', phoneNumberError, isPhoneNumberValid, 'Your phone number needs to be between 9 and 12 digits long');
addValidation(form, '#card-number', cardNumberError);