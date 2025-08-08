<?php
session_start();
if (isset($_POST['register'])) {
    include 'db.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // SweetAlert2 alert if email already registered
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Registration Failed',
                    text: 'Email already registered!',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            });
        </script>";
    } else {
        // Insert user data into the database
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, phone_number, address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$first_name, $last_name, $email, $password, $phone_number, $address]);

        $user_id = $pdo->lastInsertId();
        $_SESSION['user_id'] = $user_id; 
        $_SESSION['first_name'] = $first_name;

        // SweetAlert2 success alert for successful registration
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Registration Successful!',
                    text: 'Welcome, " . htmlspecialchars($first_name) . "!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = 'login.php';
                });
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
    min-height: 100vh;
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
    margin-top: 65px;
    border-radius: 8px;
    padding: 30px;
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
    /* margin-bottom: 20px; */
    color: #fff;
}

.input-field {
    position: relative;
    border-bottom: 2px solid #ccc;
    margin: 10px 0;
}

.input-field label {
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    color: #fff;
    font-size: 15px;
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
    <div class="header">
        <?php include 'header.php'; ?>
    </div>

    <div class="main_container">
        <div class="wrapper">
            <form action="register.php" method="post">
                <h2>Sign Up</h2>
                <div class="input-field">
                    <input type="text" name="first_name" required>
                    <label>Enter your First Name</label>
                </div>
                <div class="input-field">
                    <input type="text" name="last_name" required>
                    <label>Enter your Last Name</label>
                </div>
                <div class="input-field">
                    <input type="email" name="email" required>
                    <label>Enter your E-mail</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Enter your password</label>
                </div>
                <div class="input-field">
                    <input type="text" name="phone_number" required>
                    <label>Enter your Phone Number</label>
                </div>
                <div class="input-field">
                    <input type="text" name="address" required>
                    <label>Enter your Address</label>
                </div>
                <button type="submit" name="register">Sign Up</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
