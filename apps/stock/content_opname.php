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
                <a href="index.php?x=stock&id=<?=$_GET[id]?>&jns=<?=$_GET[jns]?>" class="btn btn-warning btn-sm"> Back</a>
                <button id="addstokopname" type="button" class="btn btn-success btn-sm" onclick="simpanstokopname()">
                <i class='fa fa-save'></i>&nbsp; Simpan</button>
                <a href="index.php?x=stockopname&id=<?=$_GET[id]?>" class="btn btn-danger btn-sm"> Reset</a>
                <input type='hidden' id='idgudang' name='idgudang' value='<?=$_GET[id]?>'>
                <input type='hidden' id='jenisbrg' name='jenisbrg' value='<?=$_GET[jns]?>'>
                &emsp;
                <?php if($_GET['jns'] == 1){$jnsbrg = "Baru";} else {$jnsbrg = "Bekas/Repair";}
                foreach($db->select("m_gudang","*","id_gudang = $_GET[id]") as $gdg){ echo "<b>".$gdg['nama_gudang']."</b> - Barang ".$jnsbrg;} ?>
                <a href="index.php?x=viewstockopname&id=<?=$_GET[id]?>&jns=<?=$_GET[jns]?>" class="btn btn-info btn-sm" style="float:right">View Stock Opname</a>
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
                      <th width="15%">Nama Barang</th>
                      <th width="5%">Satuan</th>
                      <th width="5%">Min Stock</th>
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
    //            $s = $db->select("(select b.id_barang, nama_barang,IFNULL(b.min_stock,0) as min_stock,IFNULL(b.max_stock,0) as max_stock,COALESCE(masukmutasi-keluarmutasi,0) as stokakhir,
    // COALESCE(( COALESCE(masukmutasi-keluarmutasi,0) - min_stock ), 0 ) balance,b.kode_barang,c.nama_satuan from m_barang b join m_satuan c on b.id_satuan=c.id_satuan left join (select sum(masukmutasi) as masukmutasi, sum(keluarmutasi) as keluarmutasi,id_barang,id_gudang 
    //        from tx_mutasi where id_gudang = '$_GET[id]' GROUP BY id_barang) c on b.id_barang=c.id_barang )as asi","*","");
                $s = $db->query("select a.id_barang,kode_barang,nama_barang,min_stock,nama_satuan,harga, hargajual,stok as stokakhir,no_transmutasi from
                                (select a.*,
                                @running_total:=stok - abs(@running_total) AS cumulative_sum from
                                (select * from (select a.id_barang, b.no_transmutasi, a.idmutasli as id_mutasi, sum(stok) stok, a.harga, a.hargajual 
                                from (select id_barang, no_transmutasi,min(id_mutasi) as idmutasli,  
                                case when masukmutasi>0 then id_mutasi else id_refmutasi1 end as id_mutasi, 
                                sum(masukmutasi)-sum(keluarmutasi) as stok,harga,hargajual 
                                from tx_mutasi where jenisbrg='$_GET[jns]' and id_gudang = $_GET[id] group by id_mutasi order by id_mutasi DESC) a 
                                join tx_mutasi b on b.id_mutasi=a.idmutasli group by a.id_barang) a where stok>0) a 
                                JOIN (SELECT @running_total:=10, @s:=0) b ) a 
                                join m_barang b on a.id_barang=b.id_barang 
                                join m_satuan c on b.id_satuan=c.id_satuan
                    ");
                
                foreach($s as $p){

                //$tgl = $p->tgldaftar;
                $tgl_ind = date('d-m-Y', strtotime($tgl)); 
                echo" <tr>
                        <td>$num</td>
                         <td>$p[kode_barang]
                            <input type='hidden' id='idbarang_$num' name='idbarang[]' value='$p[id_barang]'>
                            <input type='hidden' id='kdbarang_$num' name='kdbarang[]' value='$p[kode_barang]'>
                            <input type='hidden' class='form-control'  style='width:90%;font-size:14px' id='hargabeli_$num' name='hargabeli[]' value='$p[harga]' readonly>
                            <input type='hidden' class='form-control'  style='width:90%;font-size:14px' id='brgmasuk_$num' name='brgmasuk[]' value='$p[no_transmutasi]' readonly>
                         </td>
                         <td>$p[nama_barang]</td>
                         <td>$p[nama_satuan]</td>
                         <td align='right'>$p[min_stock]</td>
                         
                         <td align='right'>$p[stokakhir]
                            <input type='hidden' id='qtytotalnow_$num' name='qtytotalnow[]' value='$p[stokakhir]'>
                         </td>
                         <td align='center'>
                            <input type='text' id='fisik_$num' name='fisik[]' class='form-control input-sm' style='width:90%;font-size:14px' onkeyup='selisihstok(this.value,$p[stokakhir],$num)' required>
                        </td>
                        <td align='center'>
                            <input type='text' id='selisih_$num' name='selisih[]' class='form-control input-sm' style='width:90%;font-size:14px' readonly></td>
                        <td align='center'>
                            <input type='text' id='keterangan_$num' name='keterangan[]' class='form-control input-sm' style='width:90%;font-size:12px' ></td>
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
<script type="text/javascript">
 function selisihstok(fisik,system,num){
    qtyselisih = (parseInt(fisik)-parseInt(system));
      $('#selisih_'+num).val(qtyselisih);
}
</script>