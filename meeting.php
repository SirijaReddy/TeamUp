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
                <li class="active">
                    <a href="welcome.php"><span class="home"></span> Home</a>
                </li>
                <li>
                    <a href="jointeam.php"><span class="home"></span> Join Team</a>
                </li>
                <li>
                    <a href="meeting.php"><span class="home"></span> Meeting</a>
                </li>
                <li>
                    <a href="yourProjects.php"><span class="home"></span> Your Projects</a>
                </li>
                <li>
                    <a href="notifications.php"><span class="home"></span><table><th> Notifications <?php
                        session_start();
                        $username = $_SESSION['username'];

                        $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');
                        $rquery = "SELECT username, user_id, major, bench FROM users WHERE username = ?";
                        $stmt = $conn->prepare($rquery);
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $username= $row['username'];
                                $user_id= $row['user_id'];
                            }
                        } 
                        $query = "SELECT COUNT(*) AS num_rows
                                FROM (
                                    SELECT DISTINCT
                                        notifs.notif_id,
                                        notifs.user_id,
                                        notifs.team_id,
                                        notifs.message,
                                        notifs.notif_read,
                                        users.fname,
                                        users.lname,
                                        users.major,
                                        team.team_head
                                    FROM notifs
                                    JOIN user_teams ON notifs.team_id = user_teams.team_id
                                    JOIN users ON notifs.user_id = users.user_id
                                    JOIN team ON notifs.team_id = team.team_id
                                    WHERE team.team_head = '$user_id' AND notifs.notif_read = 1
                                ) AS subquery;";

                        $sresult = $conn->query($query);

                        if ($sresult) {
                            $row = $sresult->fetch_assoc();
                            $numRows = $row['num_rows'];
                            echo "</th><th><div style='width:20px; height: 20px;
                            border-radius: 50%;
                            background-color: red;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: white;
                            font-weight: bold;
                            margin-left: 5px;'>$numRows</div><th></table>";
                        } else {
                            echo "Error: " . $conn->error;
                        }

                        $conn->close();
                        ?>
                    </a>
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
        <div id="content" class="p-4 p-md-5 pt-5">
        <h4 style = "color: #1b2f45;">&ensp;&ensp;Create New Meeting Session &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;View Meeting History</h4>
            <div class="meeting-container">
                <div class="meeting">
                    <form method="post" action="meeting.php" class="meeting-form">
                        <label for="date">Date:</label>
                        <input type="date" name="date" required>
                        <label for="start_time">Start Time:</label>
                        <input type="datetime-local" name="start_time" required>
                        <label for="end_time">End Time:</label>
                        <input type="datetime-local" name="end_time" required>
                        <label for="subject">Subject:</label>
                        <input type="text" name="subject" maxlength="50" required>
                        <label for="team_id">Team ID:</label>
                        <input type="text" name="team_id" pattern="[0-9]*" maxlength="11" required>
                        <label for="comm_type">Communication Type:</label>
                        <select id="dropdown" name="comm_type">
                            <option value="call">Call</option>
                            <option value="In-person">In-person</option>
                        </select>
                        <input type="submit" name = "submit" style="margin-top: 8%; background-color: #fff; color: #1b2f45; margin-left: 60%" value="Create Meeting" >
                    </form>
                </div>
                <div class="meeting with-arrow">
                <a href="meeting_history.php" style = "font-size: 250px; text-align: center; padding-left: 35%">></a>
                </div>
            </div>
        </div>
    </div>

    <?php
include('connect.php'); // Include your database connection file

if (isset($_POST["submit"])) {
    if (!empty($_POST['start_time']) && !empty($_POST['end_time']) && !empty($_POST['subject']) && !empty($_POST['team_id']) && !empty($_POST['comm_type'])) {
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $subject = $_POST['subject'];
        $team_id = $_POST['team_id'];
        $comm_type = $_POST['comm_type'];

        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');



        // Insert meeting details into the database
        $insertQuery = $conn->prepare("INSERT INTO meeting (date, start_time, end_time, subject, team_id, comm_type) VALUES (?, ?, ?, ?, ?, ?)");
        $insertQuery->bind_param("ssssss",$date, $start_time, $end_time, $subject, $team_id, $comm_type);

        if ($insertQuery->execute()) {
            echo '<p><span style="color: green; font-size: 24px;"><strong>Meeting Successfully Created</strong></span></p>';
        } else {
            echo "Error inserting meeting details: " . $insertQuery->error;
        }

        // Close the prepared statement and the database connection
        $insertQuery->close();
        $conn->close();
    } else {
        echo "All fields are required!";
    }
}
?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/new_main.js"></script>
</body>
</html>
