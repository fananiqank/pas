

<!-- <form action="javascript:void(0)" method="post" id="form" name="form" onsubmit="return validateForm()"> -->
<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Kasbon Total</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    
    <div class="col-md-6">        
    <form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
      <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Driver Name</label>
            <div class="col-sm-8">
                <select class="select2 form-control block headmas" id="driver_id" name="driver_id" required>
                    <?php include "tampildriver.php"; ?>
                </select>
                <input type="hidden" class="form-control input-sm" name="tddc_id" id="tddc_id">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Jenis Kasbon</label>
            <div class="col-sm-8">
                <select class="select2 form-control block headmas" id="id_ddc" name="id_ddc" required>
                    <?php include "tampildeduction.php"; ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Jumlah</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="tddc_jumlah" id="tddc_jumlah" required>
                
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
            <table class="table table-striped table-bordered server-side" id="ddctotal">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Driver</th>
                        <th>Total Kasbon</th>
                        <th>Bayar</th>
                        <th>Sisa Kasbon</th>
                        <!-- <th>Aksi</th> -->
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Driver</th>
                        <th>Total Kasbon</th>
                        <th>Bayar</th>
                        <th>Sisa Kasbon</th>
                        <!-- <th>Aksi</th> -->
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
</form>
<div class="modal fade text-left" id="defaultSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18"><i class="la la-list"></i>History Deduction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="tampilhis">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>                                      