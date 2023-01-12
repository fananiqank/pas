<?php 
	if($_GET['reload'] == 1) {
		session_start();
		require_once "../../webclass.php";
		$db = new kelas();
	}
?>
<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">No Rangka</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm frhead" name="arm_norangka" id="arm_norangka" required>
            
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Type Armada</label>
        <div class="col-sm-8">
            <select class="select2 form-control block frhead" id="arm_type_armada" name="arm_type_armada" required>
                 <?php include "tampiltypearmada.php"; ?>
            </select>
        </div>
    </div>
    <div class="form-group row form-inline">
        <label class="col-sm-4 control-label" for="w1-username">Nopol</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm frhead" name="arm_nopol" id="arm_nopol" required>
            <input type="hidden" class="form-control input-sm frhead" name="arm_id" id="arm_id">
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">No Mesin</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm frhead" name="arm_nomesin" id="arm_nomesin" required>
        </div>
    </div>
   
    <div class="form-group row form-inline" >
        <label class="col-sm-4 control-label" for="w1-username">No Lambung</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm frhead" name="arm_nolambung" id="arm_nolambung" required />
            
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Merk</label>
        <div class="col-sm-8">
            <select class="select2 form-control block frhead" id="arm_merk" name="arm_merk" onChange="cekMerk(this.value)" required>
                <?php include "tampilmerk.php"; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Type Merk</label>
        <div class="col-sm-8">
            <select class="select2 form-control block frhead" id="arm_type" name="arm_type" required>
                
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Tahun</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm frhead" name="arm_tahun" id="arm_tahun" required/>
            
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Status Milik</label>
        <div class="col-sm-8">
            <select class="select2 form-control block frhead" id="arm_status_milik" name="arm_status_milik" required>
                 <?php include "tampilmilik.php"; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 control-label" for="w1-username">Aktif</label>
        <div class="col-sm-8">
            <select class="select2 form-control block frhead" id="arm_status" name="arm_status" required>
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