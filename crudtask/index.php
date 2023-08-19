<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">



</head>
<body>
<div class="container mt-1">
    <h1>User List</h1>
    
    <div class="input-group mb-3">
            <input type="text" class="form-control" id="searchBar" placeholder="Search Records">
            <div class="input-group-append mb-1">
                <button class="btn btn-primary search-user-button"  id="searchButton">Search</button>
            </div>
    <div class="text-right mb-1">
    <button class="btn btn-primary add-user-button"><a href="users.php" style="color: white;">ADD USER</a></button>
    </div>
</div>
    <?php
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "crudtask";
    $conn = mysqli_connect($servername, $username, $dbpassword, $dbname);

    if (!$conn) {
        echo "Database connection error: " . mysqli_connect_error();
    } else {
        // Pagination settings
        $limit = 5; 
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $limit;

    
        $totalUsersQuery = "SELECT COUNT(id) as total FROM users";
        $totalResult = $conn->query($totalUsersQuery);
        $totalUsers = $totalResult->fetch_assoc()['total'];

      
        $sortOrder = 'asc';
        if (isset($_GET['dir']) && $_GET['dir'] === 'desc') {
            $sortOrder = 'desc';
        }

      
        $orderBy = "ORDER BY first_name $sortOrder";
        // $sql = "SELECT id, first_name, last_name, email, ph_no, address, pin_code FROM users LIMIT $offset, $limit";
        $sql = "SELECT id, first_name, last_name, email, ph_no, address, pin_code FROM users $orderBy LIMIT $offset, $limit";
        $result = $conn->query($sql);



        echo "<table id='example' class='table table-striped' style='width:100%'>
        <thead>
            <tr>
                <th>ID</th>
                <th><a href='index.php?dir=" . ($sortOrder === 'asc' ? 'desc' : 'asc') . "'>First Name</a></th>
                <th><a href='index.php?dir=" . ($sortOrder === 'asc' ? 'desc' : 'asc') . "'>Last Name</a></th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Pincode</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['first_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['ph_no']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['pin_code']}</td>
                    <td>
                        <a href='edituser.php?id={$row['id']}'><button class = 'btn btn-primary btn-blue'>Edit</button></a> 
                        <a href='javascript:void(0)' onclick='confirmDelete({$row['id']}, \"{$row['first_name']}\", \"{$row['last_name']}\")'><button class = 'btn btn-primary btn-red'>Delete</button></a>
                    </td>
                </tr>";
        }

        echo "</table>";
        echo "<br>";

        // Pagination links
        $totalPages = ceil($totalUsers / $limit);
        echo '<div class="pagination-center">';

        echo '<ul class="pagination">';
        if ($currentPage > 1) {
            echo "<li><a href='index.php?page=" . ($currentPage - 1) . "'>Previous</a></li>";
        }
        
        for ($page = 1; $page <= $totalPages; $page++) {
            $active = ($currentPage == $page) ? 'active' : ''; // Check if current page is active
            echo "<li class='$active'><a href='index.php?page=$page'>$page</a></li>";
        }
        if ($totalPages > $currentPage) {
            echo "<li><a href='index.php?page=" . ($currentPage + 1) . "'>Next</a></li>";
        }
        
        echo "</ul>";
        echo "</div>";
    }
    ?>
    <br>

    <script>
    function confirmDelete(id, firstname, lastname) {
        var confirmed = confirm("Are you sure you want to delete " + firstname + " " + lastname + " from the database?");
        if (confirmed) {
            $.ajax({
                type: "GET",
                url: "deleteuser.php",
                data: { id: id, confirm: "yes" },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert("Error deleting user.");
                }
            });
        }
    }
    </script>
</body>
</html>



