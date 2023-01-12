<?php 
	if($_GET['reload'] == 1) {
		session_start();
		require_once "../../webclass.php";
		$db = new kelas();
	}
?>
<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Nama Satuan</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="nama_satuan" id="nama_satuan" required>
            <input type="hidden" class="form-control input-sm" name="id_satuan" id="id_satuan">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Aktif</label>
        <div class="col-sm-8">
            <select class="select2 form-control block" id="status_satuan" name="status_satuan" required>
                 <?php include "tampilstatus.php"; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username"></label>
        <div class="col-sm-3">
             <div id='ck'>
                <!-- <a class="btn btn-primary" role="button" tabindex="6" id="simpan"><i class="fa fa-save">  Simpan</i></a> -->
                <button type="submit" class="btn btn-info" id="simpan">Simpan</button>
            </div>
        </div> 
        <div class="col-sm-3">
                <!-- <a class="btn btn-primary" role="button" tabindex="6" id="simpan"><i class="fa fa-save">  Simpan</i></a> -->
                <a href="javascript:void(0)" class="btn btn-info" onclick="reset()">Reset</a>
        </div> 
    </div>
</form>