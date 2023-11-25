<?php
    session_start(); // Start the session at the beginning of your PHP script
    $username = $_SESSION['username']; // Retrieve the username
    $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');
    $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');
        // Fetch data from the users table
        $query = "SELECT username, user_id, major, bench FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $username= $row['username'];
                $user_id= $row['user_id'];
            }
        } else {
            echo "No records found.";
        }

?>
<!doctype html>
<html lang="en">
<head>
    <title>TeamUp</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Meeting styles */
        .meeting-container {
            padding-top: 1%;
            display: flex;
        }

        .meeting {
            width: 45%; /* Adjust the width as needed */
            padding: 15px;
            background-color: #14365e;
            border: 1px solid #326397;
            border-radius: 5px;
            color: #fff;
            text-align: left;
            margin-right: 20px; /* Add spacing between boxes */
            box-sizing: border-box;
        }
        /* .with-arrow::before {
            content: '>';
            font-size: 250px;
            width: 45%; /* Adjust the width as needed */
            /* padding: 15px;
            background-color: #14365e;
            border-radius: 5px;
            color: #fff;
            text-align: left; */
            /* margin-right: 20px; Add spacing between boxes
            box-sizing: border-box; 
        }*/

        /* Form styles */
        .meeting-form {
            width: 100%;
            padding: 10px;
        }

        .meeting-form label {
            display: flex;
            margin-bottom: 5px;
        }

        .meeting-form input[type="text"],
        .meeting-form input[type="datetime-local"],
        .meeting-form select {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .meeting-form input[type="submit"] {
            background-color: #fff;
            color: #1b2f45;
            border-radius: 25px;
            cursor: pointer;
        }
    </style>
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

          <li class="active">
              <a href="jointeam.php"><span class="home"></span> Join Team</a>
          </li>

          <li>
            <a href="meeting.php"><span class="home"></span> Meeting</a>
          </li>

          <li>
            <a href="index.php"><span class="home"></span> Your Projects</a>
          </li>

          <li>
            <a href="notifications.php"><span class="home"></span> Notifications</a>
          </li>

          <li>
                <a href="account.php"><span class="home"></span> Account</a>
          </li>

          <li>
            <a href="logout.php"><span class="home"></span> Sign out</a>
          </li>

          <li>
            <a href="deleteuser.php"><span class="delete"></span> Delete Your Account</a>
          </li>
        </ul>
        </nav>
        <div id="content" class="p-4 p-md-5 pt-5">
        <h4 style = "color: #1b2f45;">&ensp;&ensp;&ensp;&ensp;Create New Team&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Join Existing Team</h4>
            <div class="meeting-container">
            <div class="meeting">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="meeting-form">
                <label for="project_name">Project Name:</label>
                <input type="text" name="project_name" maxlength="25" required><br>
                <label for="advisor">Advisor ID:</label>
                <input type="text" pattern="[0-9]*" maxlength="11" name="advisor"><br>
                <label for="budget">Budget:</label>
                <input type="text" name="budget" pattern="[0-9]*" maxlength="11" required><br>
                <label for="due_date">Due On:</label>
                <input type="date" name="due_date" required><br>
                <class="inputDeets">Status of the Project:  <br>
                        <select style="margin-bottom: 10%" class = "input" name = "status">
                            <option value="started">Started</option>
                            <option value="mid-way">Mid-way</option>
                        </select>
                <label for="hours">Hours Taken so far:</label>
                <input type="time" name="hours" required>
                <input name="submit_form1" style="margin-top: 5%; background-color: #fff; color: #1b2f45; margin-left: 68%" type="submit" value="Create Team" >
            </form>
            <?php
            // ... (Database connection and other code)
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_form1'])) {
                $advisor = $_POST['advisor'];
                $project_name = $_POST['project_name'];
                $budget = $_POST['budget'];
                $due_date = $_POST['due_date'];
                $hours = $_POST['hours'];
                $status = $_POST['status'];

                // Prepare and execute the query for inserting into the 'team' table
                $insertTeamQuery = $conn->prepare("INSERT INTO team (team_head, advisor) VALUES (?, ?)");
                $insertTeamQuery->bind_param("ss", $user_id, $advisor);

                // Check if the team query is executed successfully
                if ($insertTeamQuery->execute()) {
                    $notificationMessageTeam = '<p><span style="color: green; font-size: 24px;"><strong>Team created successfully</strong></span></p>';
                } else {
                    $notificationMessageTeam = '<p><span style="color: red; font-size: 24px;"><strong>Error creating the team: ' . $insertTeamQuery->error . '</strong></span></p>';
                }

                // Prepare and execute the query for inserting into the 'project' table
                $insertProjectQuery = $conn->prepare("INSERT INTO project (project_name, head, budget, due_date) VALUES (?, ?, ?, ?)");
                $insertProjectQuery->bind_param("ssss", $project_name, $user_id, $budget, $due_date);

                // Check if the project query is executed successfully
                if ($insertProjectQuery->execute()) {
                    $notificationMessageProject = '<p><span style="color: green; font-size: 24px;"><strong>Project created successfully</strong></span></p>';
                } else {
                    $notificationMessageProject = '<p><span style="color: red; font-size: 24px;"><strong>Error creating the project: ' . $insertProjectQuery->error . '</strong></span></p>';
                }

                $Uquery = "SELECT project_id, head FROM project WHERE project_name = ?";
                $Ustmt = $conn->prepare($Uquery);
                $Ustmt->bind_param("s", $project_name);
                $Ustmt->execute();
                $Uresult = $Ustmt->get_result();
                if ($Uresult->num_rows > 0) {
                    while ($Urow = $Uresult->fetch_assoc()) {
                        $project_id= $Urow['project_id'];
                        $team_head= $Urow['head'];
                    }
                } else {
                    echo "No records found.";
                }
                $UTquery = "SELECT team_id FROM team WHERE team_head = ?";
                $UTstmt = $conn->prepare($UTquery);
                $UTstmt->bind_param("s", $team_head);
                $UTstmt->execute();
                $UTresult = $UTstmt->get_result();
                if ($UTresult->num_rows > 0) {
                    while ($UTrow = $UTresult->fetch_assoc()) {
                        $team_id= $UTrow['team_id'];
                    }
                } else {
                    echo "No records found.";
                }
                $insertCurrentProjectQuery = $conn->prepare("INSERT INTO current_project (project_id, project_name, team_id, status, hours) VALUES (?, ?, ?, ?, ?)");
                $insertCurrentProjectQuery->bind_param("sssss", $project_id, $project_name, $team_id, $status, $hours );

                // Check if the project query is executed successfully
                if ($insertCurrentProjectQuery->execute()) {
                    $notificationMessageProject = '<p><span style="color: green; font-size: 24px;"><strong>Project created successfully</strong></span></p>';
                } else {
                    $notificationMessageProject = '<p><span style="color: red; font-size: 24px;"><strong>Error creating the project: ' . $insertProjectQuery->error . '</strong></span></p>';
                }


                $insertUserTeamQuery = $conn->prepare("INSERT INTO user_teams (user_id, team_id) VALUES (?, ?)");
                $insertUserTeamQuery->bind_param("ss", $user_id, $team_id);

                // Check if the project query is executed successfully
                if ($insertUserTeamQuery->execute()) {
                    $notificationMessageProject = '<p><span style="color: green; font-size: 24px;"><strong>Project created successfully</strong></span></p>';
                } else {
                    $notificationMessageProject = '<p><span style="color: red; font-size: 24px;"><strong>Error creating the project: ' . $insertProjectQuery->error . '</strong></span></p>';
                }

                // Close the prepared statements
                $Ustmt->close();
                $UTstmt->close();
                $insertCurrentProjectQuery->close();
                $insertUserTeamQuery->close();
                $insertTeamQuery->close();
                $insertProjectQuery->close();
            }
            ?>

            </div>
                <div class="meeting">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="meeting-form">
                    <label for="team_id">Team ID:</label>
                    <input type="text" name="team_id" pattern="[0-9]*" maxlength="11" required><br>
                    <label for="message">Message:</label>
                    <textarea style="height: 198px; width: 350px" name="message" maxlength="100"></textarea><br>
                    <input name="submit_form2" style="margin-top: 5%; background-color: #fff; color: #1b2f45; margin-left: 73%" type="submit" value="Ask to Join" >
                </form>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_form2'])) {
                    $team_id = $_POST['team_id'];
                    $message = $_POST['message'];   
                    $notif_read = 1;
                    $checkQuery = $conn->prepare("SELECT user_id, team_id FROM user_teams WHERE user_id = ? AND team_id = (SELECT team_id FROM notifs WHERE notif_id = ?)");
                    $checkQuery->bind_param("ii", $user_id, $notif_id);
                    $checkQuery->execute();
                    $checkResult = $checkQuery->get_result();
                    if ($checkResult->num_rows == 0) {
                        $insertQuery = $conn->prepare("INSERT INTO notifs (user_id, team_id, message, notif_read) VALUES (?, ?, ?, ?)"); 
                        $insertQuery->bind_param("ssss", $user_id, $team_id, $message, $notif_read);
                        if ($insertQuery->execute()) {
                            $notificationMessage = '<p><span style="color: green; font-size: 24px;"><strong>Notification sent successfully</strong></span></p>';
                        } else {
                            $notificationMessage = '<p><span style="color: red; font-size: 24px;"><strong>Error sending the notification: ' . $insertQuery->error . '</strong></span></p>';
                        }
                            $insertQuery->close();
                            $conn->close();
                    }
                }
                ?>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/new_main.js"></script>
</body>
</html>
