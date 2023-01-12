<?php 
	if($_GET['reload'] == 1) {
		session_start();
		require_once "../../webclass.php";
		$db = new kelas();
	}
    foreach ($db->select("m_dep a JOIN m_subdep b on a.id_dep=b.id_dep","nama_dep,nama_sub","id_sub = $_GET[sub]") as $sub) {}
?>
<form class="form-user" id="form" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Departemen</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="nama_dep" id="nama_dep" value="<?=$sub[nama_dep]?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Sub Dept</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="nama_dep" id="nama_dep" value="<?=$sub[nama_sub]?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Kode Kategori</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="kd_kat" id="kd_kat" required>
            <input type="hidden" class="form-control input-sm" name="id_kat" id="id_kat">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Nama Kategori</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="nama_kat" id="nama_kat" required>
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
                <a href="javascript:void(0)" class="btn btn-warning" onclick="backsub(<?=$_GET['dep']?>)">Back</a>
        </div> 
    </div>
    <input type="hidden" class="form-control input-sm" name="iddep" id="iddep" value="<?=$_GET[dep]?>">
    <input type="hidden" class="form-control input-sm" name="idsub" id="idsub" value="<?=$_GET[sub]?>">
    <input type="hidden" name="typeform" id="typeform" value="2">
</form>