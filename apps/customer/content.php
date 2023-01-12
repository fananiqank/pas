

<!-- <form action="javascript:void(0)" method="post" id="form" name="form" onsubmit="return validateForm()"> -->
<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Master Customer</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    
    <div class="col-md-6">        
    <form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
      <div class="form-group row form-inline">
            <label class="col-sm-4 control-label" for="w1-username">Nama Customer</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="cust_name" id="cust_name" required>
                <input type="hidden" class="form-control input-sm" name="cust_id" id="cust_id">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Alamat</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="cust_address" id="cust_address" required>
                
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">NPWP</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="cust_npwp" id="cust_npwp" required>
            </div>
        </div>
       
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Keterangan</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" tabindex="5" name="cust_desc" id="cust_desc"/>
                
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
                        <th>NPWP</th>
                        <th>Ket</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>NPWP</th>
                        <th>Ket</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
</form>
