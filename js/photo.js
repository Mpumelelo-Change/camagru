var video = document.getElementById('video'),
    photo = document.getElementById('photo'),
    canvas = document.getElementById('canvas'),
    context = canvas.getContext('2d'),
    vendorURL = window.URL || window.webkitURL;

var xhttp = new XMLHttpRequest();

(function () {

    navigator.getMedia = navigator.getUserMedia || 
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia;

    navigator.getMedia({
        video: true,
        audio: false
    }, function(stream) {
        video.srcObject = stream;
        video.play();
    }, function(error) {
    });

    document.getElementById('capture').addEventListener('click', function() {
        context.drawImage(video,0, 0, 400, 300);
        photo.src = canvas.toDataURL('image/jpeg'); 
    });
})();

function saveToDB() {
    var img_64 = photo.src;
    xhttp.open("POST", "functions/save_image.php");
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("img=" + img_64);    
}

