<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("(SELECT * FROM tx_barangmasuk where id_brgmasuk='$_GET[id]') a","*") as $val2){}

?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <a href='apps/barangmasuk/cetak_pdf.php?id=<?php echo $_GET[id];?>' class='label label-success' style='cursor:pointer;float:right' title='PDF' target='_blank'><i class='ft-file' aria-hidden='true' style='font-size:16px;'></i></a>
                <th>No Transaksi</th>
                <th><?=$val2[no_brgmasuk]?></th>
                <th>Supplier</th>
                <th><?=$val2[nama_supp]?></th>
            </tr>
            <tr>
                <th>No SPJ</th>
                <th><?=$val2[no_sj]?></th>
                <th>Tanggal</th>
                <th><?=date("d/m/Y",strtotime($val2[date_brgmasuk]))?></th>
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
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
foreach($db->select("(SELECT a.*, b.nama_barang, b.kode_barang, c.nama_satuan FROM `tx_barangmasukdtl` a join m_barang b ON a.id_barang=b.id_barang
                         join m_satuan c on c.id_satuan=b.id_satuan
                         where id_brgmasuk='$_GET[id]') a","*") as $val){
	
                    ?>
                        <tr>
                                <td><?=$no;?></td>
                                <td><?=$val[kode_barang];?></td>
                                <td><?=$val[nama_barang];?></td>
                                
                                <td><?=$val[qty];?></td>
                                <td><?=$val[nama_satuan];?></td>
                                <td align="right"><?=number_format($val[harga]);?></td>
                                <td align='right'><?=number_format($val[harga]*$val[qty]);?></td>
                            </tr>
<?php
$no++;
$ttl+=$val[harga]*$val[qty];
}
                    ?>
                        <tr>
                                
                                <td colspan='6' align="right">Total</td>
                                <td align='right'><?=number_format($ttl);?></td>
                            </tr>                   
                    </table>
                </td>
            </tr>
   
        </tbody>
    </table>