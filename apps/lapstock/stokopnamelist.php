<!-- Row --> 
<div class="row">
    <div class="col-12">
        <div class="card">
                <div class="card-body">   

                <form class="form-user" id="formku" method="post" enctype="multipart/form-data">
                	<table border="0" width="100%">
                		<tr>
                			<td>
                				<h3>Stok Opname</h3>
                			</td>
                			<td align="right">
                                 <a href="index.php?page=stokopname" class="btn btn-warning"> Back</a>         
                            </td>
                		</tr>
                	</table>
					
                    <hr>                                        
						<table class='table table-hover dt-responsive table-striped table-bordered' cellspacing='0' style="font-size: 12px;" width='100%'>
							  <thead>
								  <tr align="center">
									  <th width="5%">No</th> 
									  <th width="7%">Kode Barang</th>
									  <th width="15%">Nama Barang</th>
									  <th width="5%">Jenis</th>
									  <th width="7%">BatchNo / ED</th>
									  <th width="10%">Harga Beli</th>
									  <th width="7%">Persediaan Akhir <br>(System)</th>
									  <th width="10%">Persediaan Gudang <br>(Fisik)</th>
                                      <th width="7%">Selisih</th>
                                      <th>Ket</th>  
								  </tr>
							  </thead>   
							  <tbody style="font-size: 14px;">
                             
                               <?php
							   $num = 1;
							   $tglSkrng = date('2020-11-11');
							   $s = $Core->query("select *, CASE
                                                        WHEN b.jenismasuk = 1 THEN 'JKN' 
                                                        WHEN b.jenismasuk = 2 THEN 'DAU'
                                                        ELSE '' 
                                                        END AS jenis_masuk 
                                                        from
                                                        masterbarangfarmasi a 
                                                        JOIN txstockopname_dtl b ON a.id=b.idbarang 
                                                        WHERE idso='$_GET[id]'
                                                        order by a.id");

								while($rows = $s->fetch_object()){
									
								$tgl = $rows->tgldaftar;
								$tgl_ind = date('d-m-Y', strtotime($tgl)); 
								echo" <tr>
    									<td>$num</td>
    									 <td>$rows->kode</td>
    									 <td>$rows->nama_obat</td>
    									 <td>$rows->jenis_masuk
    									 	
    									 </td>
    									 <td>$rows->batchno / $rows->ed

    									 </td>
    									 <td align='right'>".number_format($rows->hargabeli)."
    									 </td>
    									 <td align='right'>".number_format($rows->qtyakhir)."
    								
    									 </td>
    									 <td align='right'>
    									 	".number_format($rows->qtyfisik)."
    									 	
    									 </td>
    									 <td align='right'>
    									 	".number_format($rows->selisih)."</td>
    									 <td align='center'>
    									 	$rows->keterangan_sto</td>
    									 ";
    							
								$num++;		
								 	
								}
							   ?>
		                       
							  </tbody>
						 </table>
				</form>
			    </div>
			</div>
     </div>
</div>
						 

                


