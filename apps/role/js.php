<script>


function change(a,b){
	//alert(a);
	//window.location="index.php?x=tindakan&id="+b+"&jenis="+a;
	window.location="index.php?x=ekrs&id="+a;	
}
function loncat(){
	
	rm2();
	//window.open("apps/cmrj/modal2.php?st=tambah&st="+id,"_blank");
	
	
}
function rm2(){
	if($('#idrm').val()!=""){
		$.ajax({
			  type:"get",
			  url:"apps/cmrj/px.php",
			  data:"icd="+$('#idrm').val(),
			  success:function(data){
				  
				   if(data==""){
						alert("Maaf No Rekmed tidak ada!!!");
					}	else{
						$("#pxedit").attr("href", "apps/cmrj/modal2.php?st=edit&idrm="+$('#idrm').val());
						document.getElementById("pxedit").click();
					}
			  }
		});
	}else{
		alert('Data Belum Diisi');
	}
		
	
}

function tampilkota(dep){
	$("#kota").load("kota.php?prop="+dep);
}
function tampilkec(prop,kota){
	$("#kecamatan").load("kec.php?prop="+prop+"&kota="+kota);
}
function tampilkel(prop,kota,kec){
	$("#kelurahan").load("desa.php?prop="+prop+"&kota="+kota+"&kec="+kec);
}

function rm3(){
	if($('#idrm').val()!=""){
		$.ajax({
			  type:"get",
			  url:"apps/cmrj/pxrjk.php",
			  data:"icd="+$('#idrm').val(),
			  success:function(data){
				  
				   if(data==""){
						alert("Maaf No Rekmed tidak ada!!!");
					}	else{
						var dtku=data.split(";")
			   			$('#nm').val(dtku[0]);
						$('#idrm').val(dtku[1]);
						$('#jk').val(dtku[2]);
						$('#alamat').val(dtku[3]);
						$('#umur').val(dtku[4]);
						$('#poli_awal').val(dtku[5]);
						$('#tgl_input').val(dtku[6]);
						$('#kdpoli_awal').val(dtku[7]);
					}
			  }
		});
	}else{
		alert('Data Belum Diisi');
	}
		
	
}
function klik1(a){
	//alert(a);
	if(a=='B'){
		document.getElementById("pxnew").style.display="block";
		
		
	}
	if(a=='L'){
		document.getElementById("pxnew").style.display="none";
	}
	
}
$("#book").hide();
function klik(a){
 if($('input[name="jpx"]:checked').val()=="C")
    {
    	//alert("Online");
    	$("#toolsloket").hide();
    	$("#book").show();
    } else {
    	//alert("Offline");
    	$("#toolsloket").show();
    	$("#book").hide();
    }
}
$(document).ready(function(e) {
	document.getElementById("test").innerHTML='---';
	$("#poli").select2("val", "0");
	    
});
function book(){
		$.ajax({
			  type:"get",
			  url:"apps/cmrjo/onlinebook.php",
			  data:"online="+$('#online').val(),
			  success:function(data){
			  	//alert(data);
				var dt = data.split(";");			  	
				   if(dt[0]=="ok"){
						$('#idrm').val(dt[2]);
						$('#nm').val(dt[1]);
						//$('#poli').val(dt[9]);
						$("#poli").val(dt[9]).trigger("change");
						$('#jk').val(dt[3]);
						$('#alamat').val(dt[4]);
						$('#umur').val(dt[5]);
						$('#poliname').val(dt[10]);
						
						$("#cabar").val(dt[8]).trigger("change");
						$('#caradat').val(dt[7]).trigger("change");
						//$('#cabarname').val(dt[11]);
						$('#caradatname').val(dt[12]);
						
						$("#sjp1").attr("href", "apps/cmrj/sjp.php?idrm="+dt[2]+"&nm="+dt[1]+"&jk="+dt[3]+"&umur="+dt[5]+"&poli="+dt[9]);
					}	else{
						alert("Kode Booking Tidak Ditemukan!!!");
					}
			  }
		});

		//tujuan();

		
}




function openIframe()
{
	//alert("ok");
	document.getElementById("result").innerHTML='Loading Data, Please Wait....';
	$.get('apps/pkeluar/data_pas.php?data='+$('#peserta').val(), function(data) {
		$('#result').html(data);    
	});			
}		



function cmnext(){
	//alert();
	var jpx=$('input[name="jpx"]:checked').val();
	$.ajax({
		  type:"get",
		  url:"apps/cmrj/pxnext.php",
		  data:"loket="+$('#loket').val()+"&jenis="+jpx,
		  success:function(data){
			//alert(data);
			document.getElementById("test").innerHTML=data;
			document.getElementById("nomor").value=data;
						
					
		  }
	}); 
	
}

function sjp2(){
	//alert($('#cabar').val());
	if($('#sjp').val()=="" && $('#idrm').val()!="" ){
	var sp=$('#cabar').val().split("_");
	if(sp[1]=="1"){
	document.getElementById("sjp1").click();
	}
	} else {
		alert("SJP Telah Dibuat / No RM belum di isi");
		
	}
	
}
/*
$('input').keypress(function(e){

	if(e.which==13){
	

		window.event.keycode=9;
		e.preventDefault();
		}
	
	});
*/
var auto_refresh = setInterval(
function ()
{
$.ajax({
		  type:"get",
		  url:"apps/cmrj/tpx.php",
		  data:"icd="+$('#idrm').val(),
		  success:function(data){
			   		//alert(data);
					var dtku=data.split(";")
			   		
					document.getElementById("pxb").innerHTML=dtku[0];
					document.getElementById("pxl").innerHTML=dtku[1];
					document.getElementById("pxo").innerHTML=dtku[2];
						
				}	
		  
	})
}, 5000);

function rm(name){
	if($('#idrm').val()!=""){
	$.ajax({
		  type:"get",
		  url:"apps/cmrj/px.php",
		  data:"icd="+$('#idrm').val(),
		  success:function(data){
			   if(data==""){
				   	alert("Maaf PX tidak ada!!!");
					$('#idrm').val("");
					$('#nm').val("");
					$('#jk').val("");
					$('#alamat').val("");
					$('#umur').val("");
					$("#idrm").focus();
					} else {
						//alert(data);
						var dtku=data.split(";")
			   			$('#nm').val(dtku[0]);
						$('#jk').val(dtku[2]);
						$('#alamat').val(dtku[3]);
						$('#umur').val(dtku[4]);
						var res = dtku[4].split(" ");
						//alert(res[0]);
						if(res[0]>=116)
						{
							$("#ck").hide();
						}else
						{
							$("#ck").show();
						}
						$("#sjp1").attr("href", "apps/cmrj/sjp.php?idrm="+$('#idrm').val()+"&nm="+dtku[0]+"&jk="+dtku[2]+"&umur="+dtku[4]+"&poli="+$('#poli').val());
						//$('#poli').focus();
						
				}	
		  }
	});
	} else {
		alert("No Rekam Medis harus Disini");
		$('#idrm').val("");
		$("#idrm").focus();
		
	}	
	
}

function tujuan(){

	
	$("#sjp1").attr("href", "apps/cmrj/sjp.php?idrm="+$('#idrm').val()+"&nm="+$('#nm').val()+"&jk="+$('#jk').val()+"&umur="+$('#umur').val()+"&poli="+$('#poli').val());
	
}

function cmreply(){
	alert("reply");
	$.ajax({ 
		  type:"get",
		  url:"apps/cmrj/pxreply.php",
		  data:"loket="+$('#loket').val()+"&nomor="+$('#nomor').val(),
		  success:function(data){
			//alert(data);
			//document.getElementById("test").innerHTML=data;
			//document.getElementById("nomor").value=data;			
		  }
	});
	
}


function simpan(){
	//alert("simpan"); 
	var rm=$('#idrm').val();
	var jpx=$('#jpx').val();
	var poli=$('#poli').val();
	var cabar=$('#cabar').val();
	var cadat=$('#caradat').val();
	if($('input[name="jpx"]:checked').val()!="C"){
	//alert(rm + jpx + poli + cabar + cadat)
	if(rm!="" && jpx!="" && poli!="0" && cabar!="0" && caradat!="0"){
		      
			//alert("disini");
			$.ajax({
				  type:"POST",
				  url:"apps/cmrj/simpanreg.php",
				  data:$('#form').serialize(),
				  success:function(data){
					   //alert(data);
					   var dtny=data.split("_");
					   if(dtny[0]=="0"){
							alert("Data Tidak Tersimpan!!!");
							} else if(dtny[0]=="3"){
								alert("Pasien Sudah Terdaftar di Poli tersebut!!");
								} else {
								alert("data tersimpan ");
								var rm=$('#idrm').val();
								$('#idrm').val("");
								$('#jpx').val("");
								$('#nm').val("");
								$('#alamat').val("");
								$('#umur').val("");
								$('#jk').val("");
								$('#sjp').val("");
								$('#diag').val("");
								$("#poli").select2("val", "0");
								$("#cabar").select2("val", "0");
								$("#caradat").select2("val", "0");
								$('#sjp').val("");
								//window.open('assets/qz18/dist/print1.php?id='+dtny[2], '_blank');
								window.open('apps/cmrj/cetak2.php?id='+dtny[2], '_blank');
								//window.open('http://192.168.100.109/antri/antrian.php?id='+dtny[2], '_blank');	
						}	
				  }
			}); 
	} else {
		alert("data tidak lengkap");
		}
	} else {
		//alert($('#form').serialize()+"&online="+$("#online").val());
		$.ajax({
			  type:"post",
			  url:"apps/cmrjo/simpanreg.php",
			  data:$('#form').serialize(),
			  success:function(data){
			  	//alert(data);
				  //alert(data);
					   var dtny=data.split("_");
					   if(dtny[0]=="0"){
							alert("Data Tidak Tersimpan!!!");
							} else if(dtny[0]=="3"){
								alert("Pasien Sudah Terdaftar di Poli tersebut!!");
								} else {
								alert("data tersimpan ");
								var rm=$('#idrm').val();
								$('#online').val("");
								$('#idrm').val("");
								$('#jpx').val("");
								$('#nm').val("");
								$('#alamat').val("");
								$('#umur').val("");
								$('#jk').val("");
								$('#sjp').val("");
								$('#diag').val("");
								$("#poli").select2("val", "0");
								$("#cabar").select2("val", "0");
								$("#caradat").select2("val", "0");
								$('#sjp').val("");
								//window.open('assets/qz18/dist/print1.php?id='+dtny[2], '_blank');
								window.open('apps/cmrj/cetak2.php?id='+dtny[2], '_blank');
								//window.open('http://192.168.100.109/antri/antrian.php?id='+dtny[2], '_blank');	
						}	
			  }
		});

	}
}

function CetakKartu3(){
	var rm=$('#idrm').val();
	var nm=$('#nm').val().replace(/ /g,"_");
	//alert(nm);
	var alamat=$('#alamat').val().replace(/ /g,"_");
	window.location='jav:kartu:'+rm+':'+nm+':'+alamat;	
}
function CetakKartu(){
	var rm=$('#idrm').val();
	var nm=$('#nm').val();
	var alamat=$('#alamat').val();
	window.open('apps/cmrj/cekkartu.php?idrm='+rm+'&nm='+nm+'&alamat='+alamat, '_blank');
	
}

function cetlabel(){
	var rm=$('#idrm').val();
	var nm=$('#nm').val();
	var alamat=$('#alamat').val();
	window.open('apps/cmrj/cetakstiker.php?id='+rm, '_blank');
	
}

function validateForm(){
	//alert("enter");
	//simpan();
	//alert("enter");
	return false;
	
}


function simpanrjk(){
	//alert("simpan");
	var rm=$('#idrm').val();
	if(rm!=""){
		   $.ajax({
				  type:"POST",
				  url:"apps/cmrj/simpanregrjk.php",
				  data:$('#form').serialize(),
				  success:function(data){
					  //alert(data);
					 	alert("data tersimpan ");
						var rm=$('#idrm').val();
						$('#idrm').val("");
								$('#nm').val("");
								$('#alamat').val("");
								$('#umur').val("");
								$('#jk').val("");
								$('#poli_awal').val("");	
								$('#tgl_input').val("");		
							
				  }
			}); 
	} else {
		alert("data tidak lengkap");
		}
}

$(".datepicker1").datepicker({
		format: 'dd-mm-yyyy',
		 
		 });

</script>