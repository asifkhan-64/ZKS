<?php
	include '../_stream/config.php';
	session_start();
	if (empty($_SESSION["user"])) {
		header("LOCATION:../index.php");
	}

	
	$discount = $_POST['discount'];
    
    $amount = $_POST['amount'];

    	echo $percentageAmount = ceil($amount - (($amount * $discount) / 100));




?>