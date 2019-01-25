<?php
    require_once 'class.user.php';
    $user = new USER();

    $user_id_new = $_SESSION['user_session'];

    if (isset($_POST['img'])) {
        var_dump($_POST['img']);
        $img = $_POST['img'];

        $stmt = $user->runQuery("INSERT INTO camagru_db.images(title, user_id) VALUES(:img_64, :user_iden)");
        $stmt->bindparam(":img_64", $img);
        $stmt->bindparam(":user_iden", $user_id_new);

        if ( $stmt->execute()) {
            echo "Uploaded";
        }
        else
        {
            echo "Not good";
        }
    }
    else
    {
        echo "Failed to upload";
    }
?>