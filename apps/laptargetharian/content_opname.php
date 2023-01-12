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
                <a href="index.php?x=stock&id=<?=$_GET[id]?>" class="btn btn-warning"> Back</a>
                <button id="addstokopname" type="button" class="btn btn-success" onclick="simpanstokopname()">
                <i class='fa fa-save'></i>&nbsp; Simpan</button>
                <a href="index.php?x=stockopname&id=<?=$_GET[id]?>" class="btn btn-danger"> Reset</a>
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
                  <tr align="center">
                      <th >No</th> 
                      <th width="5%">Kode Barang</th>
                      <th width="10%">Nama Barang</th>
                      <th width="5%">Satuan</th>
                      <th width="5%">Min Stock</th>
                      <th width="5%">Max Stock</th>
                      <th >Stock<br>(System)</th>
                      <th >Stock<br>(Fisik)</th>
                      <th >Selisih</th>
                      <th>Ket</th>  
                  </tr>
              </thead>   
              <tbody style="font-size: 12px;">
             
               <?php
               $num = 1;
               $tglSkrng = date('2020-11-11');
               $s = $db->select("(select b.id_barang, nama_barang,IFNULL(b.min_stock,0) as min_stock,IFNULL(b.max_stock,0) as max_stock,IFNULL(stok,0) stok,IFNULL((stok-min_stock),0) balance,b.kode_barang,c.nama_satuan from m_barang b join m_satuan c on b.id_satuan=c.id_satuan left join (select IFNULL(sum(masukmutasi)-sum(keluarmutasi),0) as stok,id_barang from tx_mutasi GROUP BY id_barang) a on b.id_barang=a.id_barang) as asi","*","");

                foreach($s as $p){

                
                //$tgl = $p->tgldaftar;
                $tgl_ind = date('d-m-Y', strtotime($tgl)); 
                echo" <tr>
                        <td>$num</td>
                         <td>$p[kode_barang]
                            <input type='hidden' id='idbarang_$num' name='idbarang[]' value='$p[id_barang]'>
                         </td>
                         <td>$p[nama_barang]</td>
                         <td>$p[nama_satuan]</td>
                         <td>$p[min_stock]</td>
                         <td>$p[max_stock]</td>
                         <td align='right'>$p[stok]
                            <input type='hidden' id='qtytotalnow_$num' name='qtytotalnow[]' value='$p[stok]'>
                         </td>
                         <td align='center'>
                            <input type='text' id='fisik_$num' name='fisik[]' class='form-control' style='width:90%;font-size:14px' onkeyup='selisihstok(this.value,$stok,$num)' >
                        </td>
                        <td align='center'>
                            <input type='text' id='selisih_$num' name='selisih[]' class='form-control' style='width:90%;font-size:14px'></td>
                        <td align='center'>
                            <input type='text' id='keterangan_$num' name='keterangan[]' class='form-control' style='width:90%;font-size:12px' ></td>
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
