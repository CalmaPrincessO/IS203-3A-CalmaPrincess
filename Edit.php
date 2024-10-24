<?php 
require('./Database.php');

if (isset($_POST['edit'])) {
    $editID = $_POST['editID'];
    $editF = $_POST['editF'];
    $editM = $_POST['editM'];
    $editL = $_POST['editL'];
}

if (isset($_POST['update'])) {
    $updateID = $_POST['updateID'];
    $updateF = $_POST['updateF'];
    $updateM = $_POST['updateM'];
    $updateL = $_POST['updateL'];

    $queryupdate = "UPDATE ces2 SET FirstName = '$updateF', MiddleName = '$updateM', LastName = '$updateL' WHERE ID = $updateID";
    $sqlupdate = mysqli_query($connection, $queryupdate);

    echo '<script>alert("Successfully Edited")</script>';
    echo '<script>window.location.href = "/phpces/Index.php"</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: black; /* Black background */
            color: #e0e0e0; /* Light grey text */
        }
        .container {
            max-width: 400px; /* Set a max width for a thinner layout */
            text-align: center;
            margin-top: 50px;
            border: 2px solid #666; /* Dark grey border */
            border-radius: 10px;
            padding: 20px;
            background-color: #333; /* Dark grey background for form */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Stronger shadow */
        }
        h1 {
            color: white; /* White title color */
        }
        h2 {
            color: #ccc; /* Light grey subtitle color */
        }
        input[type="text"] {
            border: 2px solid #666; /* Darker grey border */
            border-radius: 5px;
            padding: 10px;
            width: 100%; /* Full width of the container */
            margin-bottom: 15px; /* Spacing between inputs */
            background-color: #444; /* Dark input background */
            color: #e0e0e0; /* Light grey text in inputs */
        }
        input[type="text"]:focus {
            border-color: white; /* Change border on focus */
            background-color: #555; /* Slightly lighter background on focus */
        }
        input[type="submit"] {
            background-color: #666; /* Dark grey button */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            transition: background-color 0.3s; /* Smooth transition */
        }
        input[type="submit"]:hover {
            background-color: #777; /* Lighter grey on hover */
        }
    </style>
</head>
<body>
<div class="container">
    <h1><b>EDIT INFORMATION</b></h1>
    <h2>Edit user info</h2>

    <form action="" method="post">
        <input type="text" name="updateF" placeholder="Enter your Firstname" value="<?php echo $editF ?>" required /><br>
        <input type="text" name="updateM" placeholder="Enter your Middlename" value="<?php echo $editM ?>" required /><br>
        <input type="text" name="updateL" placeholder="Enter your Lastname" value="<?php echo $editL ?>" required /><br>
        <input type="submit" name="update" value="SAVE" class="btn btn-primary btn-lg"><br>
        <input type="hidden" name="updateID" value="<?php echo $editID ?>"/>
    </form>
</div>
</body>
</html>
