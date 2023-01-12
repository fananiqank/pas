<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Master Premi Driver</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    
    <div class="col-md-6">        
    <form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
      
        <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Tgl Mulai Premi</label>
            <div class="col-sm-8">
                <input type="date" class="form-control input-sm" name="premidriver_tglmulai" id="premidriver_tglmulai" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Type</label>
            <div class="col-sm-8">
                <select class="select2 form-control block" id="premidriver_type" name="premidriver_type" required>
                    <option value="">Pilih Tipe</option>
                    <option value="1">Ritase</option>
                    <option value="2">Tonase</option>
                </select>
                <input type="hidden" class="form-control input-sm" name="premidriver_id" id="premidriver_id">
            </div>
        </div>
         <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Jumlah Premi</label>
            <div class="col-sm-8">
                
                <input type="text" class="form-control input-sm" name="premidriver_jumlah" id="premidriver_jumlah">
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
                        <th>Tipe</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tgl Mulai</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
                                                    