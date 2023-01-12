<?php 
	if($_GET['reload'] == 1) {
		session_start();
		require_once "../../webclass.php";
		$db = new kelas();
	}
?>
      
    <div class="form-group row form-inline">
        <label class="col-sm-2 control-label" for="w1-username">Jenis Barang</label>
        <div class="col-sm-3">
            <select class="select2 form-control block" id="jenisbrg" name="jenisbrg" onChange="cekJenis(this.value)" required>
                    <?php include "tampiljenis.php"; ?>
            </select>
        </div>
        
        <label class="col-sm-1 control-label" for="w1-username" id="pakai1" style="display: none">Pakai</label>
        <div class="col-sm-2" id="pakai2" style="display: none">
            <select class="select2 form-control block rst1" id="typepakai" name="typepakai" onChange="cekPakai(this.value)" required>
                    <option value='0'>Pilih</option> 
                    <option value='1'>Service</option> 
                    <option value='2'>Rusak</option>
            </select>
        </div>
        <label class="col-sm-1 control-label" for="w1-username" id="supplier1" style="display: none">Supplier</label>
        <div class="col-sm-2" id="supplier2" style="display: none">
            <select class="select2 form-control block rst1" id="supp_id" name="supp_id" required>
                    <?php include "tampilsupplier.php"; ?>
            </select>
        </div>
        
    </div>
    <div class="form-group row form-inline">
        <label class="col-sm-2 control-label" for="w1-username">Cari Barang</label>
        <div class="col-sm-3">
            <select class="select2 frdet rst1" id="caribrg" name="caribrg" onChange="showBrg(this.value)">
                <?php include "tampilcari.php"; ?>
            </select>
            <input type="hidden" class="form-control input-sm rst1" name="id_brgkeluardtl" id="id_brgkeluardtl">
            <input type="hidden" class="form-control input-sm rst1" name="id_barang" id="id_barang">
            <input type="hidden" class="form-control input-sm rst1" name="id_satuan" id="id_satuan">
        </div>
        <div class="col-sm-2">
                <input type="hidden" class="form-control input-sm rst1" name="stok" id="stok" readonly style="width: 100%;display: block;">
            <span id="stokshow" style="float: left;display: block"></span>
        </div>
        <!-- <div class="col-sm-2">
            <input type="text" class="form-control input-sm rst1" name="stokshow" id="stokshow" placeholder="Stok" readonly style="max-width: 100%">
            <input type="hidden" class="form-control input-sm rst1" name="stok" id="stok" readonly style="max-width: 100%">
        </div> -->
        <div class="col-sm-2">
            <input type="text" class="form-control input-sm rst1" name="qty" id="qty" placeholder="Qty" style="max-width: 100%" onkeyup="hitungqty(this.value)">
        </div>
        <div class="col-sm-1">&nbsp;</div>
        <div class="col-sm-2">
             <div id='ck'>
                <!-- <a class="btn btn-primary" role="button" tabindex="6" id="simpan"><i class="fa fa-save">  Simpan</i></a> -->
                <a href="javascript:void(0)" class="btn btn-info" onClick="simpandetail()" style="font-size: 12px;">Tambah</a>
            </div>
        </div> 
    </div>
    <input type="hidden" name="typeform" id="typeform" value="">
