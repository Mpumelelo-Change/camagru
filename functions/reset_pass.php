<?php
require_once 'class.user.php';

$user = new USER();
$email = $_POST['email'];
$stmt = $user->runQuery("SELECT * FROM `camagru_db`.`users` WHERE `user_mail`=:email");
$stmt->bindparam(":email", $_POST['email']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

var_dump($row);
if (!empty($_row['user_id']))
{
    $user->redirect('../index.php');
}

var_dump($_REQUEST);

if (isset($row['user_id']))
{
    $id = $row['user_id'];

    if ($stmt->rowCount() == 1)
    {
        echo "the kid is not my son";
        if (isset($_POST['btn-reset-pass']))
        {
            $pass = $_POST['pass'];
            $cpass = $_POST['confirm-pass'];

            if ($cpass !== $pass)
            {
                echo "
                    <div class='alert alert-block'>
                        <button class='close' data-dismiss='alert'>&times;</button>
                        <strong>Sorry!<strong> Passwords don't match.
                    </div>
                ";
                header("refresh:5;../reset.php");
            }
            else
            {
                $new_pass = hash('sha256', $cpass.$email);
                $stmt = $user->runQuery("UPDATE `camagru_db`.`users` SET `user_pass`=:upass WHERE `user_id`=:uid");
                $stmt->bindparam(":upass",$new_pass);
                $stmt->bindparam(":uid",$id);
                $stmt->execute();

                echo "
                    <div class='alert alert-success'>
                        <button class='close' data-dismiss='alert'>&times;</button>
                        Passowrd Changed.
                    </div>
                ";
                header("refresh:5;../index.php");
            }
        }
    }
    else
    {
        exit;
    }
}
?>