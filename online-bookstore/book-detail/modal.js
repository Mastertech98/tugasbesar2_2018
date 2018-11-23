var modal = document.querySelector('.modal');

document.querySelector('.modal-close').addEventListener('click', function(e) {
    modal.style.display = 'none';
});

window.addEventListener('click', function(e) {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});