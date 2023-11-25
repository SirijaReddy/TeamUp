<!doctype html>
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
        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
      <?php
        // Database connection
        $username = $_SESSION['username']; // Retrieve the username
        $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');
        // Fetch data from the users table
        $query = "SELECT username, fname, lname, email, phone, major, bench FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<h2>&nbsp;&nbspAccount Info</h2><br>';
            echo '<div style="margin: 10px; padding: 10px; border: 1px solid #ccc; background-color: #f9f9f9;">';
            while ($row = $result->fetch_assoc()) {
                echo "<p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Username:</strong> <span style='margin-left: 10px;'>" . $row['username'] . "</span></p>";
                echo "<p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>First Name:</strong> <span style='margin-left: 10px;'>" . $row['fname'] . "</span></p>";
                echo "<p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Last Name:</strong> <span style='margin-left: 10px;'>" . $row['lname'] . "</span></p>";
                echo "<p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Email ID:</strong> <span style='margin-left: 10px;'>" . $row['email'] . "</span></p>";
                echo "<p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Phone Number:</strong><span style='margin-left: 10px;'>" . $row['phone'] . "</span></p>";
                echo "<p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Skills:</strong> <span style='margin-left: 10px;'>" . $row['major'] . "</span></p>";
                echo '</div>';
                echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;<a href='editaccount.php'><button type='button' class='btn btn-primary'> EDIT </button></a>";
            }
        } else {
            echo "No records found.";
        }

        // Close the database connection
        $conn->close();
        ?>

      </div>

		</div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/new_main.js"></script>
  </body>
</html>