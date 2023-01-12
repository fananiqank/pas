<?php
session_start();
// error_reporting(0);
include "../../webclass.php";
$db=new kelas();


$armada=$db->select("m_armada","*","arm_id='$_GET[id]'");

$norangka=$armada[0][arm_norangka];
?>

<table class="table" id="armadatable">
    <tr>
        <td>No Rangka</td>
        <td>:</td>
        <td><?php echo $norangka; ?></td>
        <td>Nopol</td>
        <td>:</td>
        <td><?php echo $armada[0][arm_nopol]; ?></td>
    </tr>
</table>
<form id="formku">
<div class="form-group row">
	
	    <label class="col-sm-2 control-label" for="w1-username">Customer</label>
	    <div class="col-sm-4">
	        <!-- <input type="text" class="form-control input-sm frhead" name="arm_norangka" id="arm_norangka" required> -->
	        <select class="form-control block frhead" id="cust_id" name="cust_id" onChange="cekMerk(this.value)" required>
	            <?php include "tampilcust.php"; ?>
	        </select>
	    </div>
	    <div class="col-sm-2">
	        <input type="text" class="form-control input-sm frhead" name="arm_nolambungx" id="arm_nolambungx" required onkeyup="nolam(cust_id.value)" />
	        <input type="hidden" class="form-control input-sm frhead" name="arm_nolambung" id="arm_nolambung"/>
	        <input type="hidden" class="form-control input-sm frhead" name="arm_norangka" id="arm_norangka" value="<?=$norangka?>" />
	        <input type="hidden" class="form-control input-sm frhead" name="arm_id" id="arm_id" value="<?=$_GET[id]?>" />
	    </div>
	    <div class="col-sm-2" id="nolambung"></div>
	    <div class="col-sm-2">
	         <div id='ck'>
	            <a class="btn btn-primary" role="button" tabindex="6" id="simpan" onclick="simpandetail()">Tambah</a>
	            <!-- <button type="submit" class="btn btn-info" id="simpan">Tambah</button> -->
	        </div>
	    </div> 
    
</div>
</form>
<table class="table table-striped table-bordered server-side" id="detailarmada">
    <thead>
	    <tr>
	        <th>No</th>
	        <th>Customer</th>
	        <th>No Lambung</th>
	        <th>Aksi</th>
	    </tr>
    </thead>
    <tbody id="tbodydetail">
    	<?php

    	$dtl=$db->select("m_armada a LEFT JOIN m_customer b ON a.cust_id=b.cust_id","arm_id, b.cust_name, arm_nolambung , arm_norangka","arm_norangka='$norangka'");
    	$no=1;
    	foreach($dtl as $vdtl){
    	?>
	    <tr>
	        <td><?=$no?></td>
	        <td><?=$vdtl[cust_name]?></td>
	        <td><?=$vdtl[arm_nolambung]?></td>
	        <td></td>
	    </tr>
		<?php
		$no++; 
		} 
		?>
    </tbody>
</table>

