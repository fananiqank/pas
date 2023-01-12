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
    </div>
    <div class="form-group row">
        <label class="col-sm-2 control-label" for="w1-username">Dari Gudang</label>
        <div class="col-sm-4">
            <select class="select2" id="id_gudang" name="id_gudang" onchange="cekgudang(this.value)">
                <?php include "tampilgudang.php"; ?>
            </select>
        </div>
        <label class="col-sm-2 control-label" for="w1-username">Ke Gudang</label>
        <div class="col-sm-4">
            <select class="select2" id="id_gudang2" name="id_gudang2">
                <?php  //include "tampilgudang2.php"; ?>
            </select>
        </div>
    </div>

   