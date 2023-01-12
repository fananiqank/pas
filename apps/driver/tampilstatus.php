<?php
echo $_GET['status'];
	if($_GET['status'] != ''){
?>
	<option value='1' <?php if($_GET['status'] == 1){echo "selected";}?>>Aktif</option> 
	<option value='0' <?php if($_GET['status'] == 0){echo "selected";}?>>Non Aktif</option>
<?php 
	} else {
			echo "<option value='1'>Aktif</option>";
	}
 ?>
