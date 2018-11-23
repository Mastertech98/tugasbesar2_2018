import { addValidation } from '/validation.js'

var form = document.querySelector('form');

var searchError = document.querySelector('#search-error');

addValidation(form, '#search', searchError)