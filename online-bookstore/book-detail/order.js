import { isQuantityValid, isFilled } from '/validation.js';

document.querySelector('form button').addEventListener('click', function(e) {
    e.preventDefault();

    var quantityValue = document.querySelector('form #quantity').value;
    if (isFilled(quantityValue) && isQuantityValid(quantityValue)) {
        var httpRequest = new XMLHttpRequest();
    
        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                var responsee = httpRequest.responseText;
                if (responsee == "Balance is not enough" || responsee == "Card number is invalid" || responsee == "Error when updating sender's balance" || responsee == "Error when updating receiver's balance" || responsee == "Error when inserting transaction" || responsee == "Error commiting changes"){
                    document.querySelector('#messagewindow').textContent = responsee;
                    document.querySelector('#checkpicture').style.display = 'none';
                    document.querySelector('.modal').style.display = 'flex';
                } else{
                    document.querySelector('#order-id').textContent = responsee;
                    document.querySelector('.modal').style.display = 'flex';
                }
            }
        };
    
        httpRequest.open('POST', '/book-detail/');
        httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        console.log(document.querySelector('form #id').value);
        httpRequest.send('id=' + document.querySelector('form #id').value + '&quantity=' + quantityValue);
    }
});