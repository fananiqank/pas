<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Input Kasbon Driver</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    <div class="col-md-12">
      <div class="form-group row form-inline">
            <label class="col-sm-1 control-label" for="w1-username">Driver</label>
            <div class="col-sm-3">
                <select class="select2 form-control block headmas" id="driver_id" name="driver_id" required>
                    <?php include "tampildriver.php"; ?>
                </select>
            </div>
        </div>
        <div class="form-group row form-inline">
            <label class="col-sm-2 control-label" for="w1-username">Jenis Kasbon</label>
            <div class="col-sm-3">
                <select class="select2 form-control block headmas" id="id_ddc" name="id_ddc" required>
                    <?php include "tampildeduction.php"; ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username"></label>
            
            <div class="col-sm-3">
                <button type="button" onclick="detailpremi()" class="btn btn-info" id="tambah">Calculate</button>
            </div> 
            <div class="col-sm-2">
                <button type="submit" class="btn btn-success" id="tambah2" style="display: none;">Simpan</button>
                <button type="button" class="btn btn-warning" id="tambah3" style="display: block;">Ready</button>
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
<script type="text/javascript">

   
</script>