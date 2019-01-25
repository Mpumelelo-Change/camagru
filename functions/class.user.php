<?php

require_once 'config/setup.php';

class USER
{

    private $conn;

    public function __construct()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_pass = "kannon";
        $db_naam = "camagru_db";

        try
        {
            $this->conn = new PDO("mysql:host={$db_host};db_name={$db_naam}", $db_user, $db_pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function runQuery($sql)
    {    
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    public function lastID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }

    public function register($uname, $email, $upass, $code)
    {
        try
        {
            $pass = hash('sha256', $upass.$email);
            $stmt = $this->conn->prepare("INSERT INTO camagru_db.users(user_name, user_mail, user_pass, user_token) VALUES(:user_naam, :user_mail, :d_pass, :active_code)");

            $stmt->bindparam(":user_naam", $uname);
            $stmt->bindparam(":user_mail", $email);
            $stmt->bindparam(":d_pass", $pass);
            $stmt->bindparam(":active_code", $code);
            $stmt->execute();
            return $stmt;
        }
        catch (PDOException $e)
        {
            echo "dada" . $e->getMessage();
        }
    }

    public function login($email, $upass)
    {
        try
        {
            $stmt = $this->conn->prepare("SELECT * FROM camagru_db.users WHERE user_mail=:email_id");
            $stmt->bindparam(":email_id", $email);
            $stmt->execute();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() == 1)
            {
                if ($userRow['user_stat']=="Y")
                {
                    if ($userRow['user_pass'] == hash('sha256', $upass.$email))
                    {
                        $_SESSION['user_session'] = $userRow['user_id'];
                        return true;
                    }
                    else
                    {
                        header("Location: ../index.php?error");
                        exit;
                    }
                }
                else
                {
                    header("Location: ../index.php?inactive");
                    exit;
                }
            }
            else
            {
                header("Location: ../index.php?error");
                exit;
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function is_logged_in()
    {
        if (isset($_SESSION['user_session']))
        {
            return true;
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        session_destroy();
        $_SESSION['user_session'] = false;
    }

    function send_mail($email, $message, $subject)
    {
        mail($email, $subject, $message);
    }

    public function merge_images($image_main, $overlay_image)
    {
        // Create image instances
        $dest = imagecreatefromjpeg('php.gif');
        $src = imagecreatefromjpeg('php.gif');

        // Copy and merge
        imagecopymerge($dest, $src, 10, 10, 0, 0, 100, 47, 75);

        // Output and free from memory
        header('Content-Type: image/gif');
        imagegif($dest);

        imagedestroy($dest);
        imagedestroy($src);
    } 
}
?>