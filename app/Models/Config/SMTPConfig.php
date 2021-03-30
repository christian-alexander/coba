<?php
namespace App\Models\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SMTPConfig
{
    public function getSMTPConfig(){
		$mail = new PHPMailer;
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.googlemail.com';   
        $mail->SMTPAuth   = true;
        $mail->Username   = 'buatlaptoprumah@gmail.com'; // silahkan ganti dengan alamat email Anda
        $mail->Password   = '082233574795'; // silahkan ganti dengan password email Anda
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('buatlaptoprumah@gmail.com', 'Magang Informatika'); // silahkan ganti dengan alamat email Anda
        $mail->addReplyTo('buatlaptoprumah@gmail.com', 'Magang Informatika'); // silahkan ganti dengan alamat email Anda
        // Content
        $mail->isHTML(true);

        return $mail;
    }
}