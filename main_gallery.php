<?php
require_once 'functions/class.user.php';
$user_home = new USER();
if ($user_home->is_logged_in())
{
     $user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM `camagru_db`.`users`");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION[ 'user_id' ] = $row[ 'user_id' ];
$_SESSION[ 'user_name' ] = $row[ 'user_name' ];
$_SESSION[ 'user_mail' ] = $row[ 'user_mail' ];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Camagru-Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    img {
       height: 300px;
       width: 300px;
       margin: 5px;
       border: 10px; 
    }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
    function post()
    {
        var comment = document.getElementById("comment").value;
  
        if(comment) {
            $.ajax({
                type: 'post',
                url: 'functions/post_comment.php',
                data: 
                {
                    user_comm:comment,
                },
                success: function (response) 
                {
	                document.getElementById("all_comments").innerHTML=response+document.getElementById("all_comments").innerHTML;
	                document.getElementById("comment").value="";
                }
            });
        }
        return false;
    }
    </script>
</head>
<body>
<div class="top-tab">
    <button class="btn-capt"><a href="capture.php">Capture</a></button>
    <button class="btn-capt"><a href="reset.php">Reset Password</a></button>
    <button class="btn-capt"><a href="functions/logout.php">Logout</a></button>
</div>
<div class="image-container">
    <?php
    $db_host = 'localhost';
    $db_naam = 'camagru_db';
    $db_user = 'root';
    $db_pass = 'kannon';

    try
    {
        $conn = new PDO("mysql:host=$db_host;db_name=$db_naam", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM camagru_db.images");
        $stmt->execute();
        
        session_start();
        if ($stmt->rowCount() > 0)
        {
            $assc_arr = array();
            while ($row = $stmt->fetch()) {
                $img = str_replace(' ', '+', $row['title']);
                $assc_arr += array($img=>$row['image_id']);
                echo '
                <div class="img-com-container">
                <img src= ' . $img . ' />
                <form method="post" action="" onsubmit="return post();">
                    <textarea id="comment" placeholder="write your comment here..."></textarea>
                    <br>
                    <input type="submit" value="Post Comment">
                </form>
                <div id="all_comments">
                    <div id="comment_div">';
                $comm = $conn->prepare("SELECT * FROM camagru_db.comments");
                $comm->execute();
                while($s_row = $comm->fetch())
                {
                    $comment=$s_row['comment'];
                    if ($row['image_id'] == $s_row['image_id']) {
                        echo '<p class="comment">';
                        echo $comment;
                    }
                    ?>
                    <?php echo '</div>
                </div>
                </div>';
                }
           }
           $_SESSION['assc_arr'] = $assc_arr;
        }
        else
        {
            echo "Nothing to Display";
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    ?>
</div>
</body>
</html>