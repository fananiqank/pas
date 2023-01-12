<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Input Maintenance</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    <div class="col-md-12">
      <div class="form-group row form-inline">
            <label class="col-sm-2 control-label" for="w1-username">Tgl Transaksi</label>
            <div class="col-sm-3">
                <input type="date" class="form-control input-sm headmas" name="tgl_mtc" id="tgl_mtc" required>
            </div>
            <label class="col-sm-2 control-label" for="w1-username">Armada</label>
            <div class="col-sm-2">
                <select class="select2 form-control block headmas" id="arm_id" name="arm_id" onchange="typearmada(this.value)" required>
                    <?php include "tampilarmada.php"; ?>
                </select>
                <input type="hidden" class="form-control input-sm headmas" name="type_armada" id="type_armada" required>
            </div>
            <div class="col-sm-2">
                <select class="select2 form-control block headmas" id="id_gudang" name="id_gudang">
                    <?php include "tampilgudang.php"; ?>
                </select>
                
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username">Supplier</label>
            <div class="col-sm-3">
                <select class="select2 form-control block headmas" id="supp_mtc" name="supp_mtc">
                    <?php include "tampilsupplier.php"; ?>
                </select>
            </div>
            <label class="col-sm-2 control-label" for="w1-username">Biaya</label>
            <div class="col-sm-3">
                 <input type="text" class="form-control input-sm" id="harga_mtc" name="harga_mtc" style="width: 100%">
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username">Keterangan</label>
            <div class="col-sm-5">
                <textarea id="keterangan_mtc" name="keterangan_mtc" style="width: 100%" required></textarea>    
            </div>
            
        </div>
        <hr>
    </div>
</div>
<div class="row">
    
    <div class="col-md-6">        
    
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
        
        <div class="form-group row">
            <div class="col-sm-4">
                 <div id='ck'>
                    <!-- <a class="btn btn-primary" role="button" tabindex="6" id="simpan"><i class="fa fa-save">  Simpan</i></a> -->
                    <a href="index.php?x=maintenance" class="btn btn-warning">Back</a>
                    
                </div>
            </div> 
            <div class="col-sm-3">
                 <div id='ck'>
                    <!-- <a class="btn btn-primary" role="button" tabindex="6" id="simpan"><i class="fa fa-save">  Simpan</i></a> -->
                    <button type="submit" class="btn btn-info" id="tambah">Tambah</button>

                </div>
            </div> 
            <div class="col-sm-3">
                 <div id='ck'>
                    <!-- <a class="btn btn-primary" role="button" tabindex="6" id="simpan"><i class="fa fa-save">  Simpan</i></a> -->
                    <button type="button" onclick="simpanall()" class="btn btn-info" id="tambah">Simpan</button>
                    
                </div>
            </div> 
            
        </div>
    </form>
    </div>

    <div class="col-lg-6">
        <div class="table-responsive" style="font-size: 12px;">
            <table class="table table-striped table-bordered server-side" id="customertable" >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sparepart</th>
                        <th>Qty</th>
                        <th>Sat</th>
                        <th>Jenis</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Sparepart</th>
                        <th>Qty</th>
                        <th>Sat</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>

</section>
</form>
