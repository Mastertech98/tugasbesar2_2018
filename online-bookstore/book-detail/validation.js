import { addValidation, isQuantityValid } from '/validation.js';

var quantityError = document.querySelector('#quantity-error');

addValidation(document.querySelector('form'), '#quantity', quantityError, isQuantityValid, 'Quantity needs to be 1 or more');