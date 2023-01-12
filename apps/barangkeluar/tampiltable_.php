<?php 
    if($_GET['reload'] == 1) {
        session_start();
        require_once "../../webclass.php";
        $db = new kelas();
    }
   
?>


<div class="table-responsive" style="height: 210px;">
    <table class="table table-striped table-bordered server-side " id="barangtable" style="font-size: 11px;">
        <thead class="sthead">
            <tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Qty</th>
                <th>Sat</th>
                <th>Jenis</th>
                <th>Aksi</th>
              </tr>
        </thead>
        <tbody>
            <?php 
                $selbrgmas = $db->select("tx_barangkeluardtl a JOIN m_barang b ON a.id_barang=b.id_barang
                                          JOIN m_satuan c ON b.id_satuan=c.id_satuan","a.*,b.kode_barang,b.nama_barang,c.nama_satuan,CASE WHEN jenisbrg = 1 THEN 'Baru' ELSE 'Bekas' END as jenisbarang","status_brgkeluardtl = 0","id_brgkeluardtl DESC"); 
                foreach($selbrgmas as $brgmas) {
            ?>
            <tr>
                <td><?=$brgmas['id_brgkeluardtl']?></td>
                <td><?=$brgmas['kode_barang']?></td>
                <td><?=$brgmas['nama_barang']?></td>
                <td><?=$brgmas['qty']?></td>
                <td><?=$brgmas['nama_satuan']?></td>
                <td><?=$brgmas['jenisbarang']?></td>
                <td><a href="javascript:void(0)" style="font-size: 13px;" onClick="hapuskeluardtl(<?=$brgmas[id_brgkeluardtl]?>)"><i class="ft-delete danger"></i></td>
            </tr>
            <?php } ?>
            
        </tbody>             
    </table>
</div>
   