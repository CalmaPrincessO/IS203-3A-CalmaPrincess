<?php
require('./Database.php');

if (isset($_POST['delete'])){
    $deleteID = $_POST['deleteID'];

    $querrydelete = "DELETE FROM ces2    WHERE ID = $deleteID";
    $sqldelete = mysqli_query($connection, $querrydelete);

    echo '<script>alert("Successfully Deleted!")</script>';
    echo '<script>window.location.href = "/phpces/index.php"</script>';
}
?>