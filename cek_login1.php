<?php
session_start ();
date_default_timezone_set ( 'Asia/Jakarta' );
//include 'koneksi.php';
include 'webclass.php';
$db = new kelas();
$username = $_POST ['username'];
$pass = md5($_POST ['pwd']); 
$tabel = "user_login a left join m_pegawai b on a.id_pegawai=b.id_pegawai";
$fild  = "a.*,b.nama_pegawai,ID_CABANG"; //menampilkan semua fild
$where = "a.username='$username' AND a.password='$pass'";
// echo"select $fild from $tabel where $where";

	$dtk=$db->select($tabel,$fild,$where);
	//echo count($dt);
	if(count($dtk)>=1){
		//echo"stet";
		foreach($dtk as $value){
			echo $value['id'];
			
			$_SESSION ['ID_PEG'] = $value['ID_PEGAWAI'];
			$_SESSION ['LOGIN_PEG'] = $value['USERNAME'];
			$_SESSION ['NAMA_PEG'] = $value['nama_pegawai'];
			$_SESSION ['ID_CAB'] = $value['ID_CABANG'];
			$_SESSION ['ID_ROLE'] = $value['ID_ROLE'];
			$_SESSION ['iplokal'] = $_POST['ip'];		
			
			$haktemp="";
			$hak_a=$db->select("m_role_dtl","*","ID_ROLE='$_SESSION[ID_ROLE]'");
			foreach($hak_a as $hak_akses){
				$haktemp=$haktemp."".$hak_akses['id_menu'].",";
			}
			$akses_menu=rtrim($haktemp,',');
			$array_akses_menu=explode(',',$akses_menu);

			
			
			$menu=$db->select("r_main_menu","*","PARENT=0 AND STATUS=1 AND ID IN($akses_menu)");
			foreach($menu as $vmenu)
			{
				$mm2[$vmenu[ID]]=$vmenu;
				$cc[$vmenu[SLUG]]=$vmenu;
				$child=$db->select("r_main_menu","*","(PARENT='$vmenu[ID]' and PARENT_SUB='') AND STATUS=1 AND ID IN($akses_menu)");				
				foreach($child as $vchild){
					$mm2[$vmenu[ID]]['CHILD1'][$vchild[ID]]=$vchild;
					$cc[$vchild[SLUG]]=$vchild;
					$child2=$db->select("r_main_menu","*","PARENT_SUB='$vchild[ID]' AND STATUS=1 AND ID IN($akses_menu)");												
					
						if(count($child2)>0){
							foreach($child2 as $vchild2){
								$mm2[$vmenu[ID]]['CHILD1'][$vchild[ID]][CHILD2][$vchild2[ID]]=$vchild2;
								$cc[$vchild2[SLUG]]=$vchild2;
							}
							
						}
				}
			}
			$mk2=$db->select("r_main_menu","*");
			foreach($mk2 as $mk22){
				// $mm2a[$vmenu[ID]]=$vmenu;
				$mm2b[$mk22[SLUG]]=$mk22;
			}
			
			$_SESSION['MENU']=$mm2;
			$_SESSION['CONTENT']=$mm2b;

			// var_dump($mm2b);
			
			 echo "<script>location.href='index.php';</script>";	
		}
		
	} else {
		
			 echo "<script>location.href='index.php';</script>"; 
		}
	
?>
