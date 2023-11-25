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
<h3>Admin Login</h3>  
<form action="" method="POST" class = "form"> 
<center class="inputDeets">Username:<input type="text" name="username" class = "input" required></center><br /><br>
<center class="inputDeets">Password: <input type="password" name="password" class = "input" required><center><br /><br>   
<input type="submit" value="Login" name="submit" class = "loginButton"/><br>
</fieldset>
</form>  
<?php
include('connect.php');
if (isset($_POST["submit"])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');

        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }

        $query = " SELECT username, password FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);
    
        if ($username === 'adminUser' && $password === 'Iamtheadmin') {
            $_SESSION['username'] = $username;
            header('Location: admin_welcome.php');
        } else {
            echo '<p><strong><span style="color: red; font-size: 24px;">Wrong Username or Password!</span></strong></p>';
            $_SESSION['success_msg'] = 'invalid username or password';
        }
}
}
?>
</body>  
</html> 
