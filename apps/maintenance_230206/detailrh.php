<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("(SELECT @rownum:=@rownum+1 norut, b.arm_norangka,b.arm_nopol,b.arm_nolambung,concat(SUBSTR(b.arm_norangka,-5),'-',b.arm_nolambung) as norabung FROM m_armada b JOIN (SELECT @rownum:=0) r where b.arm_id='$_GET[id]') a","*") as $val2){}



?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No Rangka</th>
                <th><?=$val2[arm_norangka]?></th>
                <th>Nopol</th>
                <th><?=$val2[arm_nopol]?></th>
            </tr>
            <tr>
                <th>No Lambung</th>
                <th><?=$val2[arm_nolambung]?></th>
            </tr>
            <tr>
                <th colspan="4"><input id="myInputmodalbyprocess" type="text" placeholder="Search.." style="float: right;margin-right: 2%" ></th>
            </tr>
        </thead>
    </table>

    
    <hr>
</div>
     
<div class="pre-scrollable">
        
    <table class="table" id="modsumwip2">
        <thead>
            <tr>
                <th>No</th>
                <th>No Mtc</th>
                <th>Tgl</th>
                <th>Vendor</th>
            </tr>
        </thead>
        <tbody >
           

<?php
$no=1;
foreach($db->select("(SELECT @rownum:=@rownum+1 norut, a.*,DATE(a.tgl_mtc) as tglshow,b.arm_norangka,b.arm_nopol,b.arm_nolambung,supp_nama FROM tx_maintenance a JOIN m_armada b ON a.arm_id=b.arm_id JOIN (SELECT @rownum:=0) r JOIN m_supplier c on a.supp_mtc=c.supp_id where a.arm_id='$_GET[id]' order by id_mtc desc) a","*") as $val){

	// foreach($db->select("(select GROUP_CONCAT(nama_mekanik,',') as mekanik from tx_mekanik where id_mtc='$val[id_mtc]' group by id_mtc) a","*") as $val3){}
	
    //echo "<tr data-toggle='collapse' data-target='#$val[no_mtc]' style='cursor:pointer;background-color:#DCDCDC'>";
    echo "<tr>
                <td scope=\"row\">$no</td>
                <td>$val[no_mtc]</td>
                <td>$val[tglshow]</td>
                <td>$val[supp_nama]</td>
                <td><a href='apps/maintenance/cetakmtc.php?id=$_GET[id]&mtc=$val[no_mtc]' class='label label-primary' style='cursor:pointer;float:right' title='print' target='_blank'><i class='ft-printer' aria-hidden='true' style='font-size:16px;'></i></a>
                    <a href='apps/maintenance/pdfmtc.php?id=$_GET[id]&mtc=$val[no_mtc]' class='label label-success' style='cursor:pointer;float:right' title='PDF' target='_blank'><i class='ft-file' aria-hidden='true' style='font-size:16px;'></i></a>
                    <a href='index.php?x=maintenanceinput&id=$val[id_mtc]' class='label label-success' style='cursor:pointer;float:right' title='Edit / Tambah Mekanik'><i class='ft-edit' aria-hidden='true' style='font-size:16px;'></i></a>
                </td>
            </tr>
            ";       
 } ?>
</tbody>
</table>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#myInputmodalbyprocess").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#modsumwip2 tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
     });
</script>