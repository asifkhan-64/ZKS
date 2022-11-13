<?php 
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $qty = $_POST['qty'];
    $totalPrice = $_POST['totalPrice'];
    
    $findPrice = '';




	if (is_numeric($qty) && is_numeric($totalPrice)) {
    	echo $findPrice =   $totalPrice/$qty;
	}else {
		echo $findPrice = 0;
	}		
?>