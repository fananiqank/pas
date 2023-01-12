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
                				<button id="addstokopname" type="button" class="btn btn-success" onclick="simpanstokopname()">
                                <i class='fa fa-save'></i>&nbsp; Simpan</button>
								<a href="javascript:void(0)" class="btn btn-danger" onclick="reset()"> Reset</a>
							</td>
                		</tr>
                	</table>
					
                    <hr>                                        
						<table class='table table-hover dt-responsive table-striped table-bordered' cellspacing='0' style="font-size: 12px;" width='100%'>
							  <thead>
								  <tr align="center">
									  <th width="5%">No</th> 
									  <th width="7%">Kode Barang</th>
									  <th width="10%">Nama Barang</th>
									  <th width="5%">Jenis</th>
									  <th width="10%">BatchNo</th>
									  <th width="10%">ExpDate</th>
									  <th width="10%">Harga Beli</th>
									  <th width="7%">Persediaan Akhir <br>(System)</th>
									  <th width="10%">Persediaan Gudang <br>(Fisik)</th>
                                      <th width="8%">Selisih</th>
                                      <th>Ket</th>  
								  </tr>
							  </thead>   
							  <tbody style="font-size: 14px;">
                             
                               <?php
							   $num = 1;
							   $tglSkrng = date('2020-11-11');
							   $s = $Core->query("select *, CASE
													WHEN jenisbarang = 1 THEN
														'JKN' ELSE 'DAU' 
													END AS jenis_masuk,
													ifnull(jenisbarang,'0') as jenisbarangx from
												masterbarangfarmasi
												a LEFT JOIN (select a.idbarang, jenisbarang, idgudang, (sum(masukmutasi)-sum(keluarmutasi)) qtytotalnow, a.batchno, b.hargabeli, a.expdate,a.norefmutasi1 from txmutasibarang a LEFT JOIN txbarangmasukdtl b ON a.norefmutasi1=b.nomasuk
												where idgudang='$_SESSION[poli]'
													group by idbarang, idgudang, jenisbarang, norefmutasi1) b ON a.id=b.idbarang having qtytotalnow>0
				 								");

								while($rows = $s->fetch_object()){

								if ($rows->qtytotalnow == '') {
									$qtytotalnowoke = 0;
								} else {
									$qtytotalnowoke = $rows->qtytotalnow;
								}

								if ($rows->batchno != '') {
									$batchnooke = $rows->batchno;
								} else {
									$batchnooke = "";
								}

								if ($rows->expdate != '') {
									$expdateoke = $rows->expdate;
								} else {
									$expdateoke = "";
								}

								$tgl = $rows->tgldaftar;
								$tgl_ind = date('d-m-Y', strtotime($tgl)); 
								echo" <tr>
    									<td>$num</td>
    									 <td>$rows->kode
    									 	<input type='hidden' id='idbarang_$num' name='idbarang[]' value='$rows->id'>
    									 	<input type='hidden' id='kdbarang_$num' name='kdbarang[]' value='$rows->kode'>
    									 	<input type='hidden' id='brgmasuk_$num' name='brgmasuk[]' value='$rows->norefmutasi1'>
    									 </td>
    									 <td>$rows->nama_obat</td>
    									 <td>
    									 	<select id='jenismasuk_$num' name='jenismasuk[]' class='select2 form-control custom-select' style='width: 100%; height:36px;' readonly>		";
										  	if($rows->jenisbarangx == '0'){	
										  	echo"	<option value='1' >JKN</option>
										  			<option value='2'>DAU</option>";
										  	} else if($rows->jenisbarangx==1){
										  		echo"	<option value='1' >JKN</option>
										  			";
										  	} else if($rows->jenisbarangx)
										  	{
										  		echo"<option value='2'>DAU</option>";
										  	}
									echo "	</select>
    									 
    									 </td>
    									 <td>
    									 	<input type='text' class='form-control'  style='width:90%;font-size:14px' id='batchno_$num' name='batchno[]' value='$batchnooke' readonly >
    									 </td>
    									 <td>
    									 	<input type='date' class='form-control' id='ed_$num' name='ed[]' value='$expdateoke' readonly >
    									 </td>
    									 <td>
    									 	<input type='text' class='form-control'  style='width:90%;font-size:14px' id='hargabeli_$num' name='hargabeli[]' value='$rows->hargabeli' readonly>
    									 </td>
    									 <td align='right'>$qtytotalnowoke
    									 	<input type='hidden' id='qtytotalnow_$num' name='qtytotalnow[]' value='$qtytotalnowoke'>
    									 </td>
    									 <td align='center'>
    									 	<input type='text' id='fisik_$num' name='fisik[]' class='form-control' style='width:90%;font-size:14px' onkeyup='selisihstok(this.value,$qtytotalnowoke,$num)' >
    									 	
    									 </td>
    									 <td align='center'>
    									 	<input type='text' id='selisih_$num' name='selisih[]' class='form-control' style='width:90%;font-size:14px'></td>
    									 <td align='center'>
    									 	<input type='text' id='keterangan_$num' name='keterangan[]' class='form-control' style='width:90%;font-size:12px' ></td>
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
						 

                


