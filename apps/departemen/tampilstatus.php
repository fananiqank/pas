<?php
	if($_GET['status']){
?>
	<option value='1' <?php if($_GET['status'] == 1){echo "selected";}?>>Aktif</option> 
	<option value='2' <?php if($_GET['status'] == 2){echo "selected";}?>>Non Aktif</option>
<?php 
	} else {
			echo "<option value='1'>Aktif</option>";
	}
 ?>
