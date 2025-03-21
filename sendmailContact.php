<?php
// Manually include PHPMailer files
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $message = $_POST['message'];
    $subjectform = $_POST['subject'];

    $mail = new PHPMailer(true);

    try {
        $subject = 'Contact Form Submission';
        $emailBody = "<h3>New Contact Form Submission</h3>
                      <p><strong>Full Name:</strong> $fullName</p>
                      <p><strong>Email:</strong> $email</p>
                      <p><strong>Mobile:</strong> $mobile</p>
                      <p><strong>Subject:</strong> $subjectform</p>
                      <p><strong>Message:</strong> $message</p>";

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'mail.techtrade.in';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = '465';
        $mail->Username = 'hr@techtrade.in'; // Your Gmail address
        $mail->Password = 'Human_Resource@#2025$';   // Your Gmail App Password

        // Email Headers
        $mail->setFrom('hr@techtrade.in', 'Tech Trade');
        $mail->addAddress('hr@techtrade.in');

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $emailBody;

        // Send Email
        if ($mail->send()) {
            echo json_encode(['success' => true, 'message' => 'Email has been sent']);
        } else {
            echo json_encode(['success' => false, 'message' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}
?>
