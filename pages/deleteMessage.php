<?php
	include('../_stream/config.php');
    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $id = $_GET['id'];


    $deleteMessage = mysqli_query($connect, "DELETE FROM `message_tbl` WHERE id = '$id'");

    if ($deleteMessage) {
    	header("LOCATION: messages_list.php");
    }
?>