<?php
require_once 'config/database.php';
require_once 'functions/class.user.php';
$user_login = new USER();

if (isset($_POST['btn-login']))
{
    $email = trim($_POST['txtemail']);
    $upass = trim($_POST['txtupass']);
    if ($user_login->login($email,$upass))
    {
        $user_login->redirect('main_gallery.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Camagru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="index.css" />
    <script src="main.js"></script>
</head>
<body id="login">
    <div class="container">
    <?php
    if(isset($_GET['inactive']))
    {
        echo "<div class='alert alert-error'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it. 
        </div>";
    }
    ?>
    <form class="form-signin" method="post">
    <?php
    if(isset($_GET['error']))
    {
        echo "<div class='alert alert-success'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Wrong Details!</strong> 
    </div>";
    }
    ?>
    <h2 class="form-signin-heading">Sign In.</h2><hr />
    <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
    <input type="password" class="input-block-level" placeholder="Password" name="txtupass" required />
    <hr />
    <button class="btn btn-large btn-primary" type="submit" name="btn-login">Sign in</button>
    <a href="signup.php" style="float:right;" class="btn btn-large">Sign Up</a><hr />
    <a href="fpass.php">Lost your Password ? </a>
    </form>
    </div>
</body>
</html>