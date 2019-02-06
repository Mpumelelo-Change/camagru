<?php
    require_once 'functions/class.user.php';
    require_once 'config/setup.php';

    $dat_user = new USER();

    $new_name = $_POST['new_name'];
    $dat_mail = $_POST['email'];
    $stmt = $dat_user->runQuery("UPDATE `camagru_db`.`users` SET `user_name`=:uname WHERE `user_mail`=:umail");
    $stmt->bindparam("uname",$new_name);
    $stmt->bindparaM("umail",$dat_mail);

    if ($stmt->execute()) {
        $dat_user->redirect('main_gallery.php');
    }
?>