<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Mutasi Barang</h2>
    <p class="card-subtitle">
        <a href="javascript:void(0)" class="btn btn-warning btn-sm" style="float: right;" onclick="backstock('<?=$_GET[id]?>','<?=$_GET[jns]?>','<?=$_GET[gd]?>')">Back</a>
    </p>
</header>
<div class="card-body">
<div class="row">
    <table class="table table-striped table-bordered" id="">
        <tr>
            <td>Periode</td>
            <td><input type="date" name="tgl1" id="tgl1" style="padding: 1%;border-radius: 5px;width: 40%" >&ensp;-&ensp;<input type="date" name="tgl2" id="tgl2" style="padding: 1%;border-radius: 5px;width: 40%" ></td>
            <td><a href="javascript:void(0)" class="btn btn-primary" onclick="filtermutasi(<?=$_GET[id]?>,<?=$_GET[gd]?>,tgl1.value,tgl2.value,<?=$_GET[jns]?>)">Search</a>
                <a href="javascript:void(0)" title="PDF" class="btn btn-danger" onclick="cetakfiltermutasi(<?=$_GET[id]?>,<?=$_GET[gd]?>,tgl1.value,tgl2.value,<?=$_GET[jns]?>)"><i class='ft-file' aria-hidden='true' style='font-size:16px;'></i></a>
            </td>

        </tr>
    </table>
</div>
<div class="row">
    
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="stockmutasi">
                <?php include "detailmutasi.php"; ?>
            </table>
        </div>
         
    </div>
</div>
</section>
<div class="modal fade text-left" id="defaultSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 100%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18"><i class="la la-list"></i>History Mutai</h4>
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