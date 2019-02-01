<?php
require_once 'class.user.php';
$user = new USER();

echo "There's a natual mystic";
if ( isset($_GET['user_token']))
{
    $code = $_GET['user_token'];
    $statusY = "Y";

    $stmt = $user->runQuery("SELECT user_id,user_stat FROM camagru_db.users WHERE user_token=:code LIMIT 1");
    $stmt->execute(array(":code"=>$code));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "If you listen carefully now, you could hear";
    if ($stmt->rowCount() > 0)
    {
        echo "I won't tell no lie";
        $stmt = $user->runQuery("UPDATE camagru_db.users SET user_stat=:status WHERE user_id=:uID");
        $stmt->bindparam(":status",$statusY);
        $stmt->bindparam(":uID",$row['user_id']);

        if ( $stmt->execute()) {
            echo "Registration successFUL";
            header("Location: ../index.php");
        }     
    }
    else
    {
        $msg = "
            <div class='alert alert-error'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Bitch!!</strong> Ain't nobody know what you're talking about : <a href='signup.php'>Signup here</a>
            </div>
        ";
    }
}
else
{
    $user->redirect('../index.php');
    echo "What the actual FUUUUUUUUUCCCCCCCCKKKKKKKK???????!!!!!!!";
}
?>