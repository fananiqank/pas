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
<link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
<div class="table-responsive">
    <table class="table table-striped table-bordered server-side">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Driver</th>
                <th>Armada</th>
                <th align='center'>Kehadiran <span style="float: right;">
                    <!-- <input type="checkbox" id="allhadir" name="allhadir" onclick="checkhadir(this.value)" value="1">All</span> -->
                </th>
                <!-- <th align="center">Perawatan Unit <span style="float: right;"> -->
                    <!-- <input type="checkbox" id="allrawat" name="allrawat" onclick="checkrawat(this.value)" value="1">All</span> -->
                </th>
                <th align="center">Remark
                    <!-- <input type="checkbox" id="allrawat" name="allrawat" onclick="checkrawat(this.value)" value="1">All</span> -->
                </th>
            </tr>
        </thead>
        <tbody>
           
<?php
$no=1;
$cust=explode("_",$_POST[cust_id]);
$p=0;
// $tbl="m_driver a left join m_armada b ON a.driver_armada=b.arm_id where id_site='$_POST[id_site]' and a.status_driver = 1";
$tbl="m_driver a 
left join m_armada b ON a.driver_armada=b.arm_id 
left join (select * from txkehadiran where hadirdriver_tgl = '$_POST[tglhadir]' and id_site='$_POST[id_site]' and shift = '$_POST[bpshift]') c
on a.driver_id=c.driver_id
where a.id_site='$_POST[id_site]' and a.status_driver = 1
GROUP BY driver_id order by hadirdriver_jenis DESC";
//echo "$tbl";
// echo "select a.*,b.arm_nolambung,GROUP_CONCAT(hadirdriver_jumlah) hadirdriver_jumlah,GROUP_CONCAT(hadirdriver_type) hadirdriver_type,hadirdriver_jenis,hadirdriver_remark,c.arm_id
//      from $tbl";
foreach($db->select("$tbl","a.*,b.arm_nolambung,GROUP_CONCAT(hadirdriver_jumlah) hadirdriver_jumlah,GROUP_CONCAT(hadirdriver_type) hadirdriver_type,hadirdriver_jenis,hadirdriver_remark,c.arm_id") as $val){

    if($val[txangkut_nolambung]=='X'){
        $tx="";
    } else {
        $tx=$val[txangkut_nolambung];
    }
    // echo "<tr>
 //                <td scope=\"row\">$no</td>
 //                <td>$val[driver_name]</td>
 //                <td>$val[arm_nolambung]</td>
 //                <td align='center'>
 //                    <input type=\"checkbox\" name=\"harimasuk[]\" id=\"harimasuk_$no\" class=\"input-sm\" value=\"1\">
 //                    <input type=\"hidden\" name=\"driver_id[]\" value=\"$val[driver_id]\">
 //                </td>
 //                <td align='center'>
 //                    <input type=\"checkbox\" name=\"rawatunit[]\" id=\"rawatunit_$no\" class=\"input-sm\" value=\"1\">
                    
 //                </td>
                
                
 //            </tr>";
    echo "<tr>
                <td scope=\"row\">$no </td>
                <td>$val[driver_name]
                <input type=\"hidden\" name=\"driver_id[]\" value=\"$val[driver_id]\"></td>
                <td>";
    ?> 
                <select class="select2" name="armada[]" id="armada_<?=$no?>" >
                    <?php include "tampilarmada.php"; ?>
                </select>
    <?php 
                echo "</td>
                <td align='center'>";

                echo"<select name=\"harimasuk[]\" id=\"harimasuk_$no\" class=\"select2\">
                        <option value='0'>Alpha</option>
                        <option value='1'"; if($val['hadirdriver_jenis'] == 1){echo "selected";} echo ">Hadir</option>
                        <option value='2'"; if($val['hadirdriver_jenis'] == 2){echo "selected";} echo ">Cuti</option>
                        <option value='3'"; if($val['hadirdriver_jenis'] == 3){echo "selected";} echo ">Sakit</option>
                    </select>
                </td>";
    ?>
                
                <td align='center'>
                    <input type="text" name="remarkhadir_<?=$val[driver_id]?>" id="remarkhadir_<?=$no?>" class="input-sm" value="<?=$val[hadirdriver_remark]?>">
                    
                </td>
    <?php 
           echo "</tr>";
    $no++;
    $p++;
}
echo "<input type=\"hidden\" name=\"jmlhadir\" id=\"jmlhadir\" class=\"input-sm\" value=\"$p\">";
?>          
            
            
        </tbody>
    </table>
<?php //} 
}

// echo "<td align='center'>
//                     <input type=\"checkbox\" name=\"rawatunit[]\" id=\"rawatunit_$no\" class=\"input-sm\" value=\"1\">
                    
//                 </td>";
?>
</div>
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script type="text/javascript">
    function checkhadir(id){
        // Check
        //alert(id);
        var jm = $('#jmlhadir').val();
        for(i=1;i<=jm;i++){
            if(id.checked){
                $("#harimasuk_"+i).prop("checked", true);
            } else {
                $("#harimasuk_"+i).prop("checked", false);
            }
        }
    }

    function checkrawat(id){
        // Check
        var jm = $('#jmlhadir').val();
        for(i=1;i<=jm;i++){
            if(id.checked){
                $("#rawatunit_"+i).prop("checked", true);
            } else {
                $("#rawatunit_"+i).prop("checked", false);
            }
        }
    }

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