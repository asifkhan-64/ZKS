<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}
	$id = $_GET['del_id'];
	
	$deletequery = mysqli_query($connect, "DELETE FROM `add_medicines` WHERE id = '$id'");

	if (!$deletequery) {
		echo "Error";
	}else{
		header("LOCATION:pharmacy_medicine_list.php");
	}
?>