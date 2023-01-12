<?php
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");
$host="$_SERVER[HTTP_HOST]";
$head1="<font size='+1'>RSUD GAMBIRAN KOTA KEDIRI</font>";
 /*
 * File Name: class.crud.php
 * Date: August 17, 2015
 * Author: Alfian Syahroni
 * email : lowshint@gmail.com
 * referensi:
 * Facebook : https://www.facebook.com/sourcecodeonline
 * http://php.net/manual/en/class.pdo.php
 * http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Why_use_PDO.3F
 * 
 */
 
class kelas extends PDO{
    private $engine; 
    private $host; 
    private $database; 
    private $user; 
    private $pass;
	
    private $result; 	
      
    public function __construct()
	{ 
        $this->engine	= 'mysql'; 
        $this->host	  	= '103.139.193.245'; 
		//$this->host	  	= '192.168.100.99'; 
        $this->database = 'u1352283_pas'; 
		$this->user 	= 'dash'; 
        $this->pass 	= 'dash-123456789'; 
        $this->port 	= '3306';
		//$this->pass 	= 'sembarang'; 
        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host.";port=".$this->port; 
        parent::__construct( $dns, $this->user, $this->pass ); 
    }

	public function hostnya(){	
		return $this->host;
	}
	public function passnya(){
		return $this->pass;
	}
	public function dbnya(){
		return $this->database;
	}
	public function usernya(){	
		return $this->user;
	}

	public function portnya(){	
		return $this->port;
	}

	
	/*
    * Insert values into the table
    */
	public function insert($table,$rows=null)
	{
		$command = 'INSERT INTO '.$table;
		$row = null; $value=null;
		foreach ($rows as $key => $nilainya)
		{
		  $row	.=",".$key;
		  $value 	.=", :".$key;
		}
		
		$command .="(".substr($row,1).")";
		$command .="VALUES(".substr($value,1).")";
		//echo"$command<br><br>";
	   
		$stmt =  parent::prepare($command);
		$stmt->execute($rows);
		$rowcount = $stmt->rowCount();
		//$rowcount = parent::lastInsertId();
		return $rowcount;
	}
	
	public function insertNotExist($table,$rows=null,$where=null)
	{
		
		$command = 'INSERT INTO '.$table;
		$row = null; $value=null;
		foreach ($rows as $key => $nilainya)
		{
		  $row	.=",".$key;
		  $value 	.=", :".$key;
		}
		
		$command .="(".substr($row,1).")";
		$command .="VALUES(".substr($value,1).")";
		//echo"$command<br><br>";
	   
		$stmt =  parent::prepare($command);
		$stmt->execute($rows);
		$rowcount = $stmt->rowCount();
		//$rowcount = parent::lastInsertId();
		return $rowcount;
	}
	
	//Insert Data and Return Last Insert ID
	public function insertID($table,$rows=null)
	{
		$command = 'INSERT INTO '.$table;
		$row = null; $value=null;
		foreach ($rows as $key => $nilainya)
		{
		  $row	.=",".$key;
		  $value 	.=", :".$key;
		}
		
		$command .="(".substr($row,1).")";
		$command .="VALUES(".substr($value,1).")";
		 // echo"$command";
	   
		$stmt =  parent::prepare($command);
		$stmt->execute($rows);
		//$rowcount = $stmt->rowCount();
		$rowcount = parent::lastInsertId();
		return $rowcount;
	}
	
	/*
    * Delete records from the database.
    */
	public function delete($tabel,$where=null)
	{
		$command = 'DELETE FROM '.$tabel;
		
		$list = Array(); $parameter = null;
		foreach ($where as $key => $value) 
		{
		  $list[] = "$key = :$key";
		  $parameter .= ', ":'.$key.'":"'.$value.'"';
		} 
		$command .= ' WHERE '.implode(' AND ',$list);
	   	// echo"$command";
		$json = "{".substr($parameter,1)."}";
		$param = json_decode($json,true);
				
		$query = parent::prepare($command); 
		$query->execute($param);
		$rowcount = $query->rowCount();
        return $rowcount;
	}
   /*
    * Uddate Record
    */
	/*public function update($tabel, $fild = null ,$where = null)
	{
		 $update = 'UPDATE '.$tabel.' SET ';
		 $set=null; $value=null;
		 foreach($fild as $key => $values)
		 {
			 $set .= ', '.$key. ' = :'.$key;
			 $value .= ', ":'.$key.'":"'.$values.'"';
		 }
		 $update .= substr(trim($set),1);
		 $json = '{'.substr($value,1).'}';
		 $param = json_decode($json,true);
		 //echo $json."<br>";
		 if($where != null)
		 {
		    $update .= ' WHERE '.$where;
		 }
		 echo"$update<br><br>";
		 try
			{
			 $query = parent::prepare($update);
			 $query->execute($param);
			 //echo"test<br>";
			}
				catch(Exception $e)
			{
				echo($e->getMessage()); echo"test";
			}
		 $rowcount = $query->rowCount();
         return $rowcount;
    }*/
    public function update($tabel, $fild = null ,$where = null)
	{
		 $update = 'UPDATE '.$tabel.' SET ';
		 $set=null; $value=null;
		 foreach($fild as $key => $values)
		 {
			 $set .= ', '.$key. ' = :'.$key;
			 $value .= ', ":'.$key.'":"'.$values.'"';
			 //$value1[] = '":'.$key.'":"'.$values.'"';
		 }
		 $update .= substr(trim($set),1);
		 if($where != null)
		 {
		    $update .= ' WHERE '.$where;
		 }
		 //echo"$update<br>";
		 try
			{
			 $query = parent::prepare($update);
			 $query->execute($fild);
			 //echo"test<br>";
			}
				catch(Exception $e)
			{
				echo($e->getMessage()); 
				//echo"test";
			}
		 $rowcount = $query->rowCount();
         return $rowcount;
    }
   /*
    * Selects information from the database.
    */
	public function select($table, $rows, $where = null, $order = null, $limit= null)
	{
	    $command = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $command .= ' WHERE '.$where;
        if($order != null)
            $command .= ' ORDER BY '.$order;            
        if($limit != null)
            $command .= ' LIMIT '.$limit;
		//echo"$command<br><br>";
		$query = parent::prepare($command);
		$query->execute();
		
		$posts = array();
		while($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			 $posts[] = $row;
		}
		//return $this->result = json_encode(array('post'=>$posts));
		//return $query->fetch(PDO::FETCH_ASSOC);
 		
        return $posts;	
 	}
	
	
	public function selectcount($tabel,$rows,$where)
	{	
		$q=$this->select($tabel,$rows,$where);
        return count($q);
		//return $q;
 	}

 	public function idurut($table,$field){
		$max=$this->select($table,"max($field)as id");
		foreach($max as $val){}
		$id=$val['id']+1;
		return $id;
	}
		
	public function nourut($field, $table, $param, $kdunit, $tgl){
		$lenght = strlen($param);
		$mul=8;
		if($lenght==2){
			$mul=$mul-1;	
			$cab=4;	
		//PU/01/201605/0001
		}elseif($lenght==3){
			$mul=$mul;
			$cab=5;	
		//PUO/01/201605/0001
		}
		
		$thn = date("Y",strtotime($tgl));
		$bln = date("m",strtotime($tgl));
		$query = $this->select($table,"$field AS maxID","SUBSTR($field,1,$lenght)='$param' and SUBSTR($field,$cab,2)='$kdunit' ORDER BY SUBSTR($field,$mul,12) desc limit 1");
		//$query = $this->select($table,"$field AS maxID","SUBSTR($field,1,$lenght)='$param' and substr($field,12,2)='$bln' and substr($field,8,4)='$thn' and substr($field,5,2)='$kdunit' ORDER BY SUBSTR($field,15,4) desc limit 1");
		foreach($query as $data){}
		$idMaxj = $data['maxID'];
		
		$temp=explode("/",$idMaxj);
		
		$noUrutj = intval($temp[3]);
		$noBlnj =  substr($temp[2], 4, 2);
		
		if($noBlnj<> $bln)
		{
			$noUrutj=1;
		} else {
			$noUrutj++;
		}
		$id=$param."/".$kdunit."/".$thn."".$bln."/".sprintf("%04s", $noUrutj);
		return $id;
	}
	
	public function newIDKM($jenis)
	{

		 $thn = date("Y");
		 $bln = date("m");
		 $tgl = date("d");
		 		
		 if($jenis=='1'){
			 	//Rawat Jalan
				$tabel = "rj";
				$idfield="no_rj";
				$pref="IRJ.";
				$id="id_rj";
				$rows  = "ifnull($idfield,0) as maxID";
				$where = "month(antrian)='$bln' and year(antrian)='$thn' and $id=(select $id as maxID from $tabel WHERE month(antrian)='$bln' and year(antrian)='$thn' ORDER BY $id DESC limit 0,1)";	
		 }
		 if($jenis=='2'){
			 	//Rawat resep
				$tabel = "resep";
				$idfield="no_resep";
				$pref="IRN.";
				$id="id";
				$rows  = "ifnull($idfield,0) as maxID";
				$where = "month(tgl)='$bln' and year(tgl)='$thn' and $id=(select $id as maxID from $tabel WHERE month(tgl)='$bln' and year(tgl)='$thn' ORDER BY $id DESC limit 0,1)";	
		 }
		 if($jenis=='3'){
			 	//konsultasi
				$tabel = "konsultasi";
				$idfield="no_konsul";
				$pref="KSL.";
				$id="id_konsul";
				$rows  = "ifnull($idfield,0) as maxID";
				$where = "month(tgl)='$bln' and year(tgl)='$thn' and $id=(select $id as maxID from $tabel WHERE month(tgl)='$bln' and year(tgl)='$thn' ORDER BY $id DESC limit 0,1)";	
		 }
		 if($jenis=='4'){
			 	//Rawat bayar
				$tabel = "td_bayar";
				$idfield="no_bayar";
				$pref="BYR.";
				$id="id";
				$rows  = "ifnull($idfield,0) as maxID";
				$where = "month(tgl)='$bln' and year(tgl)='$thn' and $id=(select $id as maxID from $tabel WHERE month(tgl)='$bln' and year(tgl)='$thn' ORDER BY $id DESC limit 0,1)";	
		 }
		 if($jenis=='5'){
			 	//Rawat Inap
				$tabel = "irna";
				$idfield="no_ri";
				$pref="IRN.";
				$id="id_ri";
				$rows  = "ifnull($idfield,0) as maxID";
				$where = "month(tgl_keluar)='$bln' and year(tgl_keluar)='$thn' and $id=(select $id as maxID from $tabel WHERE month(tgl_keluar)='$bln' and year(tgl_keluar)='$thn' ORDER BY $id DESC limit 0,1)";	
		 }
		 if($jenis=='6'){
			 	//karcis bayar
				$tabel = "td_bayarkarcis";
				$idfield="no_bayar";
				$pref="KRC.";
				$id="id";
				$rows  = "ifnull($idfield,0) as maxID";
				$where = "month(tgl)='$bln' and year(tgl)='$thn' and $id=(select $id as maxID from $tabel WHERE month(tgl)='$bln' and year(tgl)='$thn' ORDER BY $id DESC limit 0,1)";	
		 }
		 if($jenis=='8'){
			 	//Refund Bayar RJ
				$tabel = "td_refund";
				$idfield="no_refund";
				$pref="RFN.";
				$id="id_refund";
				$rows  = "ifnull($idfield,0) as maxID";
				$where = "month(tglinput)='$bln' and year(tglinput)='$thn' and $id=(select $id as maxID from $tabel WHERE month(tglinput)='$bln' and year(tglinput)='$thn' ORDER BY $id DESC limit 0,1)";	
		 }
		 	 	
			 
		
		$dt=$this->select($tabel,$rows,$where);
		//echo"<br> check select $rows from $tabel Where $where<br>";
		foreach($dt as $value){
			$idMax=$value['maxID'];
		}
		
		$noUrut = (int) substr($idMax, 12, 13);
		$noBln = (int) substr($idMax, 5, 2);

		if($idMax=='0' or empty($idMax))
		{

			$noUrut=1;
		} else {
		
			$noUrut++;
		}
				
		$newID = "$pref". $thn ."". sprintf("%02s",$bln).sprintf("%02s",$tgl)."". sprintf("%06s", $noUrut);	 
		
		return $newID;	 
    }
	
	public function paramjur($kdparam,$layanan,$cabang){
		
		$table="parameter_jurnal";
		$rows="*";
		$where="kd_param='$kdparam' AND LAYANAN='$layanan' AND cabang='$cabang'";
		
		return $this->select($table,$rows,$where);
		
	}
	
	public function get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		   $ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		//$loket=$this->select("t_loket","*","ip_loket='$ipaddress'");
		//return $ipaddress;
		foreach($this->select("c1pelayanan.t_loket","*","ip_loket='$ipaddress'") as $loket1){
		//foreach($this->select("c1pelayanan.t_loket","*","ip_loket='::1'") as $loket1){

			}
		//return $loket1['no_loket'];
			//return $ipaddress; 
	}
	
	// Function to get the client ip address
	public function get_client_ip_env() {
	    $ipaddress = '';

	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	        $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	 
	    return $ipaddress;
	}
	
	/*
    * Returns the result set
    */
	public function getResult()
	{
        return $this->result;
    }
	
	public function bulanrom($bulan){

		$bln=array(
					"1"=>"I",
					"2"=>"II",
					"3"=>"III",
					"4"=>"IV",
					"5"=>"V",
					"6"=>"VI",
					"7"=>"VII",
					"8"=>"VIII",
					"9"=>"IX",
					"10"=>"X",
					"11"=>"XI",
					"12"=>"XII",

				);
		return $bln[$bulan];


	}	
	
}

?>
