<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("(SELECT @rownum:=@rownum+1 norut, a.*, d.driver_name, b.nama_site, sum(txangkut_tonase) ton, sum(txangkut_ritase) rit FROM `tx_ritase` a JOIN m_site b ON a.id_site=b.id_site JOIN tx_ritase_dtl c ON a.txangkut_id=c.txangkut_id JOIN m_driver d ON d.driver_id=a.driver_id JOIN (SELECT @rownum:=0) r where a.txangkut_id='$_GET[id]') a","*") as $val2){}


?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th><?=$val2[txangkut_tgl]?></th>
                <th>Shift</th>
                <th><?=$val2[txangkut_shift]?></th>
            </tr>
            <tr>
                <th>Driver</th>
                <th><?=$val2[driver_name]?></th>
                <th>No Lambung</th>
                <th><?=$val2[arm_nolambung]?></th>
            </tr>
            <tr>
                <th>No</th>
                <th colspan="2">Rute</th>
                <th>Tonase</th>

            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
foreach($db->select("(SELECT @rownum:=@rownum+1 norut, a.*, c.tujuan_name, d.rom_name FROM `tx_ritase_dtl` a JOIN m_rutejarak b ON a.rutejarak_id=b.rutejarak_id JOIN m_tujuan c ON c.tujuan_id=b.tujuan_id JOIN m_runofmine d ON d.rom_id=b.rom_id JOIN (SELECT @rownum:=0) r where txangkut_id='$_GET[id]') a","*") as $val){

	
	echo "<tr>
                <td scope=\"row\">$no</td>
                <td colspan=\"2\">$val[rom_name] - $val[tujuan_name]</td>
                <td>$val[txangkut_tonase] km</td>
            </tr>";
    $no++;
}
?>      <tr>
                <th></th>
                <th colspan="2">Total</th>
                <th><?=$val2[ton]?></th>

            </tr>
				
        </tbody>
    </table>