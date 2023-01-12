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
    </p>
</header>
<div class="card-body">
<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
    <div class="row">
        <div class="table-responsive">
            <table class="table table-striped table-bordered server-side" id="customertable">
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