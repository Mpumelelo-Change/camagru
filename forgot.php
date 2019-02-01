<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <body id="login">
        <div class="container">
            <form class="form-signin" method="post">
                <h2 class="form-signin-heading">Forgot Password</h2><hr />
                <?php
                require_once 'config/setup.php';
                require_once 'functions/forgot_pass.php';

                if(isset($msg))
                {
                    echo $msg;
                }
                else
                {
                    echo "<div class='alert alert-info'>
                        Please enter your email address. You will receive a link to create a new password via email.
                    </div>";
                }  
                ?> 
                <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
                <hr />
                <button class="btn btn-danger btn-primary" type="submit" name="btn-submit">Reset Password</button>
            </form>
        </div>
    </body>
</html>