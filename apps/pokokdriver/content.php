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
            <label class="col-sm-4 control-label" for="w1-username">Tgl Mulai Basic</label>
            <div class="col-sm-8">
                <input type="date" class="form-control input-sm" name="basicdriver_tglmulai" id="basicdriver_tglmulai" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Jumlah Basic</label>
            <div class="col-sm-8">
                
                <input type="text" class="form-control input-sm" name="basicdriver_jumlah" id="basicdriver_jumlah">
                <input type="hidden" class="form-control input-sm" name="basicdriver_id" id="basicdriver_id">
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username"></label>
            <div class="col-sm-3">
                 <div id='ck'>
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
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tgl Mulai</th>
                        <th>Jumlah</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
                                                    