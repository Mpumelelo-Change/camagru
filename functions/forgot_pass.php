<?php
require_once 'class.user.php';
$user = new USER();

if ($user->is_logged_in() == "")
{
    $user->redirect('home.php');
}

if (isset($_POST['btn-submit']))
{
    $email = $_POST['txtemail'];

    $stmt = $user->runQuery("SELECT user_id, user_name FROM camagru_db.users WHERE user_mail=:email LIMIT 1");
    $stmt->execute(array(":email"=>$email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $user_name = $row['user_name'];
    $user_id = $row['user_id'];

    if ($stmt->rowCount() == 1) {
        $code = hash("sha256", uniqid(rand()));

        $message = "
            Hello, $user_name
            You requested to reset your password, if you did click the following link, if not, fuggedaboutit

            Click the following link to reset your password
            Click http://localhost:8080/camagru-master/reset.php?id=$user_id&code=$code to reset your password
            Google alzheimer's...
        ";
        
        $subject = "Password Reset";
        mail($email, $subject, $message);

        $stmt = $user->runQuery("UPDATE camagru_db.users SET user_token=:token WHERE user_mail=:email");
        $stmt->execute(array(":token"=>$code,"email"=>$email));
    }
    else {
        $msg = "
            <div class='alert alert-success'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Sorry!</strong> Email not found.
            </div>
        ";
    }
}
?>