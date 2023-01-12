<link rel="stylesheet" href="apps/poli/jquery-ui.css">
<script src="apps/poli/jquery-1.8.3.js"></script>
<script src="apps/poli/jquery-ui.js"></script>


<?php 
$loket1=$db->get_client_ip();
$ipex=explode(",", $_SESSION ['iplokal']);

//foreach($db->select("c1pelayanan.t_loket","*","no_loket='$loket1'") as $val){}
foreach($db->select("c1pelayanan.t_loket","*","ip_loket='$ipex[0]'") as $val){}

// if(!empty($val['ip_loket']) or $val['ip_loket']!="" or $_SESSION[ID_PEG]=='116'){ 
//include"../../webclass.php";
//$db=new kelas;

?>

<form action="javascript:void(0)" method="post" id="form" name="form" onsubmit="return validateForm()">
<section class="card">
<header class="card-header">
    <div class="card-actions">
        <a href="#" class="fa fa-caret-down"></a>
    </div>
    <h2 class="card-title">Pendaftaran Pasien Rawat Jalan</h2>
    <p class="card-subtitle">
    </p>
</header>
<div class="card-body">
<div class="row">
  <div class="col-lg-4">
        <div id="test" style="height:250px; font-size:125px; width:100%; background-color:#eeeeee; text-align:center; vertical-align: middle; line-height: 225px; ">
        </div>
        <?php 
        //$loket=$db->get_client_ip();
        //$localIP = getHostByName(php_uname('n'));
        //include "http://localhost/loket.php";
        ?>
        <div class="btn-group btn-group-justified">
            <a class="btn btn-default" role="button">Loket <?=$val['no_loket']?></a>
            <a class="btn btn-warning" role="button" onclick="cmnext()";><i class="fa fa-step-forward"> Next</i></a>
            <a class="btn btn-info" role="button" onclick="cmreply()";><i class="fa fa-refresh"> Reply </i></a>
        </div><br><br>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Px Lama</label>
            <div class="col-sm-3" id="pxl" >
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Px Baru</label>
            <div class="col-sm-3" id="pxb">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label" for="w1-username">Px Online</label>
            <div class="col-sm-3" id="pxo">
            </div>
        </div>
         
  </div>
  <div class="col-md-8">
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username">Jenis Pasien</label>
            <div class="col-sm-8">
              <label for="jpx"><input type="radio" name="jpx" id="jpx1" value="B" onClick="klik(this.value)" />Baru</label>&nbsp;&nbsp;
              <label for="jpx"><input type="radio" name="jpx" id="jpx2" value="L" checked  onClick="klik(this.value)"/>Lama</label>
              <label for="jpx"><input type="radio" name="jpx" id="jpx3" value="C" onClick="klik(this.value)"/>Online</label>
            </div>
        </div>
        <div class="form-group row" id="book">
            <label class="col-sm-2 control-label" for="w1-username">Kode Online</label>
            <div class="col-sm-4">
                <input type="text" class="form-control input-sm" tabindex="1" name="online" id="online" onBlur="book(this.name)" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username">No RM</label>
            <div class="col-sm-3">
                <input type="text" class="form-control input-sm" tabindex="1" name="idrm" id="idrm" onBlur="rm(this.name)" required>
                <input name="loket" value="<?=$val['no_loket']?>" id="loket" type="hidden"/>
                <input name="nomor"  value="" id="nomor" type="hidden"/>
            </div>
            <div class="col-sm-5" id="toolsloket">
                <a class="simple-ajax-modal btn btn-primary" href="apps/cmrj/modal.php">
                <i class="fa fa-search"></i></a>
                <a  class="simple-ajax-modal btn btn-warning" role="button" href="apps/cmrj/modal2.php?st=tambah"><i class="fa fa-plus" ></i></a>
                <a  class="btn btn-warning" role="button" onClick="rm2()"  href="#" ><i class="fa fa-edit" ></i></a>
                <a style="visibility:hidden"  class="simple-ajax-modal btn btn-warning" role="button"  href="apps/cmrj/modal2.php?st=edit" id="pxedit" ><i class="fa fa-edit" ></i></a>
                <a class="simple-ajax-modal btn btn-primary" href="apps/cmrj/sjp.php"  id="sjp1" style="visibility:hidden">
                <i class="fa fa-search"></i></a>
            </div>
            
        </div>
        
      <div class="form-group row form-inline">
            <label class="col-sm-2 control-label" for="w1-username">Nama</label>
            <div class="col-sm-4">
                <input type="text" class="form-control input-sm" name="nm" id="nm" required readonly>
                
            </div>
        <label class="col-sm-1 control-label" for="w1-username">JK</label> 
          <input type="text" class="form-control input-sm" name="jk" id="jk" required readonly>

        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username">Alamat</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" name="alamat" id="alamat" required readonly>
                
            </div>
        </div>
        <div class="form-group row form-inline">
            <label class="col-sm-2 control-label" for="w1-username">Umur</label>
            <div class="col-sm-4">
                <input type="text" class="form-control input-sm" name="umur" id="umur" required value="<?=$umur?>">
                
            </div>
            

        </div>
        <div class="form-group row form-inline">
            <label class="col-sm-2 control-label" for="w1-username">Tujuan / Poli</label>
            <div class="col-sm-4">
                <select data-plugin-selectTwo class="form-control populate" onchange="tujuan()" name="poli" id="poli" tabindex="2">
                <option value="0">Pilih Tujuan Poli</option>
                <?php
                foreach($db->select("c1pelayanan.t_poli","*","fc_stspoli='1' OR fc_idpoli='19' OR fc_idpoli='20'") as $val){
                ?>
                    <option value="<?=$val[fc_idpoli]?>"><?=$val[fv_nmpoli]?></option>
                <?php
                }
                ?>
                </select>
                 
            </div>
           
        </div>
      <div class="form-group row form-inline">
            <label class="col-sm-2 control-label" for="w1-username">Cara Bayar</label>
        <div class="col-sm-4">
                <select data-plugin-selectTwo tabindex="3" class="form-control populate" name="cabar" id="cabar" onchange="sjp2()">
                <option value="0">Pilih Cara Cayar</option>
                <?php
                foreach($db->select("c1pelayanan.t_carabayarsub","*","st_aktif='1'") as $val){
                ?>
                    <option value="<?=$val[fc_kode]."_".$val[jtarif]?>"><?=$val[fv_nama]?></option>
                <?php
                }
                ?>
                </select>
          </div>
          <input type="text" class="form-control" name="sjp" id="sjp" required readonly>
        </div>
        
        
        <div class="form-group row form-inline">
            <label class="col-sm-2 control-label"  for="w1-username">Cara Datang</label>
            <div class="col-sm-4">
                <select data-plugin-selectTwo tabindex="4" class="form-control populate" name="caradat" id="caradat">
                    <option value="0">Pilih Cara Datang</option>
                <?php
                foreach($db->select("c1pelayanan.t_caradatangsub","*") as $val){
                ?>
                    <option value="<?=$val[fc_kode]?>"><?=$val[fv_nama]?></option>
                <?php
                }
                ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username">Keterangan</label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" tabindex="5" name="diag" id="diag" onkeydown = "if (event.keyCode == 13)
                        document.getElementById('simpan').click()"/>
                
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label" for="w1-username"></label>
            <div class="col-sm-3">
             <div id='ck'>
<a class="btn btn-primary" role="button" tabindex="6" id="simpan" onclick="simpan()"><i class="fa fa-save">  Simpan</i></a>
            </div>
            </div> 
            <div class="col-sm-3">
<a class="btn btn-primary" role="button" tabindex="6" id="simpan" onclick="cetlabel()"><i class="fa fa-save">  Cetak Label</i></a>
            </div> 
            <div class="col-sm-3">
            <!-- <input type="submit" class="btn btn-primary" formaction="apps/cmrj/cekkartu.php" formmethod="Get" id="CetakKartu" value="Cetak Kartu" formtarget="_blank">
                    -->
                    <a class="btn btn-primary" role="button" tabindex="6" id="CetakKartu" onclick="CetakKartu()"><i class="fa fa-save">Cetak Kartu</i></a>
            </div>
            
              <div class="col-sm-1">
            <!-- <input type="submit" class="btn btn-primary" formaction="apps/cmrj/cekkartu.php" formmethod="Get" id="CetakKartu" value="Cetak Kartu" formtarget="_blank">
                    -->
                    <a class="btn btn-primary" role="button" tabindex="6" id="CetakKartu3" onclick="CetakKartu3()"><i class="fa fa-save">K2</i></a>
 </div>

  </div>
 
  
  
  
  
   <div class="col-md-12" align="center">
   <br>
   <br>
        
  </div>

    
    
    
</div>
</div>
</section>
</form>
<script>
$( "#search_diag" ).autocomplete({
    source: "apps/poli/data.php", 
    minLength:2,   
});
            
function jadikan(a,b){
    var x = document.getElementById("diagnosa");
    var option22 = document.createElement("option");
    option22.text = a + ' - ' +b;
    option22.value = a;
    x.add(option22);
    option22.selected=true;             
}

//function coba(){
$("#diagnosa").click(function(){                    
    var x = document.getElementById("diagnosa");
    x.remove(x.selectedIndex);
    var y = document.getElementById("diagnosa").length;
    
    for (var i = 0; i <= y; i++) { 
     x.options[i].selected = true; 
    } 
    
    //document.getElementById("diagnosa").focus();
});
//}
</script>
<?php 
//}else{ echo "<script>alert('Anda Tidak dapat melakukan pendaftaran pada komputer ini !$_SERVER[REMOTE_ADDR] $val[ip_loket] $loket1 ');</script>";} ?>