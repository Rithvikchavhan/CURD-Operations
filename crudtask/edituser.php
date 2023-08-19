 <?php

$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "crudtask";

$conn = mysqli_connect($servername, $username, $dbpassword, $dbname);

if (!$conn) {
    die("Database connection error:" . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newFirstName = $_POST['newFirstName'];
        $newLastName = $_POST['newLastName'];
        $newEmail = $_POST['newEmail'];
        $newPassword = $_POST['newPassword'];
        $newPhoneNo = $_POST['newPhoneNo'];
        $newAddress = $_POST['newAddress'];
        $newPinCode = $_POST['newPinCode'];

        $sql = "UPDATE users SET first_name='$newFirstName', last_name='$newLastName', email='$newEmail', password='$newPassword', ph_no='$newPhoneNo', address='$newAddress', pin_code='$newPinCode' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating the record:" . mysqli_error($conn);
        }
    }

    $sql = "SELECT id, first_name, last_name, email, password, ph_no, address, pin_code FROM users WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        echo "Error fetching user data: " . mysqli_error($conn);
        exit();
    }

    $row = mysqli_fetch_assoc($result);
    $plaintextPassword = $row['password'];
} else {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
<head>
    <title>Registration Form with AJAX Validation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
    <title><h2>Edit user</h2></title>
</head>
<body>
<div class="container mt-5">
    <h1>Edit User</h1>
    <form method="post">
        <div class="form-group">
            <label for="newFirstName">First Name:</label>
            <input type="text" class = "form-control" id="newFirstName" name="newFirstName" value="<?php echo $row['first_name']; ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="newLastName">Last Name:</label>
            <input type="text" class = "form-control" id="newLastName" name="newLastName" value="<?php echo $row['last_name']; ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="newEmail">Email:</label>
            <input type="text" class = "form-control" id="newEmail" name="newEmail" value="<?php echo $row['email']; ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="newPassword">Password:</label>
            <input type="text" class = "form-control" id="newPassword" name="newPassword" value="<?php echo $plaintextPassword; ?>">
        </div>
        <br>
         <div class="form-group">
            <label for="newPhoneNo">Phone Number:</label>
            <input type="number" class = "form-control" id="newPhoneNo" name="newPhoneNo" value="<?php echo $row['ph_no']; ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="newAddress">Address:</label>
            <input type="text" class = "form-control" id="newAddress" name="newAddress" value="<?php echo $row['address']; ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="newPinCode">Zip Code:</label>
            <input type="number" class = "form-control" id="newPinCode" name="newPinCode" value="<?php echo $row['pin_code']; ?>">
        </div>
        <br>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Update">
            <a href="index.php" class="btn btn-secondary">GO BACK TO USERS PAGE</a></button>
            <a href="users.php" class="btn btn-secondary">GO BACK TO REGISTRATION PAGE</a></button>
        </div>
        <br>
</div>
    </form>
    <br>
    <!-- <div>
        <button><a href="users.php">GO BACK TO USERS PAGE</a></button>
    </div>
    <div>
        <button><a href="index.php">GO BACK TO REGISTRATION PAGE</a></button>
    </div> -->
</body>
</html> 
