<?php 
    if($_GET['reload'] == 1) {
        session_start();
        require_once "../../webclass.php";
        $db = new kelas();
    }

    foreach($db->select("tx_barangmasuk","*","status_brgmasuk = 1") as $head);
?>
<table class="table table-striped table-bordered">
    <tr>
        <th>Supplier</th>
        <th>: <?=$head['nama_supp']?></th>
        <th>Surat Jalan</th>
        <th>: <?=$head['no_sj']?></th>
    </tr>
</table>
<div class="table-responsive">
    <table class="table table-striped table-bordered server-side" id="barangtable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Dep</th>
                <th>Sub</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
        </thead>
        <tbody>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>                    
    </table>
</div>