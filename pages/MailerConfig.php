<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerConfig
{
    public static $host = 'smtp.gmail.com';
    public static $username = 'dunhillvillena@gmail.com';
    public static $password = 'igos ngeb jgqh khwl';
    public static $port = 587;
    public static $encryption = PHPMailer::ENCRYPTION_STARTTLS;

    public static function getMailer()
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = self::$host;
        $mail->SMTPAuth = true;
        $mail->Username = self::$username;
        $mail->Password = self::$password;
        $mail->SMTPSecure = self::$encryption;
        $mail->Port = self::$port;

        return $mail;
    }
}

