<?php
require_once 'class.user.php';

$user = new USER();

$stmt = $user->runQuery("SELECT * FROM `camagru_db`.`users` WHERE `user_id`=:uid");
$stmt->bindparam(":uid",$_SESSION['user_session']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);


$_SESSION[ 'user_id' ] = $row[ 'user_id' ];
$_SESSION[ 'user_name' ] = $row[ 'user_name' ];
$_SESSION[ 'user_mail' ] = $row[ 'user_mail' ];

if (empty($row['user_id']))
{
    $user->redirect('../index.php');
}

if (isset($row['user_id']))
{
    echo "chains ans things";
    $id = $row['user_id'];
    $email = $row['user_mail'];

    //$stmt = $user->runQuery("SELECT * FROM `camagru_db`.`users` WHERE `user_id`=:uid");
    //$stmt->execute(array(":uid"=>$id));
    //$rows = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 1)
    {
        if (isset($_POST['btn-reset-pass']))
        {
            $pass = $_POST['pass'];
            $cpass = $_POST['confirm-pass'];

            if ($cpass !== $pass)
            {
                echo "
                    <div class='alert alert-block'>
                        <button class='close' data-dismiss='alert'>&times;</button>
                        <stron>Sorry!<strong> Passwords don't match.
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
                header("refresh:5;../main_gallery.php");
            }
        }
    }
    else
    {
        exit;
    }
}
?>