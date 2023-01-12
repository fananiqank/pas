<?php 
	if($_GET['reload'] == 1) {
		session_start();
		require_once "../../webclass.php";
		$db = new kelas();
	}
    foreach ($db->select("m_dep","nama_dep","id_dep = $_GET[dep]") as $sub) {}
?>
<form class="form-user" id="form" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Departemen</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="nama_dep" id="nama_dep" value="<?=$sub[nama_dep]?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Kode Sub Departemen</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="kd_sub" id="kd_sub" required>
            <input type="hidden" class="form-control input-sm" name="id_sub" id="id_sub">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Nama Sub Departemen</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="nama_sub" id="nama_sub" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Aktif</label>
        <div class="col-sm-8">
            <select class="select2 form-control block" id="status" name="status" required>
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
                <a href="javascript:void(0)" class="btn btn-danger" onclick="reset()">Reset</a>
        </div> 
        <div class="col-sm-2">
                <!-- <a class="btn btn-primary" role="button" tabindex="6" id="simpan"><i class="fa fa-save">  Simpan</i></a> -->
                <a href="javascript:void(0)" class="btn btn-warning" onclick="backdep()">Back</a>
        </div> 
    </div>
    <input type="hidden" class="form-control input-sm" name="iddep" id="iddep" value="<?=$_GET[dep]?>">
    <input type="hidden" name="typeform" id="typeform" value="1">
</form>