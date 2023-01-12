<?php 
	if($_GET['reload'] == 1) {
		session_start();
		require_once "../../webclass.php";
		$db = new kelas();
	}
    foreach($db->select("m_barang","max(SUBSTR(kode_barang,-4)) as maxcode") as $kdbrg){}
    $urut = $kdbrg['maxcode']+1;
    $codebrg = "B".sprintf('%04s', $urut);
?>
<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
    <div class="form-group row form-inline">
        <label class="col-sm-4 control-label" for="w1-username">Kode Barang</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="kode_barang" id="kode_barang" value="<?=$codebrg?>" readonly>
            <input type="hidden" class="form-control input-sm" name="id_barang" id="id_barang">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Part Number</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="partnumber_barang" id="partnumber_barang" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Nama Barang</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="nama_barang" id="nama_barang" required>
        </div>
    </div>
   
    <div class="form-group row form-inline" >
        <label class="col-sm-4 control-label" for="w1-username">Departemen</label>
        <div class="col-sm-8">
            <select class="select2 form-control block" id="id_dep" name="id_dep" onChange="cekSubDep(this.value)" required>
                <?php include "tampildepartemen.php"; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Sub Dep</label>
        <div class="col-sm-8">
            <select class="select2 form-control block" id="id_sub" name="id_sub" onChange="cekKategori(this.value)" required>
                <?php //include "tampilsubdep.php"; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Kategori</label>
        <div class="col-sm-8">
            <select class="select2 form-control block" id="id_kat" name="id_kat" required>
                <?php //include "tampilkategori.php"; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Satuan</label>
        <div class="col-sm-8">
            <select class="select2 form-control block" id="id_satuan" name="id_satuan" required>
                <?php include "tampilsatuan.php"; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Min Stock</label>
        <div class="col-sm-5">
            <input type="text" class="form-control input-sm" name="min_stock" id="min_stock" required>
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
    
    <!-- <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Max Stock</label>
        <div class="col-sm-5">
            <input type="text" class="form-control input-sm" name="max_stock" id="max_stock" required>
        </div>
    </div> -->
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