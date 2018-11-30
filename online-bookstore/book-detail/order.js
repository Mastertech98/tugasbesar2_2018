import { isQuantityValid, isFilled } from '/validation.js';

document.querySelector('form button').addEventListener('click', function(e) {
    e.preventDefault();

    var quantityValue = document.querySelector('form #quantity').value;
    if (isFilled(quantityValue) && isQuantityValid(quantityValue)) {
        var httpRequest = new XMLHttpRequest();
    
        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                document.querySelector('#order-id').textContent = httpRequest.responseText;
                document.querySelector('.modal').style.display = 'flex';
            }
        };
    
        httpRequest.open('POST', '/book-detail/');
        httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        console.log(document.querySelector('form #id').value);
        httpRequest.send('id=' + document.querySelector('form #id').value + '&quantity=' + quantityValue);
    }
});