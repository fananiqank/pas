<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Input Basic & Premi Driver</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    <div class="col-md-12">
      <div class="form-group row form-inline">
            <label class="col-sm-2 control-label" for="w1-username">Periode</label>
            <div class="col-sm-2">
                <input type="date" class="form-control input-sm headmas" name="txangkut_tgl1" id="txangkut_tgl1" required>
            </div>
            <div class="col-sm-2">
                <input type="date" class="form-control input-sm headmas" name="txangkut_tgl2" id="txangkut_tgl2" required>
            </div>
            <!-- <div class="col-sm-2">
                <select class="select2 form-control block headmas" id="bpbulan" name="bpbulan" required>
                    <option value="0">Pilih Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div> -->
            <!-- <div class="col-sm-2">
                <select class="select2 form-control block headmas" id="bptahun" name="bptahun" required>
                    <option value="0">Pilih Tahun</option>
                    <?php 
                        $thn=date("Y");
                        for($i=$thn;$i>=2021;$i--){
                    ?>
                    <option value="<?=$i?>"><?=$i?></option>
                    <?php        
                        }
                    ?>
                </select>
            </div> -->
            <label class="col-sm-1 control-label" for="w1-username">Site</label>
            <div class="col-sm-3">
                <select class="select2 form-control block headmas" id="id_site" name="id_site" required>
                    <?php include "tampilsite.php"; ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username"></label>
            
            <div class="col-sm-3">
                <button type="button" onclick="detailpremi()" class="btn btn-info" id="tambah">Calculate</button>
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
