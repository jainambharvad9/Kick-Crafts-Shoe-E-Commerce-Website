<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css"> <!-- Your custom CSS -->
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

        .main_container::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
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

        .message {
            text-align: center;
            color: #fff;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="main_container">
        <div class="wrapper">
            <?php 
                include 'db1.php';
                if (isset($_GET['email']) && isset($_GET['reset_token'])) {
                    date_default_timezone_set('Asia/kolkata');
                    $date = date('Y-m-d');
                    $query = "SELECT * FROM users WHERE email='$_GET[email]' AND resettoken='$_GET[reset_token]' AND resettokenexpired='$date'";
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) == 1) {
                        echo "<form method='post' action=''>
                                <h2>Reset Password</h2>
                                <div class='input-field'>
                                    <input type='password' name='password' placeholder='Enter new password' required>
                                    <label>New Password</label>
                                </div>
                                <div class='input-field'>
                                    <input type='password' name='confirm_password' placeholder='Confirm new password' required>
                                    <label>Confirm Password</label>
                                </div>
                                <input type='hidden' name='email' value='" . htmlspecialchars($_GET['email']) . "'>
                                <button type='submit' name='reset_password'>Reset Password</button>
                              </form>";
                    } else {
                        echo "<p class='message'>Invalid or Expired Link</p>";
                    }
                } else {
                    echo "<p class='message'>Invalid Request</p>";
                }

                if (isset($_POST['reset_password'])) {
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                    if ($_POST['password'] === $_POST['confirm_password']) {
                        $sql = "UPDATE users SET password = '$password', resettoken = NULL, resettokenexpired = NULL WHERE email = '$_POST[email]'";
                        if (mysqli_query($conn, $sql)) {
                            echo "<script>
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Password updated successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = 'login.php';
                                });
                            </script>";
                        } else {
                            echo "<script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update password. Please try again later.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            </script>";
                        }
                    } else {
                        echo "<script>
                            Swal.fire({
                                title: 'Error!',
                                text: 'Passwords do not match.',
                                icon: 'error',
                                confirmButtonText: 'Try Again'
                            });
                        </script>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
