<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Master Mekanik</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    
    <div class="col-md-6">        
    <form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
      <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Nama Mekanik</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="name_mekanik" id="name_mekanik">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Alamat</label>
            <div class="col-sm-8">
                <input type="input" class="form-control input-sm" name="alamat_mekanik" id="alamat_mekanik" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Telp</label>
            <div class="col-sm-8">
                <input type="input" class="form-control input-sm" name="telp_mekanik" id="telp_mekanik" required>
                <input type="hidden" class="form-control input-sm" name="id_mekanik" id="id_mekanik">
            </div>
        </div>
         <!-- <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username"></label>
            <div class="col-sm-8">
                
                <select class="select2 form-control block" id="id_site" name="id_site" required>
                        <?php
                        include"tampilsite.php";

                        ?>
                </select>
            </div>
        </div> -->
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Vendor</label>
            <div class="col-sm-8">
                
                <select class="select2 form-control block" id="supp_id" name="supp_id" required>
                        <?php
                        include"tampilsupplier.php";

                        ?>
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

    <div class="col-lg-6">
        <div class="table-responsive">
            <table class="table table-striped table-bordered server-side" id="customertable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Vendor</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Vendor</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
                                                    