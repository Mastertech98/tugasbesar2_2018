import { addValidation } from '/validation.js'

var form = document.querySelector('form');

var commentsError = document.querySelector('#comments-error');

addValidation(form, '#comments', commentsError);