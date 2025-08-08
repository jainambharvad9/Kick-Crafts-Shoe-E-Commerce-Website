<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
</head>
<body>
    <?php 
        include 'db.php';
        if(isset($_GET['email']) && isset($_GET['reset_token'])){
            date_default_timezone_set('Asia/kolkata');
            $date = date('Y-m-d');
            $query = "SELECT * from user where email='$_GET[email]' and resettoken='$_GET[reset_token]' and resettokenexpired= '$date'";
            $result = mysqli_query($conn, $query);
            if($result){
                if(mysqli_num_rows($result)==1){
                  echo "<form method='post' action=''>
                        <h3>Create New Password</h3>
                        <label for='password'>New Password</label>
                        <input type='password' name='password' placeholder='Enter new password' required><br><br>
                        <label for='confirm_password'>Confirm New Password</label>
                        <input type='password' name='confirm_password' placeholder='Confirm new password' required><br><br>
                        <button type='submit' name='reset_password'>Reset Password</button>
                         <input type='hidden' name='email' value='".$_GET['email']."'>
                         <br><br>
                      </form>";
                }
                else{
                    echo "<script>alert('Invalide or Expired link..');</script>";
                }
            }
            else{
                echo "<script>alert('Server Down ! try again leter....');</script>";
            }
        }
    ?>

    <?php 
        if(isset($_POST['reset_password'])){
            $password = $_POST['password'];
            $sql ="UPDATE user SET password = '$password', resettoken = NULL, resettokenexpired = NULL WHERE email = '$_POST[email]'";
            if(mysqli_query($conn, $sql)){
                echo "<script>alert('Password Updated Successfully..');</script>";
                header('location:index.php');
            }
            else{
                echo "<script>alert('Password does not updated');</script>";
            }
        }
    ?>
</body>
</html>