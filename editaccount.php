<?php
        // Database connection
        session_start(); // Start the session at the beginning of your PHP script
        $username = $_SESSION['username']; // Retrieve the username
        $conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator');
        // Fetch data from the users table
        $query = "SELECT username, user_id, fname, lname, email, phone, major, bench FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $username = $row['username'];
            $user_id = $row['user_id'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $email = $row['email'];
            $phone = $row['phone'];
            $major = $row['major'];
            $bench = $row['bench'];
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
        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
        <form action="" method="POST" class = "form"><br><br>
          <p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>First Name: </strong> <span style='margin-left: 10px;'><input type="text" name="fname" maxlength="25" class = "input" value="<?php echo $fname?>"></span></p>
          <p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Last Name: </strong> <span style='margin-left: 10px;'><input type="text" name="lname" maxlength="25" class = "input" value="<?php echo $lname?>"></span></p>
          <p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Email: </strong> <span style='margin-left: 10px;'><input type="email" name="email" maxlength="25" class = "input" value="<?php echo $email?>"></span></p>
          <p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Phone: </strong> <span style='margin-left: 10px;'><input type="text" name="phone" class="input" maxlength="10" pattern="[1-9]{9}[0-9]" value="<?php echo $phone?>"></span></p>
          <p style='display: flex; font-size: 18px;'><strong style='width: 200px;'>Major: </strong> <span style='margin-left: 10px;'><input type="text" name="major" maxlength="100" class = "input" value="<?php echo $major?>"></span></p><br>
          <input type="submit" value="Save Changes" name="submit" class="btn btn-primary loginButton"/>  
        </form>    
        <?php
        //include('connect.php'); // Use the database connection from your connect.php file.
        if (isset($_POST["submit"])) {
                if($_POST['fname']!=NULL){
                    $fname = $_POST['fname'];
                }
                if($_POST['lname']!=NULL){
                    $lname = $_POST['lname'];
                }
                if($_POST['email']!=NULL){
                    $email = $_POST['email'];
                }
                if($_POST['phone']!=NULL){
                    $phone = $_POST['phone'];
                }
                if($_POST['major']!=NULL){
                    $major = $_POST['major'];
                }
                $query = "UPDATE users SET fname=?, lname=?, email=?, phone=?, major=? WHERE username=?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssssss", $fname, $lname, $email, $phone, $major, $username);
                $stmt->execute();
                $numrows = $stmt->affected_rows;
                if ($stmt->affected_rows > 0) {
                    echo "Update successful!";
                    header('Location: account.php');
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