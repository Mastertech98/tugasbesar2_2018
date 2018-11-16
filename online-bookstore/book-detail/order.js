document.querySelector('form button').addEventListener('click', function(e) {
    e.preventDefault();

    var httpRequest = new XMLHttpRequest();

    httpRequest.onreadystatechange = function () {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            alert('Pemesanan Berhasil! Nomor Transaksi: ' + httpRequest.responseText);
        }
    };

    httpRequest.open('POST', '/book-detail/');
    httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    httpRequest.send('id=' + document.querySelector('form #id').value + '&quantity=' + document.querySelector('form #quantity').value);
});