<?php 
	if($_GET['reload'] == 1) {
		session_start();
		require_once "../../webclass.php";
		$db = new kelas();
	}
?>

    <div class="form-group row">
        <label class="col-sm-2 control-label" for="w1-username">Tgl Transaksi</label>
        <div class="col-sm-4">
            <input type="date" class="form-control input-sm" name="date_brgmasuk" id="date_brgmasuk" value="">
            <input type="hidden" class="form-control input-sm" name="id_brgmasuk" id="id_brgmasuk">
        </div>
        <label class="col-sm-2 control-label" for="w1-username">Nama Supplier</label>
        <div class="col-sm-4">
            <select class="select2 form-control block headmas" id="supp_id" name="supp_id">
                    <?php include "tampilsupplier.php"; ?>
            </select>
        </div>
        
    </div>
    <div class="form-group row">
        <label class="col-sm-2 control-label" for="w1-username">Surat Jalan</label>
        <div class="col-sm-4">
            <input type="text" class="form-control input-sm" name="no_sj" id="no_sj">
        </div>
         <label class="col-sm-2 control-label" for="w1-username">Gudang</label>
        <div class="col-sm-4">
            <select class="select2" id="id_gudang" name="id_gudang">
                <?php include "tampilgudang.php"; ?>
            </select>
        </div>
    </div>
   