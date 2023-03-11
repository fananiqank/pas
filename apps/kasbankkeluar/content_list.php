<?php 
$cekhead = $db->selectcount("tx_barangmasuk","no_brgmasuk as jmlmasuk","status_brgmasuk = 1");
?>
<!-- <form action="javascript:void(0)" method="post" id="form" name="form" onsubmit="return validateForm()"> -->

<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Daftar Barang Masuk</h2>
    <p class="card-subtitle">
        <a href="index.php?x=barangmasuk" class="btn btn-warning btn-sm" style="float: right;">Back</a>
    </p>
</header>
<div class="card-body">
<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
    <div class="row">
        <div class="table-responsive">
            <table class="table table-striped table-bordered datalist" id="customertable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>No Transaksi</th>
                        <th>Supplier</th>
                        <th>NO SPJ</th>
                        <th>Tgl Masuk</th>
                        <th>Gudang</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>No Transaksi</th>
                        <th>Supplier</th>
                        <th>NO SPJ</th>
                        <th>Tgl Masuk</th>
                        <th>Gudang</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
</form>
</section>

<div class="modal fade text-left" id="defaultSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18"><i class="la la-list"></i>Detail Barang Masuk</h4>
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