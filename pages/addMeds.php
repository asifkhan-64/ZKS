<?php

//add.php

include('../_stream/config.php');

if(isset($_POST["category_name"]))
{
	$category_name = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $_POST["category_name"]);

	$data = array(
		':category_name'	=>	$category_name
	);


	$selectCategory = 

                                            $optionsCategory = '<select class="meds random form-control" name="meds_name[]" style="width:100%">';

                                            while ($rowCategory = mysqli_fetch_assoc($selectCategory)) {
                                                $name = $rowCategory["medicine_name"]." / ".$rowCategory["category_name"];
                                                $nameComplete = str_replace(' ', '&nbsp;', $name);

                                                $optionsCategory.= '<option value='.$nameComplete.'>'.$nameComplete.'</option>';
                                            }
                                            $optionsCategory.= '</select>';
                                            $optionsCategory;

	$query = mysqli_query($connect, "SELECT add_medicines.*, medicine_category.category_name FROM medicine_category
                                        INNER JOIN add_medicines ON add_medicines.medicine_category = medicine_category.id");



	if($query->rowCount() == 0)
	{
		echo 'yes';
	}else {
		echo 'Not Bow';
	}
}else {
	echo "string";
}

?>