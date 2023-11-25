<!doctype html>  
<html>  
<head>  
<title>TeamUp</title>  
    <style>   
    .login
    {  
        background-image :url("assets/img/hero-bg.jpg");
        background-size: cover;
        overflow:visible;
        background-attachment: fixed;
    }  
    h1 
    {  
        color: #fff;  
        font-family: verdana;  
        font-size: 100%;  
    }  
    h3 
    {  
        text-align: center;
        padding-top: 8%;
        font-weight: 1000;
        color: #fff;  
        font-family: verdana;  
        font-size: xx-large; 
    } 
    a
    {
        color: #fff;
    }
    .input
    {
        margin: auto;
        display: block;
        font-size:large;
        color: #fff;
        font-weight:bold;
        background-color: grey;
        border-radius: 25px;
    }
    .inputDeets
    {
        padding-top: 1%;
        font-size: x-large;
        color:#fff;
        font-weight:bolder;
    }
    .field
    {
        margin-top: 7%;
        background-color: rgba(0,0,0,.6);
        margin-bottom: 7%;
        margin-left: 30%;
        margin-right:30%;
    }
    .loginButton {
        background-color: rgba(86, 184, 230, 0.8);
        border-radius: 12px;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        display: inline-block;
        font-size: 16px;
    }
    </style>  
</head>  
<body class = "login">
<fieldset class = "field">
<h3>Delete Account</h3>  
<form action="" method="POST" class = "form"> 
<center class="inputDeets">Username:<input type="text" name="username" class = "input" required></center><br /><br>
<center class="inputDeets">Password: <input type="password" name="password" class = "input" required><center><br /><br>   
<input type="submit" value="Delete" name="submit" class = "loginButton"/><br>
<p><a href="welcome.php">Go Back</a> </fieldset>
</form>  
<?php
session_start();
include('connect.php');

if (isset($_POST["submit"])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $selectQuery = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
        $selectQuery->bind_param("s", $username);
        $selectQuery->execute();
        $result = $selectQuery->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $md5HashedPasswordFromDB = $row['password'];

            // Use md5() to hash the entered password and check against the stored MD5 hash
            if (md5($password) === $md5HashedPasswordFromDB) {
                $query = "DELETE FROM users WHERE username = '$username' AND password = '$md5HashedPasswordFromDB'";
            }
        $result = mysqli_query($conn, $query);

        if ($result) {
            $affected_rows = mysqli_affected_rows($conn);
            if ($affected_rows > 0) {
                // The DELETE query was successful, and $affected_rows rows were deleted
                // You can perform further actions or redirection here
                $_SESSION['success_msg'] = 'Account deleted successfully';
                echo 'Account deleted successfully';
            } else {
                // No rows were deleted, indicating incorrect username or password
                $_SESSION['error_msg'] = 'Invalid username or password';
                echo 'Invalid username or password';
            }
        } else {
            $_SESSION['error_msg'] = 'An error occurred while deleting the account';
            echo 'An error occurred while deleting the account';
        }

        mysqli_close($conn);
    }
    header('Location: register.php');
}
}
?>

</body>  
</html> 
