<?php
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "crudtask";
$conn = mysqli_connect($servername, $username, $dbpassword, $dbname);

if (!$conn) {
    die("Database connection error: " . mysqli_connect_error());
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user details from the database
    $sql = "SELECT first_name, last_name FROM users WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $firstname = $row['first_name'];
        $lastname = $row['last_name'];

        if(isset($_GET['confirm'])) {
            if ($_GET['confirm'] === 'yes') {
                $deleteSql = "DELETE FROM users WHERE id=$id";

                if(mysqli_query($conn, $deleteSql)) {
                    header("Location: users.php");
                    exit();
                } else {
                    echo "Error Deleting the user" . mysqli_error($conn);
                    exit();
                }
            } else {
                header("Location: users.php");
                exit();
            }
        } else {
            echo '<script>
            var confirmed = confirm("Are you sure you want to delete user: ' . $firstname . ' ' . $lastname . ' from the database?");
            if (confirmed) {
                window.location.href = "deleteuser.php?id=' . $id . '&confirm=yes";
            } else {
                window.location.href = "deleteuser.php?id=' . $id . '&confirm=no";
            }
            </script>';
        }
    } else {
        echo "Error fetching user details: " . mysqli_error($conn);
    }
} else {
    header("Location: users.php");
    exit();
}
?> 

