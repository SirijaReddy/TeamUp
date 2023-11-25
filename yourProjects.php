<!DOCTYPE html>
<html lang="en">

<head>
    <title>TeamUp</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .adminbox {
            width: 90%;
            height: 1%;
            background-color: #14365e;
            color: #fff;
            border: 1px solid #000;
            cursor: pointer;
            text-align: right;
            line-height: 1%;
            /* Vertically center content */
            border-radius: 50px;
            margin-top: 5%;
            display: inline-block;
        }

        .inbox {
            background-color: #fff;
            color: #14365e;
            border-radius: 50px;
            font-size: xx-large;
            display: inline-block;
            padding: 20px;
        }

        .adminbox:hover {
            background-color: #f0f0f0;
        }

        .table-container {
            margin-top: 30px;
        }

        table {
            width: 100%;
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
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <h1>Completed Projects</h1>
            <div class="table-container" id="table1">
                <?php
                $username = $_SESSION['username'];
                $user_id = $_SESSION['user_id'];
                $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');

                $query = "SELECT cp.project_id, cp.project_name, cp.team_id
                FROM current_project cp
                JOIN user_teams ut ON cp.team_id = ut.team_id
                WHERE cp.status = 'completed' AND ut.user_id = '$user_id';";

                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    echo '<table border="1">';
                    echo '<tr>';
                    echo '<th>Project ID</th>';
                    echo '<th>Project Name</th>';
                    echo '<th>Team ID</th>';
                    echo '</tr>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['project_id'] . '</td>';
                        echo '<td>' . $row['project_name'] . '</td>';
                        echo '<td>' . $row['team_id'] . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    echo 'No completed projects found';
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/new_main.js"></script>
</body>

</html>
