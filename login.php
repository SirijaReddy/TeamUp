<?php
session_start(); // Start the session
include('connect.php');

if (isset($_POST["submit"])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');
        $selectQuery = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
        $selectQuery->bind_param("s", $username);
        $selectQuery->execute();
        $result = $selectQuery->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $md5HashedPasswordFromDB = $row['password'];

            // Use md5() to hash the entered password and check against the stored MD5 hash
            if (md5($password) === $md5HashedPasswordFromDB) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['user_id'];
                header('Location: welcome.php');
                exit();
            } else {
                $_SESSION['success_msg'] = 'Invalid username or password';
                echo md5($password), $md5HashedPasswordFromDB;
            }
        } else {
            $_SESSION['success_msg'] = 'User not found';
        }
        
        $selectQuery->close();
    }
}
?>

<!DOCTYPE html>  
<html lang="en">  
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
<body class="login">
    <fieldset class="field">
        <h3>Login</h3>  
        <form action="" method="POST" class="form"> 
            <center class="inputDeets">Username:<input type="text" maxlength="25" name="username" class="input" required></center><br /><br>
            <center class="inputDeets">Password: <input type="password" name="password" class="input" required><center><br /><br>   
            <input type="submit" value="Login" name="submit" class="loginButton"/><br>
            <p><a href="register.php">Register</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="forgotPassword.php">Forgot Password</a><p><a href="adminlogin.php">Are you the admin?</a> 
        </form>  
    </fieldset>
</body>  
</html> 
