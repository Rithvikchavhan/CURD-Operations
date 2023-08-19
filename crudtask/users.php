<!DOCTYPE html>
<html>
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
<body>
    <div class="container mt-5">
        <h1>Registration Form</h1>
        <form id="registrationForm" method="post">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control" id="firstName" name="firstName">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" id="lastName" name="lastName">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">        
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
            </div>
            <div class="form-group">
                <label for="phoneNo">Phone Number:</label>
                <input type="tel" class="form-control" id="phoneNo" name="phoneNo">
            </div>
            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" class="form-control" id="Address" name="Address">
            </div>
            <div class="form-group">
                <label for="pinCode">Zipcode:</label>
                <input type="number" class="form-control" id="pinCode" name="pinCode">
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="text" class="form-control" id="dob" name="dob">
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="text" class="form-control" id="age">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register">
                <a href="index.php" class="btn btn-secondary">View Existing Users</a>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            var age="";
            $("#dob").datepicker({
                onSelect: function(value, ui) {
                    var today = new Date();
                    age = today.getFullYear() - ui.selectedYear;
                    $('#age').val(age);
                },
                changeMonth: true,
                changeYear: true,
                yearRange:"1960:2005"
            });
        });
    </script>

<script>
        $(document).ready(function() {
    $("#registrationForm").submit(function(event) {
        event.preventDefault();

        var formData = {
            firstName: $("#firstName").val(),
            lastName: $("#lastName").val(),
            email: $("#email").val(),
            password: $("#password").val(),
            confirmPassword: $("#confirmPassword").val(),
            phoneNo: $("#phoneNo").val(),
            Address: $("#Address").val(),
            pinCode: $("#pinCode").val(),
            dob: $("#dob").val(),
            age: $("#age").val()
        };

        $.ajax({
            type: "POST",
            url: "register.php",
            data: formData,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    alert("Registration successful!!");
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert("An error occurred");
            }
        });
    });
    
        });
    </script>
</body>
</html>
