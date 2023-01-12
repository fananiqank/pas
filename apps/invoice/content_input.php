<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Input Invoice</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    <div class="col-md-12">
      <div class="form-group row form-inline">
            <label class="col-sm-2 control-label" for="w1-username">Tgl Invoice</label>
            <div class="col-sm-2">
                <input type="date" class="form-control input-sm headmas" name="tglinvoice" id="tglinvoice" required>
            </div>
            <label class="col-sm-1 control-label" for="w1-username">Customer</label>
            <div class="col-sm-3">
                <select class="select2 form-control block headmas" id="cust_id" name="cust_id" required>
                    <?php include "tampilcust.php"; ?>
                </select>
            </div>
            <label class="col-sm-1 control-label" for="w1-username">Type Armada</label>
            <div class="col-sm-2">
                <select class="select2 form-control block headmas" id="arm_type_armada" name="arm_type_armada" required>
                    <option value="0">Pilih</option>
                    <option value="1">DT</option>
                    <option value="2">SDT</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username">Periode</label>
            <div class="col-sm-3">
                <input type="date" class="form-control input-sm headmas" name="tglmulai" id="tglmulai" required>
            </div>
            <!-- <label class="col-sm-2 control-label" for="w1-username">Rute</label> -->
            <div class="col-sm-3">
                <input type="date" class="form-control input-sm headmas" name="tglakhir" id="tglakhir" required>
            </div>
            <div class="col-sm-3">
                <button type="button" onclick="detailinv()" class="btn btn-info" id="tambah">Calculate</button>
                <button type="submit" class="btn btn-success" id="tambah">Simpan</button>
            </div> 
        </div>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-lg-12" id="detailinvoice">
        
    </div>
</div>

</section>
</form>
