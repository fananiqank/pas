<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Laporan Mekanik</h2>
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
            <input type="date" name="tgl1" id="tgl1" class="form-control input-sm" value="<?=$_GET[tgl1]?>">
        </div>
        s/d
        <div class="col-sm-2">
            <input type="date" name="tgl2" id="tgl2" class="form-control input-sm" value="<?=$_GET[tgl2]?>">
        </div>
        
        <div class="col-sm-2">
            <select class="select2" id="id_mekanik" name="id_mekanik" >
                <?php include "tampilmekanik.php"; ?>
            </select>
        </div>
        <div class="col-sm-2">
            <select class="select2" id="arm_id" name="arm_id" >
                <?php include "tampilarmada.php"; ?>
            </select>
        </div>
        <div class="col-sm-2">
            <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="trtarget(id_mekanik.value,tgl1.value,tgl2.value,arm_id.value)">Search</a>
        </div>
       
    </div>
</div>
<div class="row">
    <?php foreach($db->select("m_mekanik","*","id_mekanik = '$_GET[id]'") as $mk){} ?>
    <div class="col-lg-12">
        <div class="table-responsive">
            <!-- <input style="height:26px; line-height: 0;" type="button" class="btn btn-info" value="Excel"  onclick="tableToExcel('tablestock')"></button> -->
            <table class="table table-striped table-bordered" id="tablemekanik">
                <thead>
                    <tr>
                        <th colspan="8">Periode : <?=$_GET['tgl1']." - ".$_GET['tgl2']?></th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">ID</th>
                        <th>Nama</th>
                        <th>No. MTC</th>
                        <th>Rangka-Lambung</th>
                        <th>Tgl MTC</th>
                        <th>Tgl input</th>
                        <th>Jasa</th>
                        <th style="text-align: center;">Biaya</th>
                    </tr>
                </thead>
                <tfoot align="right">
                    <tr>
                        <th colspan="7"></th>
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
