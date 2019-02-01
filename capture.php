<?php
    require_once 'config/setup.php';
    require_once 'functions/class.user.php';

    $mo_fo = new USER();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Capture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style/capture.css" />
</head>
<body>
    <div class="booth">
        <video id="video" width="400" height="300"></video>
        <a id="capture" class="booth-capture-btn" >Capture</a>
        <a class="booth-capture-btn" onclick="openForm();">Upload</a>
            
            <div class="form-popup" id="upload_form">
            <form action="functions/upload_image.php" enctype="multipart/form-data" method="post">
                Select image to upload:
                <input type="file" name="file">
                <input type="submit" value="Upload" name="Submit">
                <button class="button-btn" onclick="closeForm();">Cancel</button>
            </form>
            </div>

            <script>
            function openForm() {
                document.getElementById("upload_form").style.display = "block";
            }

            function closeForm() {
                document.getElementById("upload_form").style.display = "none";
            }
            </script>

        <canvas id="canvas" width="400" height="300"></canvas>
        <img id="photo" name="image" src="https://vignette.wikia.nocookie.net/dbxfanon/images/1/16/Akuma.png/revision/latest?cb=20160509171133" alt="" style="width=400; height=300;">
        <a id="save" class="booth-capture-btn" onclick="saveToDB();">Save</a>
    </div>

    <?php
        if (isset($_REQUEST['img'])) {
            header("Location: main_gallery.php");
        }
    ?>
    <script src="js/photo.js"></script>
</body>
</html>