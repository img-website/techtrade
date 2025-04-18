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
    $qualification = $_POST['qualification'];
    $experience = $_POST['experience'];

    $mail = new PHPMailer(true);

    try {
        $subject = 'Career Form Submission';
        $emailBody = "<h3>New Career Form Submission</h3>
                      <p><strong>Full Name:</strong> $fullName</p>
                      <p><strong>Email:</strong> $email</p>
                      <p><strong>Mobile:</strong> $mobile</p>
                      <p><strong>City:</strong> $message</p>
                      <p><strong>Qualification:</strong> $qualification</p>
                      <p><strong>Experience:</strong> $experience</p>";

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

        // Handle File Upload
        if (!empty($_FILES['resumeCareer']['name'])) {
            $fileTmpPath = $_FILES['resumeCareer']['tmp_name'];
            $fileName = $_FILES['resumeCareer']['name'];
            $fileSize = $_FILES['resumeCareer']['size'];
            $fileType = $_FILES['resumeCareer']['type'];

            // Validate file size (Max 5MB)
            // if ($fileSize > 5 * 1024 * 1024) {
            //     echo json_encode(['success' => false, 'message' => 'File size exceeds 5MB limit.']);
            //     exit;
            // }

            $mail->addAttachment($fileTmpPath, $fileName);
        }
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
