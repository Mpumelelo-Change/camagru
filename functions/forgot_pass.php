<?php
session_start();
require_once 'class.user.php';
$user = new USER();

if ($user->is_logged_in() != "")
{
    $user->redirect('home.php');
}

if (isset($_POST['btn-submit']))
{
    $email = $_POST['txtemail'];

    $stmt = $user->runQuery("SELECT id FROM users WHERE email=:email LIMIT 1");
    $stmt->execute(array(":email"=>$email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 1)
    {
        $id = base64_encode($row['id']);
        $code = hash("sha256", uniqid(rand()));

        $stmt = $user->runQuery("UPDATE users SET token=:token WHERE email=:email");
        $stmt->execute(array(":token"=>$code,"email"=>$email));

        $message = "
            Hello,  $username
            <br /><br />
            You requested to reset your password, if you did click the following link, if not, guggedaboutit
            <br /><br />
            Click the following link to reset your password
            <br /><br />
            Click <a href='http://' . $ip . '/reset_pass.php?id=$id&code=$code'> HERE </a> to reset your password
            <br /><br />
            Google alzheimer's...
        ";
        
        $subject = "Password Reset";

        $user->send_mail($email, $message, $subject);

        $msg = "
            <div class='alert alert-success'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Sorry!</strong> Email not found.
            </div>
        ";
    }
}
?>