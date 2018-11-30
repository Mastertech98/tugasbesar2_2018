import { isNameValid, isPhoneNumberValid, addValidation } from '/validation.js';

var form = document.querySelector('form');

var nameError = document.querySelector('#name-error');
var addressError = document.querySelector('#address-error');
var phoneNumberError = document.querySelector('#phone-number-error');
var cardNumberError = document.querySelector('#card-number-error');

addValidation(form, '#name', nameError, isNameValid, 'Your name needs to be 20 characters long or less');
addValidation(form, '#address', addressError);
addValidation(form, '#phone-number', phoneNumberError, isPhoneNumberValid, 'Your phone number needs to be between 9 and 12 digits long');
addValidation(form, '#card-number', cardNumberError);

