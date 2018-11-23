var muteButton = document.querySelector('#mute-button');
var video = document.querySelector('video');

muteButton.addEventListener('click', function(e) {
    
    if (video.muted = !video.muted) {
        muteButton.src = "sound-off.jpg"
    } else {
        muteButton.src = "sound-on.jpg"        
    }
});