<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();


foreach($db->select("`trx_basicpremi_driver` where (('$_POST[txangkut_tgl1]' between txbaspre_tgl1 and txbaspre_tgl2) OR ('$_POST[txangkut_tgl2]' between txbaspre_tgl1 and txbaspre_tgl2)) and id_site='$_POST[id_site]'","count(*) c") as $no){}

    // echo "`trx_basicpremi_driver` where ('$_POST[txangkut_tgl1]' between txbaspre_tgl1 and txbaspre_tgl2) OR ('$_POST[txangkut_tgl2]' between txbaspre_tgl1 and txbaspre_tgl2) and a.id_site='$_POST[id_site]'";

if($no[c]){
    echo "Terdapat Periode Yang Pernah di posting";
} else {
?>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Driver</th>
                <th>Armada</th>
                <th>Kehadiran (Hari)</th>
                <th>Perawatan Unit</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
$cust=explode("_",$_POST[cust_id]);
$p=0;
$tbl="m_driver a JOIN m_armada b ON a.driver_armada=b.arm_id where id_site='$_POST[id_site]'";
// echo "$tbl";
foreach($db->select("$tbl","a.*, arm_nolambung") as $val){

	if($val[txangkut_nolambung]=='X'){
        $tx="";
    } else {
        $tx=$val[txangkut_nolambung];
    }
	echo "<tr>
                <td scope=\"row\">$no</td>
                <td>$val[driver_name]</td>
                <td>$val[arm_nolambung]</td>
                <td>
                    <input type=\"input\" name=\"harimasuk[]\" class=\"form-control\">
                    <input type=\"hidden\" name=\"driver_id[]\" value=\"$val[driver_id]\">
                </td>
                <td>
                    <input type=\"input\" name=\"rawatunit[]\" class=\"form-control\">
                    
                </td>
                
                
            </tr>";
    $no++;
    
}
?>          
            
            
        </tbody>
    </table>
<?php //} 
}
?>