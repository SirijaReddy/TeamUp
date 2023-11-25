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
                            ob_start();
                            echo "</th><th><div style='width:20px; height: 20px;
                            border-radius: 50%;
                            background-color: red;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: white;
                            font-weight: bold;
                            margin-left: 5px;'>$numRows</div><th></table>";
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
            $username = $_SESSION['username'];
            $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');

            $query = "SELECT 
                        ut.team_id,
                        cp.project_id,
                        cp.project_name,
                        cp.status,
                        pt.doing,
                        pt.done,
                        pt.total_hours,
                        pt.week
                    FROM
                        users u
                    JOIN
                        user_teams ut ON u.user_id = ut.user_id
                    JOIN
                        current_project cp ON ut.team_id = cp.team_id
                    JOIN
                        performance_tracking pt ON cp.project_name = pt.project_name
                    WHERE
                        u.username = '$username'
                        AND cp.status IN ('started', 'mid-way')";

            $result = $conn->query($query);
            $username = $_SESSION['username']; // Retrieve the username
            echo "<h1>Hey, $username</h1>";
            echo "<h2>Your current projects:</h2>";
            echo "<br>";
            echo "<br>";

            if ($result->num_rows > 0) {
                echo '<table border="1">';
                echo '<thead>';
                echo '<tr style="background-color: #14365E; color: #ffffff; width: 100%;">';
                echo '<th style="background-color: #14365E;padding: 4px 8px;text-align: center;">Team ID</th>';
                echo '<th style="background-color: #14365E;padding: 4px 8px;text-align: center;">Project ID</th>';
                echo '<th style="background-color: #14365E;padding: 4px 8px;text-align: center;">Project Name</th>';
                echo '<th style="background-color: #14365E;padding: 4px 8px;text-align: center;">Status</th>';
                echo '<th style="background-color: #14365E;padding: 4px 8px;text-align: center;">Doing</th>';
                echo '<th style="background-color: #14365E;padding: 4px 8px;text-align: center;">Done</th>';
                echo '<th style="background-color: #14365E;padding: 4px 8px;text-align: center;">Total Hours</th>';
                echo '<th style="background-color: #14365E; padding: 4px 8px; text-align: center;">Week</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td style="padding: 4px 8px;text-align: center;">' . $row['team_id'] . '</td>';
                    echo '<td style="padding: 4px 8px;text-align: center;">' . $row['project_id'] . '</td>';
                    echo '<td style="padding: 4px 8px;text-align: center;">' . $row['project_name'] . '</td>';
                    echo '<td style="padding: 4px 8px;text-align: center;">' . $row['status'] . '</td>';
                    echo '<td style="padding: 4px 8px;text-align: center;">' . $row['doing'] . '</td>';
                    echo '<td style="padding: 4px 8px;text-align: center;">' . $row['done'] . '</td>';
                    echo '<td style="padding: 4px 8px;text-align: center;">' . $row['total_hours'] . '</td>';
                    echo '<td style="padding: 4px 8px;text-align: center;">' . $row['week'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'No records found';
            }
            session_write_close();
            $conn->close();
            ?>
            <br><br>
            <form method="post" action="">
                <input type="submit" value="Update your project status" name="update" style="color: #fff; border-radius: 25px; background-color: #1b2f45;margin-bottom: 5%" /><br>
            </form>
            <?php
            session_start();
            if (isset($_POST['update'])) {
                // Perform any processing you need before redirecting

                // Redirect to another page
                header("Location: updateProject.php");
                ob_end_flush(); 
                exit(); // Ensure that no more output is sent to the browser after the redirect header
            }
            ?>
            <form method="post" action="">
                <input type="submit" value="Project Completed" name="complete" style="color: #fff; border-radius: 25px; background-color: #1b2f45;" /><br>
            </form>
            <?php
            if (isset($_POST['complete'])) {
                // Perform any processing you need before redirecting

                // Redirect to another page
                header("Location: completeProject.php");
                exit(); // Ensure that no more output is sent to the browser after the redirect header
            }
            ob_end_flush();
            ?>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/new_main.js"></script>
</body>

</html>
