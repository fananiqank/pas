<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Master Gudang</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    
    <div class="col-md-5">        
    <form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
      <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Nama Gudang</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="nama_gudang" id="nama_gudang">
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
                <input type="hidden" class="form-control input-sm" name="id_gudang" id="id_gudang">
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
                        <th>Nama Gudang</th>
                        <th>Site</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Gudang</th>
                        <th>Site</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
                                                    