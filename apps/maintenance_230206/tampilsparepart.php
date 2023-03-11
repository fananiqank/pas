
<?php 
//if($_GET['merk']){
session_start();
require_once "../../webclass.php";
$db = new kelas();
//}

?>

	<div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Jenis</label>
            <div class="col-sm-8">
                <select class="select2 form-control block" id="jenis" name="jenis" onchange="cekJenis(this.value)" >
                    <?php include "tampiljenis.php"; ?>
                </select>
            </div>
       </div>
       <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Sparepart</label>
            <div class="col-sm-8">
                <select class="select2 form-control block rst1" id="caribrg" name="caribrg" onchange="showBrg(this.value,jenis.value)" >
                    <?php include "tampilcari.php"; ?>
                </select>
                <input type="hidden" class="form-control input-sm rst1" name="id_mtcdtl" id="id_mtcdtl" >
                <input type="hidden" class="form-control input-sm rst1" name="id_barang" id="id_barang" >
                <input type="hidden" class="form-control input-sm rst1" name="id_satuan" id="id_satuan" >
            </div>
        </div>
        <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Stok</label>
            <div class="col-sm-3">
                <input type="text" class="form-control input-sm rst1" name="stok" id="stok" readonly style="width: 100%;display: block;">
            </div>
            <div class="col-sm-5"><span id="stokshow" style="float: left;display: block"></span></div>
        </div>
        <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Qty</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm rst1" name="qty" id="qty" onkeyup="hitungqty(this.value)" required>
            </div>
        </div>