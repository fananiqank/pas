<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("(select * 
    from tx_barangkeluar a 
    JOIN m_gudang using(id_gudang)
    join m_site using(id_site) where id_brgkeluar='$_GET[id]') a","*") as $val2){}


?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
            	<a href='apps/barangkeluar/cetak_pdf.php?id=<?php echo $_GET[id];?>' class='label label-success' style='cursor:pointer;float:right' title='PDF' target='_blank'><i class='ft-file' aria-hidden='true' style='font-size:16px;'></i></a>
                <th>No Transaksi</th>
                <th><?=$val2[no_brgkeluar]?></th>
                <th>Tanggal</th>
                <th><?=date("d/m/Y",strtotime($val2[date_brgkeluar]))?></th>
            </tr>
            <tr>
                <th>Site</th>
                <th><?=$val2[nama_site]?></th>
                <th>Gudang</th>
                <th><?=$val2[nama_gudang]?></th>
            </tr>
            
        </thead>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Jenis</th>
                <th>Remark</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
foreach($db->select("(select kode_barang, nama_barang, qty, nama_satuan,case when a.jenisbrg = 1 then 'Baru' when a.jenisbrg = 2 then 'Repair/Bekas' else '-' end jenisbarang, case when a.status_pakai = '1' then 'Service' when a.status_pakai = '2' then 'Rusak' else '-' end statuspakai from 
                 tx_barangkeluardtl a
                 JOIN m_barang using(id_barang)
                 JOIN m_satuan using(id_satuan)
                 left join m_supplier using(supp_id)
                 where id_brgkeluar='$_GET[id]') a","*") as $val){

	
	
                    ?>
                        <tr>
                                <td><?=$no;?></td>
                                <td><?=$val[kode_barang];?></td>
                                <td><?=$val[nama_barang];?></td>
                                <td><?=$val[qty];?></td>
                                <td><?=$val[nama_satuan];?></td>
                                <td><?=$val[jenisbarang];?></td>
                                <td><?=$val[statuspakai];?></td>
                                <td><?=$val[supplier];?></td>
                            </tr>
<?php
$no++;
$ttl+=$val[harga]*$val[qty];
}
                    ?>
                        <tr>
                                
                                <!-- <td colspan='6' align="right">Total</td> -->
                                <!-- <td align='right'><?=number_format($ttl);?></td> -->
                            </tr>                   
                    </table>
                </td>
            </tr>
   
        </tbody>
    </table>