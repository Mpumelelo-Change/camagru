<?php
$db_host = "localhost";
$db_naam = "camagru_db";
$db_user = "root";
$db_pass = "kannon";

$conn = new PDO("mysql:host={$db_host};db_name={$db_naam}", $db_user, $db_pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();

if (isset($_POST['user_comm'])) {
    
    $comment = $_POST['user_comm'];
    $id = $_POST['iden'];

    $stmt = $conn->prepare("INSERT INTO `camagru_db`.`comments`(`comment`, `image_id`) VALUES('$comment', '$id')");
    $stmt->execute();

    $selection = $conn->prepare("SELECT comment, image_id FROM camagru_db.comments WHERE comment='$comment'");
    $selection->execute();
    $row = $selection->fetch(PDO::FETCH_ASSOC);
    if ($selection->rowCount()) {
        $comment = $row['comment'];
        ?>
        <div class="comment_div">
            <p class="comment"><?php echo $comment; ?></p>	
        </div>
        <?php
    }
    exit;
}
?>