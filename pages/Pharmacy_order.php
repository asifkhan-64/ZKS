<?php
	include('../_stream/config.php');
        session_start();
            if (empty($_SESSION["user"])) {
            header("LOCATION:../index.php");
        }


     $medicineCategory = $_GET['medicineCategory'];
     $category = $_GET['Category'];
     $qty = $_GET['qty'];
     $patient = $_GET['patient'];
     $reference_number = $_GET['reference_number'];
     $priceMed = $_GET['priceMed'];
     $MedIDId = $_GET['MedIDId'];


     $totalMedPrice = $priceMed * $qty;


     $status = 0;
     $medcinePrice = 0;

     $arrayExplodeMed = explode(" ", $medicineCategory);

     $arrayExplodeCat = explode(" ", $category);

     $arrayExplodeQty = explode(" ", $qty);

     $medicineCategoryId = $arrayExplodeMed[0];
     $categoryId = $arrayExplodeCat[0];
     $quantityMedicine = $arrayExplodeQty[0];

     echo $medicineCategoryId .'*****'.$categoryId.'*****'.$quantityMedicine.'*****'.$MedIDId.'**MED****';

     $query = mysqli_query($connect, "INSERT INTO medicine_order(med_id, cat_id, med_qty, med_price, patient_id, reference_no, med_price_final, med_stock_id)VALUES('$medicineCategoryId', '$categoryId', '$quantityMedicine', '$priceMed', '$patient', '$reference_number', '$totalMedPrice', '$MedIDId')");

     if(!$query) {
            echo mysqli_error($query);
        }else {
            echo "Done";
        }



?>