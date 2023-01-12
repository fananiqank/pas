<?php 
	if($_GET['reload'] == 1) {
		session_start();
		require_once "../../webclass.php";
		$db = new kelas();
	}
?>
<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Kode Departemen</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="kd_dep" id="kd_dep" required>
            <input type="hidden" class="form-control input-sm" name="id_dep" id="id_dep">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Nama Departemen</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="nama_dep" id="nama_dep" required>
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