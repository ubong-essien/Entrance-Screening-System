<?php
// check request
if(isset($_GET['id']) && isset($_GET['id']) != "")
{
    // include Database connection file
include('../includes/connect.php');

    // get user id
    $time_id = $_GET['id'];

    // delete User
    $query = "DELETE FROM time_slot WHERE id = '$time_id'";
    if (!$result = mysqli_query($con,$query)) {
        exit(mysqli_error());
    }else{echo"record deleted sucessfully";
	header('location:../settings.php#tab-2');
	}
	
}
?>