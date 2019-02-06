<?php

require_once 'functions/class.user.php';
$user_home = new USER();

if ($user_home->is_logged_in())
{
     $user_home->redirect('index.php');
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Password Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body id="login">
    <div class="container">
        <div class='alert alert-success'>
        <strong>Hello </strong>  <?php echo $row['user_name'] ?> you are here to reset your forgetton password.
    </div>
    <div>
        <form class="form-signin" method="POST" action="functions/reset_pass.php">
            <h3 class="form-signin-heading">Password Reset.</h3><hr />
            <?php
            if(isset($msg)) 
            {
                echo $msg;
            }
            ?>
            <input type="password" class="input-block-level" placeholder="New Password" name="pass" required />
            <input type="password" class="input-block-level" placeholder="Confirm New Password" name="confirm-pass" required />
            <input type="email" class="input-block-level" placeholder="we need your email" name="email" required />
            <hr />
            <button class="btn btn-large btn-primary" type="submit" name="btn-reset-pass">Reset Your Password</button>
        </form>
    </div>
</body>
</html>