<?php 
require_once "../../webclass.php";

$db = new kelas();

$ID = 1;
$no =1;
    echo "<table border=1>
    <tr>
    	<td>NO LAMBUNG</td>
    	<td>RITASE</td>
    	<td>TONASE</td>
    </tr>";
foreach($db->select("(select *, @rownum:=@rownum+1 norut from tx_invoice_dtl a JOIN (SELECT @rownum:=0) b where inv_id='$ID') a","*") as $val){

	$my_string = $val[invdtl_ritdtl];    

    // passing "," as the delimiter

    $my_array1 = explode(",", $my_string);

    // print the array

    echo "The converted Sarray is: <br>";

    //print_r($my_array1); // red, green, blue 


    foreach ($my_array1 as $key => $value) {
    	//echo $value."<br>";

    	foreach($db->select("(select * from tx_ritase_dtl where trxangkutdtl_id = '$value') a","*") as $value){
    		// echo $value['trxangkutdtl_id']." - ".$value['txangkut_tonase']." - ".$value['txangkut_jarak']." - ".$value['txangkut_nolambung']."<br>";
    		echo "<tr>
				    	<td>".$value['txangkut_nolambung']."</td>
				    	<td>".$value['txangkut_ritase']."</td>
				    	<td>".$value['txangkut_tonase']."</td>
				  </tr>";
    	}

    		
    		
    }
    echo "</table>";

$no++;
}
?>