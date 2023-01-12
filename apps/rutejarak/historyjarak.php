<?php 
session_start();
require_once "../../webclass.php";
$db = new kelas();

foreach($db->select("m_rutejarak","*","rutejarak_id='$_GET[id]'") as $val2){}
?>


<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Jarak Saat ini</th>
                <th><?=$val2[rutejarak_jarak]?> km</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Tgl</th>
                <th>Jarak</th>
            </tr>
        </thead>
        <tbody>
           
</div>
<?php
$no=1;
foreach($db->select("m_hisrutejarak","*","rutejarak_id='$_GET[id]' order by hrutejarak_input desc") as $val){
	
	echo "<tr>
                <th scope=\"row\">$no</th>
                <td>$val[hrutejarak_tgl]</td>
                <td>$val[rutejarak_jarak] km</td>
            </tr>";
    $no++;
}
?> 
				
        </tbody>
    </table>