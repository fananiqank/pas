<?php
$b = date('m');
?>
<div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
					<form method="post" action="">
							                          
                              <div class="form-group row">
                              	<label class="control-label col-md-1" for="date01">Tgl</label>
							  	<div class="col-md-2">
							  	
								  <input type="date"  value="<?php if($_POST[tgl1]){echo date('Y-m-d',strtotime($_POST[tgl1]));} else {echo date('Y-m-d');}?>" class="form-control" id="tgl1" name="tgl1" required>
								</div>
							  
								<label class="control-label col-md-1" for="date01">Jenis</label>
								<div class="col-md-1">
								  <select id="" name="jenismasuk" class="select2 form-control custom-select" style="width: 100%; height:36px;">								  	
								  		<option value="A" <?php if($_POST[jenismasuk] == 'A'){echo 'selected';} ?>>All</option>
								  		<option value="1" <?php if($_POST[jenismasuk] == '1'){echo 'selected';} ?>>JKN</option>
								  		<option value="2" <?php if($_POST[jenismasuk] == '2'){echo 'selected';} ?>>DAU</option>
								  </select>
								</div>
                              <div class="form-actions">
								<button name="cari" type="submit" class="btn btn-primary">Cari</button>
								<button class="btn">Batal</button>
							  </div>
							  </div>
                              <br><hr>
                              <?php
                             
                              ?>

<?php
if(isset($_POST['cari']))
{
				$bln = $_POST['bln'];
				$thn = $_POST['thn'];


				function bulan($bulan)
				{
				Switch ($bulan){
				    case "01" : $bulan="Januari";
				        Break;
				    case "02" : $bulan="Februari";
				        Break;
				    case "03" : $bulan="Maret";
				        Break;
				    case "04" : $bulan="April";
				        Break;
				    case "05" : $bulan="Mei";
				        Break;
				    case "06" : $bulan="Juni";
				        Break;
				    case "07" : $bulan="Juli";
				        Break;
				    case "08" : $bulan="Agustus";
				        Break;
				    case "09" : $bulan="September";
				        Break;
				    case "10" : $bulan="Oktober";
				        Break;
				    case "11" : $bulan="November";
				        Break;
				    case "12" : $bulan="Desember";
				        Break;
				    }
				return $bulan;
				}
    			
    			if ($_POST['jenismasuk'] == ''){
    				$jenismasuk = '';
    			} else if ($_POST['jenismasuk'] == 'A'){
    				$jenismasuk = '';
    			} else {
    				$jenismasuk = "and jenismasuk='$_POST[jenismasuk]'";
    			}	

	 echo"<h2><center><b> Laporan Stock Opname <br>Periode $_POST[tgl] ". bulan($bln) .""; echo" $thn</b></center></h2> <p>"; ?>
						<!-- <div class="btn-group">
				          <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				            Action
				          </button>
				          <div class="dropdown-menu">
				            <a class="dropdown-item" href="?page=detail-kas-perbulan&bln=<?php echo $bln;?>&thn=<?php echo $thn; ?>">Detail Transaksi</a>
				            <a class="dropdown-item" href="plugin/ex_kasberjalan_bulanan.php?bln=$bln&thn=$thn">Export Excel</a>
				            <div class="dropdown-divider"></div>
				            <a class="dropdown-item" href="#">Print</a>
				          </div>
				        </div> -->
					<table id='tabelOS' class='display nowrap table table-hover dt-responsive table-striped table-bordered' cellspacing='0' width='100%' style="font-size: 12px;">
							  <thead>
								  <tr>
									  <th width="5%">No</th> 
									  <th width="7%">Kode Barang</th>
									  <th width="15%">Nama Barang</th>
									  <th width="5%">Jenis</th>
									  <th width="7%">BatchNo</th>
									  <th width="7%">Harga Beli</th>
									  <th width="10%" align="center">Persediaan Akhir <br>(System)</th>
									  <th width="10%" align="center">Persediaan Gudang <br>(Fisik)</th>
                                      <th width="10%">Selisih</th>
                                      <th width="15%">Ket</th>
								  </tr>
							  </thead>   
							  <tbody style="font-size: 14px;">
				
                        <?php
							   $num = 1;
							
							   $s = $Core->query("select 
													 a.kode,
													 a.nama_obat,
													 b.idbarang,
													 b.hargabeli,
													 b.batchno,
													 b.ed,
													 b.qtyakhir,
													 b.qtyfisik,
													 b.selisih,
													 c.noso,
													 CASE
														WHEN b.jenismasuk = 1 THEN 'JKN'
														WHEN b.jenismasuk = 2 THEN 'DAU'
														ELSE '' 
													 END AS jenis_masuk 
												  from masterbarangfarmasi a
											  		   JOIN txstockopname_dtl b ON a.id = b.idbarang 
													   JOIN txstockopname c ON c.id_sto = b.idso
												  WHERE DATE(b.created_date_sto) = '$_POST[tgl1]' $jenismasuk
												");

												
								while($row = $s->fetch_object()){
								
								echo" <tr>
									 <td>$num</td>
									 <td>$row->kode</td>
									 <td>$row->nama_obat</td>
									 <td align='center'>$row->jenis_masuk</td> 
									 <td>$row->batchno</td>
									 <td align='right'>".number_format($row->hargabeli)."</td>
									 <td align='right'>".number_format($row->qtyakhir)."</td>
									 <td align='right'>".number_format($row->qtyfisik)."</td>
									 <td align='right'>".number_format($row->selisih)."</td>
									 <td>$row->keterangan_sto</td>
									 </tr>";
								$num++;			
								}
					echo"
						  </tbody>
						 </table>";
}else 
			{echo"Belum Ada Pencarian";}
?>
											  
						 
					</div></div></div>
				</div><!--/span-->
</div>

<!-- <script src="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"></script>    
 <script src="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css"></script>
 -->
<script type="text/javascript">
	$(document).ready(function() {
    $('#tabelOS').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            //'copy', 'csv', 
            'excel', 'pdf', 'print'
        ]
    } );
} );
</script>