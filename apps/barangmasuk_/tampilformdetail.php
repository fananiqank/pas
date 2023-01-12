<?php 
	if($_GET['reload'] == 1) {
		session_start();
		require_once "../../webclass.php";
		$db = new kelas();
	}
?>
  
    
    <div class="form-group row form-inline">
        <!-- <label class="col-sm-2 control-label" for="w1-username">Cari Barang</label> -->
        <div class="col-sm-2">
            <select class="select2 frdet" id="caribrg" name="caribrg" onChange="showBrg(this.value)">
                <?php include "tampilcari.php"; ?>
            </select>
            <input type="hidden" class="form-control input-sm" name="id_brgmasukdtl" id="id_brgmasukdtl">
            <input type="hidden" class="form-control input-sm" name="id_barang" id="id_barang">
            <input type="hidden" class="form-control input-sm" name="id_satuan" id="id_satuan">
        </div>
        <div class="col-sm-2">
               <input type="text" class="form-control input-sm" name="qty" id="qty" placeholder="Qty" style="max-width: 100%">
        </div>
        <div class="col-sm-2">
               <input type="text" class="form-control input-sm" name="harga" id="harga" placeholder="harga" style="max-width: 100%" onkeyup="htjual(this.value)">
        </div>
        <div class="col-sm-2">
               <input type="text" class="form-control input-sm" name="hargajual" id="hargajual" placeholder="harga Jual" style="max-width: 100%" readonly>
        </div>
        <div class="col-sm-2">
            <select class="select2 frdet" id="jenisbrg" name="jenisbrg">
                <option value="1">Baru</option>
                <option value="2">Repair</option>
            </select>
        </div>
        <div class="col-sm-2">
             <div id='ck'>
                <!-- <a class="btn btn-primary" role="button" tabindex="6" id="simpan"><i class="fa fa-save">  Simpan</i></a> -->
                <a href="javascript:void(0)" class="btn btn-info" onClick="simpandetail()" style="font-size: 12px;">Tambah</a>
            </div>
        </div> 
    </div>
    <input type="hidden" name="typeform" id="typeform" value="">
