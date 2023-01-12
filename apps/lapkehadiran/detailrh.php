<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("m_driver","*","driver_id = '$_GET[id]'") as $val2){}


?>

<div class="table-responsive pre-scrollable">
    <input style="height:26px; line-height: 0;" type="button" id="donexel" class="btn btn-info" value="Excel" onclick="tableToExcel('detailkehadiran')"></button>
    <table class="table" id="detailkehadiran">
        <thead>
            <tr>
                <th colspan="2">Nama Driver</th>
                <th >: <?=$val2['driver_name']?></th>
            </tr>
            <tr>
                <th colspan="2">Periode</th>
                <th >: <?=$_GET['tgl1']?> - <?=$_GET['tgl2']?></th>
            </tr>
            <tr>
                <th colspan="2">Shift</th>
                <th >: <?=$_GET['sf']?></th>
            </tr>
            <tr><th colspan="3">&nbsp;</th></tr>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Armada</th>
                <th>Kehadiran</th>
                <!-- <th>Perawatan</th> -->
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$begin = new DateTime($_GET['tgl1']);
$ends = date('Y-m-d',strtotime('+1 days', strtotime($_GET['tgl2'])));
$end = new DateTime($ends);

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$no= 1;
$na=1;
foreach ($period as $dt) {
    if($_GET[sf] > 0){
        $shf = "and shift = '$_GET[sf]'";
    } else {
        $shf = "";
    }
    $cc = 0;
    $ce = 0;
    $cp = 0; 
    $cg = 0;
    $chadir = 0;
    $ccuti = 0;
    $cijin = 0;
    echo "<tr>
                <td scope=\"row\">$no</td>
                <td scope=\"row\">".$dt->format("Y-m-d")."</td>
                <td scope=\"row\">";
               
                    foreach($db->select("(select concat((case when arm_type_armada = 1 then 'DT' else 'SDT' end),'-',SUBSTR(arm_norangka,-5),'-',arm_nolambung) armadax from txkehadiran a left join m_armada b on a.arm_id=b.arm_id where a.driver_id = '$_GET[id]' and a.hadirdriver_type = 1 $shf and date(a.hadirdriver_tgl) = '".$dt->format("Y-m-d")."') a","*") as $vale){
                        echo $vale['armadax'];
                        $ce = 1;
                    }  
                    if($ce == 0){
                        echo "<font style='color:red'><b>-</b></font>";
                    }
                echo "</td>
                <td>";
                
                foreach($db->select("(select * from txkehadiran where driver_id = '$_GET[id]' and hadirdriver_type = 1 $shf and date(hadirdriver_tgl) = '".$dt->format("Y-m-d")."') a","*") as $valu){
                    if($valu['hadirdriver_jenis'] == 1){
                        echo "<font style='color:green'><b>Hadir</b></font>";
                        $chadir=1;
                    } else if($valu['hadirdriver_jenis'] == 2){
                        echo "<font style='color:blue'><b>Cuti</b></font>";
                        $ccuti=1;
                    } else if($valu['hadirdriver_jenis'] == 3){
                        echo "<font style='color:orange'><b>Sakit</b></font>";
                        $cijin=1;
                    }
                    $cc = 1;
                } 

                if($cc == 0){
                    echo "<font style='color:red'><b>Alpha</b></font>";
                }

                echo "</td>
                ";
                
                // foreach($db->select("(select * from txkehadiran where driver_id = '$_GET[id]' and hadirdriver_type = 2 $shf and date(hadirdriver_tgl) = '".$dt->format("Y-m-d")."') a","*") as $vala){
                //     if($vala['hadirdriver_jumlah'] == 1){
                //         echo "<b><i class='ft-check' aria-hidden='true' style='color:green'></i></b>";
                //     }
                //     $cg = 1;
                // } 

                // if($cg == 0){
                //     echo "<font style='color:red'><b>-</b></font>";
                // }
          echo "
                <td>";
                foreach($db->select("(select hadirdriver_remark from txkehadiran where driver_id = '$_GET[id]' and hadirdriver_type = 1 $shf and date(hadirdriver_tgl) = '".$dt->format("Y-m-d")."') a","*") as $valo){
                    if($valo['hadirdriver_remark'] != ''){
                        echo $valo['hadirdriver_remark'];
                    }
                    $cp = 1;
                } 

                if($cp == 0){
                    echo "<font style='color:red'><b>-</b></font>";
                }
          echo "</td>
          </tr>";
$no++;
$jumhari += $na;
$hadir += $chadir;
$cuti += $ccuti;
$ijin += $cijin;
$allhadir += $cc;
}

?>      
        <tr>
            <td colspan="5" align="center">Resume</td>
            
        </tr>
        <tr>
            <td colspan="2">Total Hari</td>
            <td><?=$jumhari?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">Hadir</td>
            <td><?=$hadir?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">Ijin</td>
            <td><?=$ijin?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">Cuti</td>
            <td><?=$cuti?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">Alpha</td>
            <td><?=$jumhari-$allhadir?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        </tbody>
    </table>
    
<script type="text/javascript">
    var tableToExcel = (function() {
        
    var uri = 'data:application/vnd.ms-excel;base64,';
    var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
        var bases = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
        var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) };
        return function(table, name) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + bases(format(template, ctx))
        }
        
    })()
</script>