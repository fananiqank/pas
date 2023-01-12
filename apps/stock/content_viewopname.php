<style type="text/css">
    .table th, .table td {
    padding: 0.2rem 1rem;
    }
</style>
<form class="form-user" id="form" method="post" enctype="multipart/form-data" novalidate autocomplete="off">
<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Stock Opname</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
    <div class="col-md-12">
      <div class="form-group row form-inline">
            <!-- <label class="col-sm-2 control-label" for="w1-username">Tgl Transaksi</label>
            <div class="col-sm-3">
                <input type="date" class="form-control input-sm headmas" name="tgl_mtc" id="tgl_mtc" required>
            </div> -->

            <div class="col-sm-12">
                <a href="index.php?x=stockopname&id=<?=$_GET[id]?>&jns=<?=$_GET[jns]?>" class="btn btn-info btn-sm" style="float:right">Stock Opname</a>
            </div>
            
        </div>
        
    </div>
</div>
<div class="row">
        <hr>     
    <div class="col-lg-12">
        <div class="table-responsive">                                   
        <table class='table table-striped table-bordered' style="font-size: 12px;" width='100%'>
              <thead>
                  <tr align="left">
                      <th width="5%">No</th> 
                      <th width="10%">No Stok Opname</th>
                      <th width="15%">Gudang</th>
                      <th width="15%">Jenis Barang</th>
                      <th width="15%">Tanggal</th>
                      <th width="5%">Detail</th>
                  </tr>
              </thead>   
              <tbody style="font-size: 12px;">
             
               <?php
                $num = 1;
                $tglSkrng = date('2020-11-11');
                $s = $db->query("select a.*,DATE(a.inputdt_so) tglso,b.nama_gudang from tx_stockopname a join m_gudang b on a.idgudang=b.id_gudang");
                
                foreach($s as $p){
                    if($p['jenis_brg'] == 1){$jenisbrg = 'Baru';}else{$jenisbrg= 'Bekas/Repair';}
                //$tgl = $p->tgldaftar;
                $tgl_ind = date('d-m-Y', strtotime($tgl)); 
                echo" <tr>
                        <td>$num</td>
                         <td>$p[noso]
                            <input type='hidden' id='idso' name='idso' value='$p[idso]'>
                         </td>
                         <td>$p[nama_gudang]</td>
                         <td>$jenisbrg</td>
                         <td>$p[tglso]</td>
                         <td align='center'>
                            <a href'javascript:void(0)' class='btn btn-warning btn-sm' data-id=\"$p[idso]\" data-toggle=\"modal\" id=\"detailrh\">Detail</a>
                        </td>
                    </tr>
                         ";
                
                $num++;     
                    
                }
               ?>
               
              </tbody>
         </table>
        </div>
    </div>
</div>

</section>
</form>
<div class="modal fade text-left" id="defaultSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18"><i class="la la-list"></i>Detail Stock Opname</h4>
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

<script type="text/javascript">
 function selisihstok(fisik,system,num){
    qtyselisih = (parseInt(fisik)-parseInt(system));
      $('#selisih_'+num).val(qtyselisih);
}
</script>