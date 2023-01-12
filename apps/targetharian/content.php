<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Master Target Harian</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    
    <div class="col-md-6">        
    <form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
      <!-- <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Customer</label>
            <div class="col-sm-8">
                <select class="select2 form-control block" id="cust_id" name="cust_id" required>
                    <?php include "tampilcust.php"; ?>
                </select>
                
            </div>
        </div> -->
        <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Tgl Mulai Target</label>
            <div class="col-sm-8">
                <input type="date" class="form-control input-sm" name="target_tglmulai" id="target_tglmulai" required>
            </div>
        </div>
        <!-- <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Rute</label>
            <div class="col-sm-8">
                <select class="select2 form-control block" id="rutejarak_id" name="rutejarak_id" required>
                    <?php include "tampilrute.php"; ?>
                </select>
                <input type="hidden" class="form-control input-sm" name="tarif_id" id="tarif_id">
            </div>
        </div> -->
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Shift</label>
            <div class="col-sm-8">
                <select class="select2 form-control block" id="target_shift" name="target_shift" required>
                   <option value="">Pilih Shift</option>
                   <option value="1">1</option>
                   <option value="2">2</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Type Armada</label>
            <div class="col-sm-8">
                <select class="select2 form-control block" id="target_type" name="target_type" required>
                   <option value="">Pilih Type</option>
                   <option value="1">DT</option>
                   <option value="2">SDT</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Ritase</label>
            <div class="col-sm-8">
                
                <input type="text" class="form-control input-sm" name="target_ritase" id="target_ritase">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Tonase</label>
            <div class="col-sm-8">
                
                <input type="text" class="form-control input-sm" name="target_tonase" id="target_tonase">
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
                        <th>Tgl Mulai</th>
                        <th>Type</th>
                        <th>Shift</th>
                        <th>Ritase</th>
                        <th>Tonase</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tgl Mulai</th>
                        <th>Type</th>
                        <th>Shift</th>
                        <th>Ritase</th>
                        <th>Tonase</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
</form>
