<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Master Rute & Jarak</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    
    <div class="col-md-6">        
    <form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
      <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">ROM</label>
            <div class="col-sm-8">
                <select class="select2 form-control block" id="rutejarak_rom" name="rutejarak_rom" required>
                    <?php include "tampilrom.php"; ?>
                </select>
                
            </div>
        </div>
        <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Tujuan</label>
            <div class="col-sm-8">
                
                <select class="select2 form-control block" id="rutejarak_tujuan" name="rutejarak_tujuan" required>
                    <?php include "tampiltujuan.php"; ?>
                </select>
                
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Jarak (KM)</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="rutejarak_jarak" id="rutejarak_jarak" required>
                <input type="hidden" class="form-control input-sm" name="rutejarak_id" id="rutejarak_id">
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
                        <th>ROM</th>
                        <th>Tujuan</th>
                        <th>Jarak (KM)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>ROM</th>
                        <th>Tujuan</th>
                        <th>Jarak (KM)</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
</form>

<div class="modal fade text-left" id="defaultSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18"><i class="la la-list"></i>History Perubahan Jarak</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="jarakubahhis">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>
