<?php
// check request
if(isset($_GET['id']) && isset($_GET['id']) != "")
{
    // include Database connection file
include('../includes/connect.php');

    // get user id
    $user_id = mysql_real_escape_string($_GET['id']);

    // delete User
    $query = "DELETE FROM screening_users WHERE pre_id = '$user_id'";
    if (!$result = mysqli_query($con,$query)) {
        exit(mysqli_error());
    }else{echo"record deleted sucessfully";
	header('location:../settings.php');
	}
	
}
?>