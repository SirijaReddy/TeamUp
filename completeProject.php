<?php
// Database connection
session_start(); // Start the session at the beginning of your PHP script
$username = $_SESSION['username']; // Retrieve the username
$conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>TeamUp</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
<div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
        <center><h3 style="color:#fff;padding-top: 10%;">TeamUp</h3></center>
        <div class="custom-menu">
            <button type="button" id="sidebarCollapse" class="btn btn-primary"></button>
        </div>
        <ul class="list-unstyled components mb-5">
            <li>
                <a href="welcome.php"><span class="home"></span> Home</a>
            </li>
            <li>
                <a href="jointeam.php"><span class="home"></span> Join Team</a>
            </li>
            <li>
                <a href="meeting.php"><span class="home"></span> Meeting</a>
            </li>
            <li  class="active">
                <a href="yourProjects.php"><span class="home"></span> Your Projects</a>
            </li>
            <li>
                <a href="notifications.php"><span class="home"></span> Notifications</a>
            </li>
            <li>
                <a href="account.php"><span class="home"></span> Account</a>
            </li>
            <li>
                <a href="logout.php"><span class="home"></span> Sign Out</a>
            </li>
            <li>
                <a href="deleteuser.php"><span class="delete"></span> Delete Your Account</a>
            </li>
        </ul>
    </nav>
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <form action="" method="POST" class="form"><br><br>
            Project ID: <input type="text" name="project_id" class="input"><br /><br>
            <input type="submit" value="Mark Project Completed" name="submit" class="loginButton"/>
        </form>

        <?php
        if (isset($_POST["submit"])) {
            // Assuming $project_id is the project_id provided by the user
            $project_id = $_POST['project_id'];

            // Update status to "completed" in the current_project table
            $query = "UPDATE current_project SET status='completed' WHERE project_id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $project_id);
            $stmt->execute();
            $numrows = $stmt->affected_rows;
            if ($stmt->affected_rows > 0) {
                echo "Project marked as completed successfully!";
                header('Location: yourProjects.php');
            } else {
                echo "No rows were updated.";
            }

            $conn->close();
        }
        ?>

    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/new_main.js"></script>
</body>
</html>
