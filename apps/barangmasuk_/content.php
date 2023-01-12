<?php 
$cekhead = $db->selectcount("tx_barangmasuk","no_brgmasuk as jmlmasuk","status_brgmasuk = 1");
?>
<!-- <form action="javascript:void(0)" method="post" id="form" name="form" onsubmit="return validateForm()"> -->

<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Barang Masuk</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
    <div class="row">
        
        <div class="col-md-12" id="tampilform">        
            <?php 
                 include "tampilform.php";
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="tampilformdetail">  
            <?php include "tampilformdetail.php"; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" id="tampiltable">
            <?php include "tampiltable.php"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" id='ck' style="margin-top: 5px;" align="center">
                <!-- <a class="btn btn-primary" role="button" tabindex="6" id="simpan"><i class="fa fa-save">  Simpan</i></a> -->
            <button type="submit" class="btn btn-info" id="simpan" style="font-size: 12px;">Simpan</button>
        </div>
    </div>
</form>
</section>