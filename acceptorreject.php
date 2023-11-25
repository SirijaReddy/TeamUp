<?php
session_start(); // Start the session at the beginning of your PHP script
$username = $_SESSION['username']; // Retrieve the username
$conn = new mysqli('localhost', 'root', '', 'remote_work_collaborator'); // Connect to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['notif_id1'])) {
        // Accept button clicked
        $notif_id = $_POST['notifid1'];

        // Perform actions for Accept button (insert to user_teams and set notif_read to 0)
        $insertQuery = $conn->prepare("INSERT INTO user_teams (user_id, team_id) SELECT user_id, team_id FROM notifs WHERE notif_id = ?");
        $insertQuery->bind_param("i", $notif_id);

        if ($insertQuery->execute()) {
            // Successfully inserted into user_teams, now set notif_read to 0
            $updateQuery = $conn->prepare("UPDATE notifs SET notif_read = 0 WHERE notif_id = ?");
            $updateQuery->bind_param("i", $notif_id);

            if ($updateQuery->execute()) {
                $notification= "Notification accepted successfully.";
                header('Location: notifications.php');
                exit;
            } else {
                $notification= "Error updating notification status: " . $updateQuery->error;
                header('Location: notifications.php');
                exit;
            }

            $updateQuery->close();
        } else {
            echo "Error accepting notification: " . $insertQuery->error;
            header('Location: notifications.php');
                exit;
        }

        $insertQuery->close();
    } elseif (isset($_POST['notif_id2'])) {
        // Reject button clicked
        $notif_id = $_POST['notifid2'];

        // Perform action for Reject button (set notif_read to 0)
        $updateQuery = $conn->prepare("UPDATE notifs SET notif_read = 0 WHERE notif_id = ?");
        $updateQuery->bind_param("i", $notif_id);

        if ($updateQuery->execute()) {
            $notification= "Notification rejected successfully.";
            header('Location: notifications.php');
                exit;
        } else {
            $notification= "Error updating notification status: " . $updateQuery->error;
            header('Location: notifications.php');
                exit;
        }

        $updateQuery->close();
    }
}


$conn->close(); // Close your database connection
?>
