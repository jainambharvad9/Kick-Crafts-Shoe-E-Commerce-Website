<?php
include 'db1.php'; // Database connection

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

        .main_container {
            background: url("imges/banner.png"), #000;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 100%;
            padding: 0 10px;
        }

        .wrapper {
            width: 400px;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .input-field {
            position: relative;
            border-bottom: 2px solid #ccc;
            margin: 15px 0;
        }

        .input-field input {
            width: 100%;
            height: 40px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 16px;
            color: #fff;
        }

        button {
            background: #fff;
            color: #000;
            font-weight: 600;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 16px;
            transition: 0.3s ease;
        }

        button:hover {
            color: #fff;
            border: 2px solid #fff;
            background: rgba(255, 255, 255, 0.15);
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<div class="main_container">
    <div class="wrapper">
        <h2>Forgot Password</h2>
        <form action="" method="POST">
            <div class="input-field">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <button type="submit" name="sendlink">Send Link</button>
        </form>
    </div>
</div>
</body>

</html>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $reset_token)
{
    require_once('PHPMailer/PHPMailer.php');
    require_once('PHPMailer/SMTP.php');
    require_once('PHPMailer/Exception.php');

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jainambharvad9@gmail.com'; // Your email
        $mail->Password = 'ufya lxkq bvsb oypn'; // Your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('jainambharvad9@gmail.com', 'Kicks & Crafts');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password reset link from Kicks & Crafts';
        $body = "We received a request from you to reset your password!<br>
                Click the link below to reset your password:<br>
                <a href='http://localhost/kicksnstart/reset_pass.php?email=$email&reset_token=$reset_token'>Reset Password</a>";
        $mail->MsgHTML($body);

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['sendlink'])) {
    $email = $_POST['email'];

    // Check if email exists in the database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Generate reset token and update database
        $reset_token = bin2hex(random_bytes(16));
        $date = date('Y-m-d H:i:s');

        $updateQuery = "UPDATE users SET resettoken = '$reset_token', resettokenexpired = '$date' WHERE email = '$email'";
        if (mysqli_query($conn, $updateQuery) && sendMail($email, $reset_token)) {
            echo "<script>alert('Password reset link sent to your email.');</script>";
        } else {
            echo "<script>alert('Server error! Please try again later.');</script>";
        }
    } else {
        echo "<script>alert('Email not found in the database.');</script>";
    }
}

?>
