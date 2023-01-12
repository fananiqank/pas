<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();


// foreach($db->select("`trx_basicpremi_driver` where (('$_POST[txangkut_tgl1]' between txbaspre_tgl1 and txbaspre_tgl2) OR ('$_POST[txangkut_tgl2]' between txbaspre_tgl1 and txbaspre_tgl2)) and id_site='$_POST[id_site]'","count(*) c") as $no){}

    // echo "`trx_basicpremi_driver` where ('$_POST[txangkut_tgl1]' between txbaspre_tgl1 and txbaspre_tgl2) OR ('$_POST[txangkut_tgl2]' between txbaspre_tgl1 and txbaspre_tgl2) and a.id_site='$_POST[id_site]'";
foreach($db->select("m_deduction","id_ddc,nama_ddc","id_ddc = '$_POST[id_ddc]'") as $ddc){}
if($no[c]){
    echo "Terdapat Periode Yang Pernah di posting";
} else {
?>
<link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
<div class="table-responsive">
<div class="table-responsive">
    <table class="table table-striped table-bordered server-side">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Driver</th>
                <th>Armada</th>
                <th><?=$ddc['nama_ddc']?></th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
$cust=explode("_",$_POST[cust_id]);
$p=0;
$tbl="m_driver a left JOIN m_armada b ON a.driver_armada=b.arm_id where id_site='$_POST[id_site]'";
// echo "$tbl";
foreach($db->select("$tbl","a.*, arm_nolambung") as $val){

	if($val[txangkut_nolambung]=='X'){
        $tx="";
    } else {
        $tx=$val[txangkut_nolambung];
    }
	echo "<tr>
                <td scope=\"row\">$no</td>
                <td>$val[driver_name]
                <input type=\"hidden\" name=\"driver_id[]\" value=\"$val[driver_id]\"></td>
                <td>";
    ?> 
                <select class="select2" name="armada[]" id="armada_<?=$no?>" >
                    <?php include "tampilarmada.php"; ?>
                </select>
    <?php 
         echo "</td>
                <td>
                    <input type=\"input\" name=\"ddcjumlah[]\" class=\"form-control\" value=\"0\">
                    
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
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script type="text/javascript">
    $('.server-side').DataTable( {
        "processing": true,
        "serverSide": false,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "paging" :false
    });

    $('#tambah3').click(function () {
        $('.server-side').DataTable().search( this.value ).draw();
            $('#tambah2').show();
            $('#tambah3').hide();
    } );
</script>