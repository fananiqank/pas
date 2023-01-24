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
    <?php 
        foreach ($db->select("tx_maintenance","*,DATE(tgl_mtc) tglmtc","id_mtc = '$_GET[id]'") as $mtc){}
            if($mtc[id_mtc] != ''){$read = "readonly"; $dis = "disabled"; $act1=""; $act2="active"; $sty="style='display:none'";}else{$read = ""; $dis = ""; $act1="active"; $act2=""; $sty="style:display:block";}

    ?>
    <input type="hidden" class="form-control input-sm headmas" name="idmtc" id="idmtc" value="<?=$_GET[id]?>" required>
<div class="row">
    <div class="col-md-12">
      <div class="form-group row form-inline">
            <label class="col-sm-2 control-label" for="w1-username">Tgl Transaksi</label>
            <div class="col-sm-3">
                <input type="date" class="form-control input-sm headmas" name="tgl_mtc" id="tgl_mtc" value="<?=$mtc[tglmtc]?>" <?=$read?> required>
            </div>
            <label class="col-sm-2 control-label" for="w1-username">Armada</label>
            <div class="col-sm-2">
                <select class="select2 form-control block headmas" id="arm_id" name="arm_id" onchange="typearmada(this.value)" <?=$dis?> required>
                    <?php include "tampilarmada.php"; ?>
                </select>
                <input type="hidden" class="form-control input-sm headmas" name="type_armada" id="type_armada" <?=$read?> required>
            </div>
            <div class="col-sm-2">
                <select class="select2 form-control block headmas" id="id_gudang" name="id_gudang" <?=$dis?>>
                    <?php include "tampilgudang.php"; ?>
                </select>
                
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username">Supplier</label>
            <div class="col-sm-3">
                <select class="select2 form-control block headmas" id="supp_mtc" name="supp_mtc" onchange="supbiaya(this.value)" <?=$dis?>>
                    <?php include "tampilsupplier.php"; ?>
                </select>
            </div>
            <label class="col-sm-2 control-label" for="w1-username">Biaya</label>
            <div class="col-sm-3">
                 <input type="text" class="form-control input-sm" id="harga_mtc" name="harga_mtc" value="<?=$mtc[harga_mtc]?>" style="width: 100%" <?=$read?>>
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username">Keterangan</label>
            <div class="col-sm-4">
                <textarea id="keterangan_mtc" name="keterangan_mtc" style="width: 100%" value="<?=$mtc[keterangan_mtc]?>" required></textarea>    
            </div>
            
            <div class="col-sm-3">
                 <div id='ck'>
                    <!-- <a class="btn btn-primary" role="button" tabindex="6" id="simpan"><i class="fa fa-save">  Simpan</i></a> -->
                    
                        <a href="index.php?x=maintenance" class="btn btn-warning">Back</a>
                    <?php if($_GET['id'] == ''){ ?>
                        <button type="button" onclick="simpanall()" class="btn btn-info" id="tambah">Simpan</button>
                    <?php } ?>                    
                </div>
            </div> 
            
        </div>

       
    </div>
</div>
 <hr>
<ul class="nav nav-tabs nav-top-border no-hover-bg">
    <li class="nav-item">
        <a class="nav-link <?=$act1?>" <?=$sty?> id="base-tab11" data-toggle="tab" aria-controls="tab11" href="#tab11" aria-expanded="true">Penggantian Sparepart</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=$act2?>" id="base-tab12" data-toggle="tab" aria-controls="tab12" href="#tab12" aria-expanded="false">Mekanik</a>
    </li>
</ul>
<div class="tab-content px-1 pt-1">
    <div role="tabpanel" class="tab-pane <?=$act1?>" id="tab11" aria-expanded="true" aria-labelledby="base-tab11">
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
                            <!-- <a href="index.php?x=maintenance" class="btn btn-warning">Back</a> -->
                            
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
                            <!-- <button type="button" onclick="simpanall()" class="btn btn-info" id="tambah">Simpan</button> -->
                            
                        </div>
                    </div> 
                    
                </div>
            
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
    </div>
    <div class="tab-pane <?=$act2?>" id="tab12" aria-labelledby="base-tab12">
        <div class="row">
            <div class="col-md-6">        
              <div class="form-group row form-inline">
                    <label class="col-sm-4 control-label" for="w1-username">Nama Mekanik</label>
                    <div class="col-sm-8">
                        <select class="select2" id="mekanik" name="mekanik" >
                            <?php include "tampilmekanik.php"; ?>
                        </select>
                    </div>
               </div>
               <div class="form-group row">
                    <label class="col-sm-4 control-label" for="w1-username">Pekerjaan</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-sm" name="pekerjaan" id="pekerjaan">
                    </div>
               </div>
               <div class="form-group row form-inline">
                    <label class="col-sm-4 control-label" for="w1-username">Biaya Jasa</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-sm headmas" name="biayamekanik" id="biayamekanik">
                    </div>
               </div>
                
                
            
                    <div class="col-sm-3">
                         <div id='ck'>
                            <!-- <a class="btn btn-primary" role="button" tabindex="6" id="simpan"><i class="fa fa-save">  Simpan</i></a> -->
                            
                            <button type="button" onclick="tambahmekanik()" class="btn btn-info" id="tambahx">Simpan</button>

                        </div>
                    </div> 
                    
                </div>
                <div class="col-lg-6">
                <div class="table-responsive" style="font-size: 12px;">
                    <table class="table table-striped table-bordered mekanikx" id="customertable1" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Mekanik</th>
                                <th>Pekerjaan</th>
                                <th>Biaya Jasa</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nama Mekanik</th>
                                <th>Pekerjaan</th>
                                <th>Biaya Jasa</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                 
            </div>
            
        </div>

            
        </div>
    </div>
    
</div>

</form>
</section>
</form>
