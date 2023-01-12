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
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Aksi</th>
              </tr>
        </thead>
        <tbody>
            <?php 
                $selbrgmas = $db->select("tx_barangmasukdtl a JOIN m_barang b ON a.id_barang=b.id_barang
                                          JOIN m_satuan c ON b.id_satuan=c.id_satuan","a.*,b.kode_barang,b.nama_barang,c.nama_satuan","status_brgmasukdtl = 0","id_brgmasukdtl DESC"); 
                foreach($selbrgmas as $brgmas) {
                $hargatotal = $brgmas['harga'] * $brgmas['qty']; 
            ?>
            <tr>
                <td><?=$brgmas['id_brgmasukdtl']?></td>
                <td><?=$brgmas['kode_barang']?></td>
                <td><?=$brgmas['nama_barang']?></td>
                <td><?=$brgmas['qty']?></td>
                <td><?=$brgmas['nama_satuan']?></td>
                <td align="right"><?=number_format($brgmas['harga'])?></td>
                <td align="right"><?=number_format($hargatotal)?></td>
                <td><a href="javascript:void(0)" style="font-size: 13px;" onClick="hapusmasukdtl(<?=$brgmas[id_brgmasukdtl]?>)"><i class="ft-delete danger"></i></td>
            </tr>
            <?php $totalharga += $hargatotal; } ?>
            <tr>
                <td colspan="6" align="right"><b>Grand Total</b></td>
                <td align="right"><b><?=number_format($totalharga)?></b>
                    <input type="hidden" id="harga_total" name="harga_total" value="<?=$totalharga?>">
                </td>
                <td>&nbsp;</td>
            </tr>
        </tbody>             
    </table>
</div>
   