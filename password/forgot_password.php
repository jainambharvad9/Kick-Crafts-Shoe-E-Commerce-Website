<?php
session_start();
include 'db.php'; // Database connection

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

        /* * {
     margin: 0;
     padding: 0;
     box-sizing: border-box;
     font-family: "Open Sans", sans-serif;
 }

 body {
     
 } */

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

        .main_container::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            /* background: url("imges/s10.jpeg"), #000; */
            background-position: center;
            background-size: cover;
        }

        .wrapper {
            width: 400px;
            border-radius: 8px;
            padding: 30px;
            margin-top: 65px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
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

        .input-field label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            color: #fff;
            font-size: 16px;
            pointer-events: none;
            transition: 0.15s ease;
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

        .input-field input:focus~label,
        .input-field input:valid~label {
            font-size: 0.8rem;
            top: 10px;
            transform: translateY(-120%);
        }

        .forget {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 25px 0 35px 0;
            color: #fff;
        }

        #remember {
            accent-color: #fff;
        }

        .forget label {
            display: flex;
            align-items: center;
        }

        .forget label p {
            margin-left: 8px;
        }

        .wrapper a {
            color: #efefef;
            text-decoration: none;
        }

        .wrapper a:hover {
            text-decoration: underline;
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
            border: 2px solid transparent;
            transition: 0.3s ease;
        }

        button:hover {
            color: #fff;
            border-color: #fff;
            background: rgba(255, 255, 255, 0.15);
        }

        .register {
            text-align: center;
            margin-top: 30px;
            color: #fff;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php include('header.php'); ?>
<div class="main_container">
<div class="wrapper">
<h2>Forgot Password</h2>
          <form action="" method="POST">
          <div class="input-field">
              <input type="email" name="email" class="form-control" placeholder="Email Address" required>
              <label>Email Address</label>
            </div>
            <button type="submit" name="sendlink" class="btn btn-primary" value="send_link">Send Link</button>
            <!-- <input type="submit" name="sendlink" class="btn btn-primary" value="send_link"/> -->
          </form>
        </div>
      </div>
</body>
</html>

<?php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function sendMail($email, $reset_token)
{
  require_once('PHPMailer/PHPMailer.php');
  require_once('PHPMailer/SMTP.php');
  require_once('PHPMailer/Exception.php');
  $mail = new PHPMailer(true);
  try {
    //Server settings
    $mail->isSMTP();                                          //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
    $mail->Username   = 'jainambharvad9@gmail.com';            //SMTP username
    $mail->Password   = 'mwfo iksv qxsp fkoy';                   //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit TLS encryption
    $mail->Port       = 465;      //465                            //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS
    // password- cgko eyjn sxem gxks

    //Recipients
    $mail->setFrom('jainambharvad9@gmail.com', 'Kicks & Crafts');
    $mail->addAddress($email);                                //Add a recipient

    //Content
    $mail->isHTML(true);                                      //Set email format to HTML
    $mail->Subject = 'Password reset link from Kicks & Craft';
    $body = "We received a request from you to reset your password !<br>
                Click the link below to reset your password:<br>
                <a href='http://localhost/kicksnstart/reset_pass.php?email=$email&reset_token=$reset_token'>Reset Password</a>";
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->MsgHTML($body);
    $mail->isHTML(true);
    $mail->send();
    return true;
  } catch (Exception $e) {
    echo'<pre>';print_r($e->getMessage());exit();
    return false;
  }
}

if (isset($_POST['sendlink'])) {
  $sql = "SELECT * FROM user where email= '$_POST[email]'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      $reset_token = bin2hex(random_bytes(16));   //generate random unique token 
      date_default_timezone_set('Asia/kolkata');
      $date = date('Y-m-d');
      $query = "UPDATE user SET resettoken='$reset_token',resettokenexpired='$date' WHERE email='$_POST[email]'";
      //print_r($query);
      if(mysqli_query($conn, $query) && sendMail($_POST['email'], $reset_token)){ 
        echo "<script>alert('Password reset link send to mail');</script>";
      } 
      else {
        echo "<script>alert('Server Down ! try again leter....');</script>";
      }
    } else {
      echo "<script>alert('Email Does Not Found.....!');</script>";
    }
  }  else {
    echo "<script>alert('Technical issue.....Informed soon');</script>";
  }
} //mi81w 120wbc
?>