<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-6.10.0/src/Exception.php';
require 'PHPMailer-6.10.0/src/PHPMailer.php';
require 'PHPMailer-6.10.0/src/SMTP.php';

function sendConfirmationEmail($toEmail, $venue, $date, $start, $end) {
    $mail = new PHPMailer(true);

    $mail->SMTPDebug = 2;

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Use your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'chengguowei0706@gmail.com'; // ✅ Your Gmail
        $mail->Password   = 'bytg dyht mcws bzvr ';    // ✅ App Password (not your Gmail password!)
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('chengguowei0706@gmail.com', 'MMU Venue Management');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Venue Booking Confirmation';
        $mail->Body    = "
            <h3>Booking Confirmed!</h3>
            <p>Thank you for booking <strong>$venue</strong>.</p>
            <p>Date: $date</p>
            <p>Time: $start - $end</p>
            <p>See you there!</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
