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
            line-height: 1%; /* Vertically center content */
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
                <li>
                    <a href="adminwelcome.php"><span class="home"></span> Home</a>
                </li>

                <li class="active">
                    <a href="view_users.php"><span class="home"></span> View Users</a>
                </li>

                <li>
                    <a href="view_teams.php"><span class="home"></span> View team</a>
                </li>

                <li>
                    <a href="index.php"><span class="home"></span> View projects details</a>
                </li>

                <li>
                    <a href="logout.php"><span class="home"></span> Sign out</a>
                </li>
            </ul>
        </nav>
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <h1>View Users</h1>
            <div class="table-container" id="table1">
                <!-- Include the database connection -->
                <?php include 'connect.php'; ?>

                <!-- MySQL query to select specific fields from the "users" table -->
                <?php
                
                    $sql = "SELECT user_id, username, fname, lname, email, phone, major FROM users";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<table border="1">';
                        echo '<tr>';
                        echo '<th>User ID</th>';
                        echo '<th>Username</th>';
                        echo '<th>First Name</th>';
                        echo '<th>Last Name</th>';
                        echo '<th>Email</th>';
                        echo '<th>Phone</th>';
                        echo '<th>Major</th>';
                        echo '</tr>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['user_id'] . '</td>';
                            echo '<td>' . $row['username'] . '</td>';
                            echo '<td>' . $row['fname'] . '</td>';
                            echo '<td>' . $row['lname'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '<td>' . $row['phone'] . '</td>';
                            echo '<td>' . $row['major'] . '</td>';
                            echo '</tr>';
                        }

                        echo '</table>';
                    } else {
                        echo 'No records found';
                    }

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
