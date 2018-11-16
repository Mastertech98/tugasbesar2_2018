function addAvailabilityValidation(element, fieldName) {
    element.addEventListener('input', function () {
        if (this.value === '') {
            return false;
        }

        if (this.httpRequest) {
            this.httpRequest.abort();
        } else {
            this.httpRequest = new XMLHttpRequest();
        }

        this.httpRequest.onreadystatechange = () => {
            if (this.httpRequest.readyState == XMLHttpRequest.DONE) {
                switch (this.httpRequest.responseText) {
                    case '1':
                        console.log('valid');
                        break;
                    default:
                        console.log('invalid');
                        break;
                }
            }
        };

        this.httpRequest.open('GET', '/register/check-availability.php?' + fieldName + '=' + this.value);
        this.httpRequest.send();
    });
}

addAvailabilityValidation(document.querySelector('#username'), 'username');
addAvailabilityValidation(document.querySelector('#email'), 'email');