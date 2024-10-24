<?php
require('./db_connect.php'); // Include the database connection

if (isset($_POST['create'])) {
    // Retrieve form data
    $Fname = $_POST['Fname'];
    $Mname = $_POST['Mname'];
    $Lname = $_POST['Lname'];

    // Prepare and bind
    $stmt = $db->prepare("INSERT INTO ces2 (FirstName, MiddleName, LastName) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $Fname, $Mname, $Lname);

    if ($stmt->execute()) {
        // Display success message and redirect
        echo '<script>alert("Successfully Created!")</script>';
        echo '<script>window.location.href = "index.php"</script>';
    } else {
        echo "Database insertion failed.";
    }

    $stmt->close();
}

