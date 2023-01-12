<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Penggunaan Solar</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">

<div class="row">
    <div class="col-12">
        <div class="btn-group float-md-right">
            <button class="btn btn-info dropdown-toggle mb-1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Transaksi</button>
            <div class="dropdown-menu arrow">
                <!-- <a class="dropdown-item" href="index.php?x=trxsolarinput"><i class="fa fa-calendar-check mr-1"></i>Input</a> -->
                <a class="dropdown-item" href="index.php?x=trxsolarupload"><i class="fa fa-cart-plus mr-1"></i> Upload</a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="ritasesolar">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal Transaksi</th>
                        <th>Shift</th>
                        <th>Total Liter</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal Transaksi</th>
                        <th>Shift</th>
                        <th>Total Liter</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
<div class="modal fade text-left" id="defaultSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18"><i class="la la-list"></i>Detail Penggunaan Solar</h4>
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