<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Input Ritase Hauling</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    <div class="col-md-12">
      <div class="form-group row form-inline">
            <label class="col-sm-2 control-label" for="w1-username">Tgl Transaksi</label>
            <div class="col-sm-3">
                <input type="date" class="form-control input-sm headmas" name="txangkut_tgl" id="txangkut_tgl" required>
            </div>
            <label class="col-sm-2 control-label" for="w1-username">Shift</label>
            <div class="col-sm-1">
                <input type="text" class="form-control input-sm headmas" name="txangkut_shift" id="txangkut_shift" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username">Site</label>
            <div class="col-sm-3">
                <select class="select2 form-control block headmas" id="id_site" name="id_site" required>
                    <?php include "tampilsite.php"; ?>
                </select>
            </div>
            <!-- <label class="col-sm-2 control-label" for="w1-username">Rute</label> -->
           <!--  <div class="col-sm-3">
                <select class="select2 form-control block" id="rutejarak_id" name="rutejarak_id" required>
                    <?php include "tampilrute.php"; ?>
                </select>
            </div> -->
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username">Driver</label>
            <div class="col-sm-3">
                <select class="select2 form-control block headmas" id="driver_id" name="driver_id" required>
                    <?php include "tampildriver.php"; ?>
                </select>
            </div>
            <label class="col-sm-2 control-label" for="w1-username">No Lambung</label>
            <div class="col-sm-3">
                <select class="select2 form-control block headmas" id="arm_id" name="arm_id" required>
                    <?php include "tampilarmada.php"; ?>
                </select>
            </div>
        </div>
        <hr>
    </div>
</div>
<div class="row">
    
    <div class="col-md-6">        
    
      <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Rute</label>
            <div class="col-sm-8">
                <select class="select2 form-control block rst1" id="rutejarak_id" name="rutejarak_id" required>
                    <?php include "tampilrute.php"; ?>
                </select>
                
            </div>
        </div>
        <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">No SK/ID</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm rst1" name="txangkut_sk" id="txangkut_sk" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Tonase</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm rst1" name="txangkut_tonase" id="txangkut_tonase" required>
            </div>
        </div>
         <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Jam Dumping</label>
            <div class="col-sm-8">
                <input type='text' class="form-control time rst1" name="txangkut_jam" id="txangkut_jam" placeholder="Date Intervals" />

            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Isi Solar</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm rst1" name="txangkut_solar" id="txangkut_solar">
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username"></label>
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
        <div class="table-responsive">
            <table class="table table-striped table-bordered server-side" id="customertable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Rute</th>
                        <th>Tonase</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Rute</th>
                        <th>Tonase</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>

</section>
</form>
