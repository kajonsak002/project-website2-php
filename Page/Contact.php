<?php
include "../Admin/Libary.html";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('../vendor/phpmailer/src/Exception.php');
require_once('../vendor/phpmailer/src/PHPMailer.php');
require_once('../vendor/phpmailer/src/SMTP.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Instantiate PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'kajonsak6210035@gmail.com'; // SMTP username (your Gmail email)
        $mail->Password = 'kajonsak23538'; // SMTP password (your Gmail password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('your-email@gmail.com', 'Your Name'); // Set the sender email address and name
        $mail->addAddress($email, $name); // Add recipient email address and name

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = "<h3>Name: $name</h3><p>Email: $email</p><p>Message: $message</p>";

        // Send email
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
</head>
<body>
    <div class="container mt-5">
        <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="contact text-center">
                <h1><i class="fas fa-envelope"></i> Contact us</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore necessitatibus beatae, numquam qui fugit ad voluptate at quis fugiat? Pariatur soluta cupiditate rem veritatis itaque corrupti tempore facere esse inventore?</p>
            </div>
            <div class="form">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-paper-plane"></i> Submit</button>
                        <button type="button" class="btn btn-primary"><i class="fas fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
