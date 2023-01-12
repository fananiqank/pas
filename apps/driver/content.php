<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Master Driver</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    
    <div class="col-md-5">        
    <form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
        
        <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Nama Driver</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="driver_name" id="driver_name">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Alamat</label>
            <div class="col-sm-8">
                <input type="input" class="form-control input-sm" name="driver_address" id="driver_address" required>
            </div>
        </div>
        <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Telp</label>
            <div class="col-sm-8">
                <input type="input" class="form-control input-sm" name="driver_telp" id="driver_telp" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Jenis Armada</label>
            <div class="col-sm-8">
                <select class="select2 form-control block" id="driver_armada" name="driver_armada" required>
                         <?php include "tampilarmada.php"; ?>
                </select>
                <input type="hidden" class="form-control input-sm" name="driver_id" id="driver_id">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Site / Lokasi Kerja</label>
            <div class="col-sm-8">
                
                <select class="select2 form-control block" id="id_site" name="id_site" required>
                        <?php
                        include"tampilsite.php";

                        ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Nama Bank</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="driver_bank" id="driver_bank">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">No Rekening</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="driver_rekening" id="driver_rekening">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Status</label>
            <div class="col-sm-8">
                <select class="select2 form-control block" id="status_driver" name="status_driver" required>
                        <?php
                        include"tampilstatus.php";

                        ?>
                         <option value="1">Aktif</option>
                         <option value="0">Non Aktif</option>
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
            
        </div>
    </form>
    </div>

    <div class="col-lg-7">
        <div class="table-responsive">
            <table class="table table-striped table-bordered server-side" id="customertable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telp</th>
                        <th>Tipe Armada</th>
                        <th>Site</th>
                        <th>Rekening</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telp</th>
                        <th>Tipe Armada</th>
                        <th>Site</th>
                        <th>Rekening</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
                                                    