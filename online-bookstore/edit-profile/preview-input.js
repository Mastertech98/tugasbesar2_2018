var input = document.querySelector('#picture');
var preview = document.getElementsByClassName('preview')[0];

input.addEventListener('change', updateImageDisplay)

function updateImageDisplay(){
    while(preview.firstChild){
        preview.removeChild(preview.firstChild);
    }

    var currentFile = input.files;
    if (currentFile.length === 0){
        var info = 'No file selected';
        preview.appendChild(document.createTextNode(info));
    } else {
        var info = currentFile[0].name;
        preview.appendChild(document.createTextNode(info));
        var image = document.getElementsByClassName('profileimage')[0]
        image.src = window.URL.createObjectURL(currentFile[0]);
    }
}