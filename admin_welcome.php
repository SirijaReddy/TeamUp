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
        <center><h3 style="color:#fff;padding-top: 10%;">TeamUp</h3></center>
        
        <div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary"></button>
        </div>

        <!--<div class="img bg-wrap text-center py-4"></div>-->
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="admin_welcome.php"><span class="home"></span> Home</a>
          </li>

          <li>
              <a href="view_users.php"><span class="home"></span> View Users</a>
          </li>

          <li>
            <a href="view_teams.php"><span class="home"></span> View Teams</a>
          </li>

          <li>
            <a href="view_projects.php"><span class="home"></span> View Projects</a>
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
        <h1 class="mb-4">Hey, Admin!</h1>
        <h2>You can view all user details or team details...</h2>
        <p>Only you have that power!</p>
      </div>

		</div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/new_main.js"></script>
  </body>
</html>