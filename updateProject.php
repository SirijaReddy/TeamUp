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
            <center>
                <h3 style="color:#fff;padding-top: 10%;">TeamUp</h3>
            </center>
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
                <li class="active">
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
            <form action="" method="POST" class="form">
                <br><br>
                <p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Project Name: </strong> <span style='margin-left: 10px;'><input type="text" name="project_name" class="input" required></span></p>
                <p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Doing: </strong> <span style='margin-left: 10px;'><input type="text" name="doing" class="input" required></span></p>
                <p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Done: </strong> <span style='margin-left: 10px;'><input type="text" name="done" class="input" required></span></p>
                <p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Total Hours: </strong> <span style='margin-left: 10px;'><input type="text" placeholder="HH:MM:SS" pattern="[0-9]{2,3}:[0-9]{2}:[0-9]{2}" name="total_hours" class="input" required></span></p>
                <p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Week: </strong> <span style='margin-left: 10px;'><input type="text" name="week" class="input" required></span></p>
                <input type="submit" value="Save Changes" name="submit" class="btn btn-primary loginButton" />
            </form>

            <?php
            if (isset($_POST["submit"])) {
                // Retrieve values from the form
                $project_name = $_POST['project_name'];
                $doing = $_POST['doing'];
                $done = $_POST['done'];
                $total_hours = $_POST['total_hours'];
                $week = $_POST['week'];

                // Check if the row exists in performance_tracking
                $checkQuery = "SELECT * FROM performance_tracking WHERE project_name = ?";
                $checkStmt = $conn->prepare($checkQuery);
                $checkStmt->bind_param("s", $project_name);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();

                if ($checkResult->num_rows > 0) {
                    // Row exists, update it
                    $updateQuery = "UPDATE performance_tracking SET doing=?, done=?, total_hours=?, week=? WHERE project_name=?";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bind_param("sssss", $doing, $done, $total_hours, $week, $project_name);
                    $updateStmt->execute();
                    echo "Update successful!";
                } else {
                    // Row doesn't exist, insert a new one
                    $insertQuery = "INSERT INTO performance_tracking (project_name, doing, done, total_hours, week) VALUES (?, ?, ?, ?, ?)";
                    $insertStmt = $conn->prepare($insertQuery);
                    $insertStmt->bind_param("sssss", $project_name, $doing, $done, $total_hours, $week);
                    $insertStmt->execute();
                    echo "Insert successful!";
                }

                $checkStmt->close();
                // Close the update statement only if it was created
                if (isset($updateStmt)) {
                    $updateStmt->close();
                }
                #$insertStmt->close();
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
