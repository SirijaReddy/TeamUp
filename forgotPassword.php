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
<h3>Reset Password</h3>  
<form action="" method="POST" class = "form"> 
<center class="inputDeets">Username:<input type="text" name="username" maxlength="25" class = "input" required></center><br /><br>
<center class="inputDeets">Secret_question: <center><br /><br>
                        <select style="margin-bottom: 10%" class = "input" name = "question">
                            <option value="In which city were you born?">In which city were you born?</option>
                            <option value="What is your favourite movie?">What is your favourite movie?</option>
                            <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                            <option value="What is the name of your childhood best friend?">What is the name of your childhood best friend?</option>
                            <option value="What was the name of your favourite childhood toy?">What was the name of your favourite childhood toy?</option>
                            <option value="Which is your favourite season of the year?">Which is your favourite season of the year?</option>
                            <option value="What is your favourite way to relax?">What is your favourite way to relax?</option>
                        </select>
<center class="inputDeets">Secret Answer: <input type="text" name="answer" class = "input" maxlength="20"><center><br /><br>
<center class="inputDeets">Password: <input type="password" name="password" minlength="4" class = "input" required><center><br /><br>
<center class="inputDeets">Confirm password: <input type="password" name="confpassword" minlength="4" class = "input" required><center><br /><br>
<input type="submit" value="Reset Password" name="submit" class="loginButton"/>  
</fieldset>
</form>    
<?php
session_start();

include('connect.php'); // Use the database connection from your connect.php file.

if (isset($_POST["submit"])) {
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['confpassword']) && !empty($_POST['question']) && !empty($_POST['answer'])) {
        $username = $_POST['username'];
        $unhashedpassword = $_POST['password'];
        $unhashedconfpassword = $_POST['confpassword'];
        $userquestion = $_POST['question'];
        $useranswer = $_POST['answer'];

        // Password Hashing using md5 (not recommended for security reasons)
        $password = md5($unhashedpassword);

        $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');

        // Check if the username already exists
        $query = $conn->prepare("SELECT username, secret_question, secret_answer FROM users WHERE username = ?");
        $query->bind_param("s", $username);
        $query->execute();
        $query->bind_result($selectedUsername, $selectedSecretQuestion, $selectedSecretAnswer);
        $query->fetch();
        $query->close(); // Close the prepared statement

        if ($selectedUsername == $username && $selectedSecretQuestion == $userquestion && $selectedSecretAnswer == $useranswer && $unhashedpassword == $unhashedconfpassword) {
            // Update the password in the users table
            $updateQuery = "UPDATE users SET password = ? WHERE username = ?";
            $stmt = $conn->prepare($updateQuery);

            // Bind parameters
            $stmt->bind_param("ss", $password, $username);

            // Execute the update
            if ($stmt->execute()) {
                header('Location: login.php');
                exit;
            } else {
                echo "Error updating password: " . $conn->error;
            }
            $stmt->close(); // Close the prepared statement
        } else {
            echo '<p><span style="color: red; font-size: 24px;">Username doesn\'t exist or the provided information is incorrect! Please try again.</span></p>';
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "All fields are required!";
    }
}
?>

</body>  
</html>   
