<?php
require_once 'config/setup.php';
require_once 'functions/class.user.php';

echo "Alice in Wonderland";
$reg_user = new USER;

if (isset($_POST['btn-signup']))
{
    $uname = trim($_POST['txtuname']);
    $email = trim($_POST['txtemail']);
    $upass = trim($_POST['txtpass']);
    $code = hash("sha256", uniqid(rand()));

    $stmt = $reg_user->runQuery("SELECT * FROM camagru_db.users WHERE user_mail=:email_id");
    $stmt->execute(array(":email_id"=>$email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0)
    {
        $msg = "
        <div class='alert alert-error'>
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Sorry!!!</strong> email has already been registered, Try another one or <a href='login.php'>login</a>
        </div>
        ";
    }
    else
    {
        if ($reg_user->register($uname, $email, $upass, $code))
        {
            $message = "
                Hello $uname,
                Welcome to Camagru!
                To complete your registration, click on the link,
                Click 
                http://localhost:8080/camagru-master/functions/verify.php?user_token=$code
                Choke on a dag of bicks,";

            $subject = "Confirm Registration";

            if (mail($email, $subject, $message))
            {
                $msg = "
                <div class='alert alert-success'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Success!</strong> We've sent an email to $email.
                Click on the link on the email and feel free to display your insignificant life to no one but algorithms.
                </div>";
            }
            else
            {
                echo "Ayeye, Mashab";
            }
        }
        else
        {
            echo "ya fucked it up, bitch!!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIGNUP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div id="login">
        <div class="container">
            <?php if(isset($msg)) echo $msg;  ?>
            <form class="form-signin" method="post">
            <h2 class="form-signin-heading">Sign Up</h2><hr />
            <input type="text" class="input-block-level" placeholder="Username" name="txtuname" required />
            <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
            <input type="password" class="input-block-level" placeholder="Password" name="txtpass" required />
            <hr />
            <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Sign Up</button>
            <a href="index.php" style="float:right;" class="btn btn-large">Sign In</a>
            </form>
        </div>
    </div>
</body>
</html>