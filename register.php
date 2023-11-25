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
<h3>Sign Up</h3>  
<form action="" method="POST" class = "form"> 
<center class="inputDeets">Username:<input type="text" name="username" maxlength="25" class = "input" required></center><br /><br>
<center class="inputDeets">Password: <input type="password" name="password" minlength="4" class = "input" required><center><br /><br>
<center class="inputDeets">First Name: <input type="text" name="fname" maxlength="25" class = "input" required><center><br /><br>
<center class="inputDeets">Last Name: <input type="text" name="lname" maxlength="25" class = "input" required><center><br /><br>
<center class="inputDeets">Email: <input type="email" maxlength="25" name="email" class = "input" required><center><br /><br>
<center class="inputDeets">Phone: <input type="text" name="phone" class="input" required maxlength="10" pattern="[1-9]{9}[0-9]"><center><br /><br>
<center class="inputDeets">Major: <input type="text" name="major" maxlength="100" class = "input" ><center><br /><br>
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
<input type="submit" value="Register" name="submit" class="loginButton"/>  
</fieldset>
</form>    
<?php
include('connect.php'); // Use the database connection from your connect.php file.

if (isset($_POST["submit"])) {
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['major'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $major = $_POST['major'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        $role = 'user'; // Enclosed in single quotes
        $hashedPassword = md5($password);
        $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');
        // Check if the username already exists
        $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $query->bind_param("s", $username);
        $query->execute();
        $query->store_result();
        $numrows = $query->num_rows;

        if ($numrows == 0) {
            // Insert a new user
            $insertQuery = $conn->prepare("INSERT INTO users (username, password, fname, lname, email, phone, major, role, secret_question, secret_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param("ssssssssss", $username, $hashedPassword, $fname, $lname, $email, $phone, $major, $role, $question, $answer);
            if ($insertQuery->execute()) {
                echo '<p><span style="color: green; font-size: 24px;"><strong>Account Successfully Created</strong></span></p>';
                header('Location: login.php');
                exit; // Exit to prevent further execution
            } else {
                echo "Error inserting the user: " . $insertQuery->error;
            }
            $insertQuery->close(); // Close the prepared statement
        } else {
            echo '<p><span style="color: red; font-size: 24px;">That username already exists! Please try again with another.</span></p>';
        }

        // Close the prepared statement and the database connection
        $query->close();
        $conn->close();
    } else {
        echo "All fields are required!";
    }
}
?>

</body>  
</html>   
