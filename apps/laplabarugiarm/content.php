<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Laporan Laba Rugi Armada</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="form-group row">
    <!-- <label class="col-sm-2 control-label" for="w1-username" style="text-align: center;">Gudang</label>
        <div class="col-sm-4">
            <select class="select2" id="id_gudang" name="id_gudang" onchange="cgudang(this.value)">
                <?php //include "tampilgudang.php"; ?>
            </select>
        </div>
       
    </div> -->
        <label class="col-sm-1 control-label" for="w1-username" style="text-align: center;">Periode</label> 
        <div class="col-sm-2">
            <select class="select2 form-control block headmas" id="bpbulan" name="bpbulan" required>
                    <option value="0" <?php if($_GET[bln] == 0){echo "selected";} ?>>Pilih Bulan</option>
                    <option value="1" <?php if($_GET[bln] == 1){echo "selected";} ?>>Januari</option>
                    <option value="2" <?php if($_GET[bln] == 2){echo "selected";} ?>>Februari</option>
                    <option value="3" <?php if($_GET[bln] == 3){echo "selected";} ?>>Maret</option>
                    <option value="4" <?php if($_GET[bln] == 4){echo "selected";} ?>>April</option>
                    <option value="5" <?php if($_GET[bln] == 5){echo "selected";} ?>>Mei</option>
                    <option value="6" <?php if($_GET[bln] == 6){echo "selected";} ?>>Juni</option>
                    <option value="7" <?php if($_GET[bln] == 7){echo "selected";} ?>>Juli</option>
                    <option value="8" <?php if($_GET[bln] == 8){echo "selected";} ?>>Agustus</option>
                    <option value="9" <?php if($_GET[bln] == 9){echo "selected";} ?>>September</option>
                    <option value="10" <?php if($_GET[bln] == 10){echo "selected";} ?>>Oktober</option>
                    <option value="11" <?php if($_GET[bln] == 11){echo "selected";} ?>>November</option>
                    <option value="12" <?php if($_GET[bln] == 12){echo "selected";} ?>>Desember</option>
            </select>
        </div>
        <div class="col-sm-2">
            <select class="select2 form-control block headmas" id="bptahun" name="bptahun" required>
                <option value="0">Pilih Tahun</option>
                <?php 
                    $thn=date("Y");
                    for($i=$thn;$i>=2021;$i--){
                ?>
                <option value="<?=$i?>"  <?php if($_GET[thn] == $i){echo "selected";} ?>><?=$i?></option>
                <?php        
                    }
                ?>
            </select>
        </div>
        
        <!-- <div class="col-sm-2">
            <select class="select2" id="id_mekanik" name="id_mekanik" >
                <?php include "tampilmekanik.php"; ?>
            </select>
        </div> -->
        <div class="col-sm-2">
            <select class="select2" id="arm_id" name="arm_id" >
                <?php include "tampilarmada.php"; ?>
            </select>
        </div>
        <div class="col-sm-2">
            <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="trtarget(bpbulan.value,bptahun.value,arm_id.value)">Search</a>
        </div>
       
    </div>
</div>
<div class="row">
    
    <div class="col-lg-12">
        <div class="table-responsive">
            <!-- <input style="height:26px; line-height: 0;" type="button" class="btn btn-info" value="Excel"  onclick="tableToExcel('tablestock')"></button> -->
            <table class="table table-striped table-bordered" id="tablelaru">
                <thead>
                    <tr>
                        <th colspan="5">Periode : <?=$_GET['bln']." - ".$_GET['thn']?></th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">ID</th>
                        <th>Nama</th>
                        <th>Bulan</th>
                        <th>Armada</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tfoot align="right">
                    <tr>
                        <th colspan="4"></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
         
    </div>
</div>
</section>
<div class="modal fade text-left" id="defaultSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 100%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18"><i class="la la-list"></i>History Mutasi</h4>
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
