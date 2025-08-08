<?php
session_start();

if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
    // Redirect logged-in users/admins to their respective dashboards
    header("Location: " . (isset($_SESSION['admin_id']) ? 'admin_dashboard.php' : 'index.php'));
    exit();
}

include 'db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check in the user table
    $stmt_user = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt_user->execute([$email]);
    $user = $stmt_user->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Create session for the user
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];

        // Redirect with success message
        // echo "<script>
        //     document.addEventListener('DOMContentLoaded', function() {
        //         Swal.fire({
        //             title: 'Login Successful',
        //             text: 'Welcome, " . htmlspecialchars($user['first_name']) . "!',
        //             icon: 'success',
        //             showConfirmButton: false,
        //             timer: 2000
        //         }).then(function() {
        //             window.location.href = 'index.php';
        //         });
        //     });
        // </script>";
        header('location:index.php');
        exit();
    }
    
    // Check in the admin tabl
    // If login fails for both user and admin
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Login Failed',
                text: 'Incorrect email or password.',
                icon: 'error',
                confirmButtonText: 'Try Again'
            });
        });
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Your custom CSS -->
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
<!-- Include SweetAlert2 CSS and JS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navbar -->
    <?php include 'header.php'; ?>

    <div class="main_container">
        <div class="wrapper">
            <form method="POST" action="login.php">
                <h2>Login</h2>
                <div class="input-field">
                    <input type="text" name="email" required>
                    <label>Enter your email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Enter your password</label>
                </div>
                <div class="forget">
                    <label for="remember">
                        <input type="checkbox" id="remember">
                        <p>Remember me</p>
                    </label>
                    <a href="forgot_password.php">Forgot password?</a>
                </div>
                <button type="submit">Log In</button>
                <div class="register">
                    <p>Don't have an account? <a href="register.php">Register</a></p>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Footer -->
    <?php include('footer.php'); ?>
</body>
</html>