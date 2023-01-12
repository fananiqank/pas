<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Target Harian Armada</h2>
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
            <div class="col-sm-4">
                <input type="date" name="tgl1" id="tgl1" style="padding: 1%;border-radius: 5px;width: 40%">&ensp;-&ensp;<input type="date" name="tgl2" id="tgl2" style="padding: 1%;border-radius: 5px;width: 40%"></td>
            </div>
        <div class="col-sm-2">
            <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="filtermutasi(tgl1.value,tgl2.value)">Search</a>
        </div>
       
    </div>
</div>
<div class="row">
    
    <div class="col-lg-12">
        <div class="table-responsive pre-scrollable" id="laptargetharianmutasix">
            <!-- <input style="height:26px; line-height: 0;" type="button" class="btn btn-info" value="Excel"  onclick="tableToExcel('tablestock')"></button> -->
            
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
