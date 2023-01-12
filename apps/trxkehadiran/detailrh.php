<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("trx_basicpremi_driver a where a.txbaspre_id='$_GET[id]'","*") as $val2){}


?>

<div class="table-responsive">
    <table class="table">
<?php 
$tg=explode("_",$_GET[id]);
if($tg[1] == 1){
?>
        <thead>
            <!-- <tr>
                <th>Tgl Inv</th>
                <th><?=date("d/m/Y",strtotime($val2[txbaspre_tglinput]))?></th>
                <th></th>
                <th></th>
                <th>No Voucher</th>
                <th><?=$val2[txbaspre_no]?></th>
            </tr> -->           
            <tr>
                <th>No</th>
                <th>Driver</th>
                <th>Armada</th>
                <th>Hadir</th>
                <th>Cuti</th>
                <th>Sakit</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
$p=0; 

// foreach($db->select("(select @rownum:=@rownum+1 norut, b.hadirdriver_id, hadirdriver_bulan,hadirdriver_tahun,a.driver_id, c.driver_name, hadirdriver_type, sum(hadirdriver_jumlah) hadirdriver_jumlah from txkehadiran a JOIN (SELECT max(hadirdriver_id) hadirdriver_id FROM txkehadiran group by hadirdriver_bulan,hadirdriver_tahun,driver_id, hadirdriver_type) b 
// ON a.hadirdriver_id=b.hadirdriver_id 
// JOIN m_driver c ON c.driver_id=a.driver_id
// JOIN (SELECT @rownum:=0) r where hadirdriver_bulan='$tg[0]' and hadirdriver_tahun='$tg[1]' and hadirdriver_type='$tg[2]'
// group by hadirdriver_bulan,hadirdriver_tahun, a.driver_id, hadirdriver_type) a","*") as $val){

    foreach($db->select("(select @rownum:=@rownum+1 norut, a.hadirdriver_id, hadirdriver_bulan,hadirdriver_tahun,a.driver_id, c.driver_name, hadirdriver_type, sum(hadirdriver_jumlah) hadirdriver_jumlah,case when hadirdriver_jenis = 1 and hadirdriver_type = 1 then 'Hadir' when hadirdriver_jenis = 2 and hadirdriver_type = 1 then 'Cuti' when hadirdriver_jenis = 3 and hadirdriver_type = 1 then 'Sakit' end jenis,hadirdriver_jenis,concat((case when d.arm_type_armada = 1 then 'DT' else 'SDT' end),'-',SUBSTR(d.arm_norangka,-5),'-',d.arm_nolambung) as armada,hadirdriver_remark from txkehadiran a 
    JOIN m_driver c ON c.driver_id=a.driver_id
    left join m_armada d on a.arm_id=d.arm_id
    JOIN (SELECT @rownum:=0) r where DATE(hadirdriver_tgl)='$tg[0]' and hadirdriver_type='$tg[1]' and shift = '$tg[2]'

    group by DATE(hadirdriver_tgl),a.driver_id, hadirdriver_type) a","*") as $val){
?>

	<tr>
            <td><?=$no?></td>
            <td><?=$val[driver_name]?></td>
            <td><?=$val[armada]?></td>
            <td align="left"><?php if($val[hadirdriver_jenis] == '1') {echo "<b><i class='ft-check' aria-hidden='true' style='color:green'></i></b>";}else{echo "<span style='color:red;'><b>x</b></span>";}?></td>
            <td align="left"><?php if($val[hadirdriver_jenis] == '2') {echo "<b><i class='ft-check' aria-hidden='true' style='color:green'></i></b>";}else{echo "<span style='color:red;'><b>x</b></span>";}?></td>
            <td align="left"><?php if($val[hadirdriver_jenis] == '3') {echo "<b><i class='ft-check' aria-hidden='true' style='color:green'></i></b>";}else{echo "<span style='color:red;'><b>x</b></span>";}?></td>
            <td align="left"><?=$val[hadirdriver_remark]?></td>
            
    </tr>
    <?php
    $no++;

    }
} else {
?>
     <thead>
            <tr>
                <th>No</th>
                <th>Driver</th>
                <th>Armada</th>
                <th>Perawatan</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
$p=0; 

    foreach($db->select("(select @rownum:=@rownum+1 norut, a.hadirdriver_id, hadirdriver_bulan,hadirdriver_tahun,a.driver_id, c.driver_name, hadirdriver_type, sum(hadirdriver_jumlah) hadirdriver_jumlah,case when hadirdriver_jenis = 1 and hadirdriver_type = 1 then 'Hadir' when hadirdriver_jenis = 2 and hadirdriver_type = 1 then 'Cuti' when hadirdriver_jenis = 3 and hadirdriver_type = 1 then 'Sakit' end jenis,hadirdriver_jenis,concat((case when d.arm_type_armada = 1 then 'DT' else 'SDT' end),'-',SUBSTR(d.arm_norangka,-5),'-',d.arm_nolambung) as armada from txkehadiran a 
    JOIN m_driver c ON c.driver_id=a.driver_id
    left join m_armada d on a.arm_id=d.arm_id
    JOIN (SELECT @rownum:=0) r where DATE(hadirdriver_tgl)='$tg[0]' and hadirdriver_type='$tg[1]'
    group by DATE(hadirdriver_tgl),a.driver_id, hadirdriver_type) a","*") as $val){
?>

    <tr>
            <td><?=$no?></td>
            <td><?=$val[driver_name]?></td>
            <td><?=$val[armada]?></td>
            <td align="left"><?php if($val[hadirdriver_jumlah] == '1') {echo "<b><i class='ft-check' aria-hidden='true' style='color:green'></i></b>";}else{echo "<span style='color:red;'><b>x</b></span>";}?></td>
            
    </tr>
    <?php
    $no++;

    }
}
?>          	
        </tbody>
    </table>