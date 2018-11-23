function addAvailabilityValidation(element, fieldName) {
    element.addEventListener('input', function () {
        if (this.value === '') {
            return false;
        }

        if (this.httpRequest && this.httpRequest.readyState != XMLHttpRequest.DONE) {
            this.httpRequest.abort();
        } else {
            this.httpRequest = new XMLHttpRequest();
        }

        //Get image availability 
        let imgAvailability = document.querySelector('#available-' + fieldName);

        this.httpRequest.onreadystatechange = () => {
            if (this.httpRequest.readyState == XMLHttpRequest.DONE) {
                switch (this.httpRequest.responseText) {
                    case '1':
                        console.log('valid');
                        imgAvailability.style.display = 'inline';
                        imgAvailability.src = 'available.png';
                        break;
                    default:
                        console.log('invalid');
                        imgAvailability.style.display = 'inline';
                        imgAvailability.src = 'unavailable.png';
                        break;
                }
            }
        };

        this.httpRequest.open('GET', '/register/check-availability.php?' + fieldName + '=' + this.value);
        this.httpRequest.send();
    });
}

//Add availabiility validation to username input and email input
addAvailabilityValidation(document.querySelector('#username'), 'username');
addAvailabilityValidation(document.querySelector('#email'), 'email');