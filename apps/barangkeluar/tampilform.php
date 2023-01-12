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
            <input type="date" class="form-control input-sm" name="date_brgkeluar" id="date_brgkeluar" value="">
            <input type="hidden" class="form-control input-sm" name="id_brgkeluar" id="id_brgkeluar">
        </div>
       <label class="col-sm-2 control-label" for="w1-username">Gudang</label>
        <div class="col-sm-4">
            <select class="select2" id="id_gudang" name="id_gudang">
                <?php include "tampilgudang.php"; ?>
            </select>
        </div>
    </div>

   