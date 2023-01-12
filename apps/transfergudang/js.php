<script type="text/javascript">
// $('.server-side').DataTable( {
//         "processing": true,
//         "serverSide": true,
//         //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
//         "ajax": "apps/transfergudang/data.php"
//     } );
function typeFormInp (val) {
  //alert(val);
  $('#typeform').val(val);
}


$(document).ready(function(){
    $("#simpan").click(function(){

        if($('#date_brgkeluar').val() == '' || $('#nama_supp').val() == '' || $('#no_sj').val() == '' || $('#id_gudang').val() == ''){
          alert("Data Tidak Lengkap");
        } else {
            $('#typeform').val(2);
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/transfergudang/proses.php?act=post',data,

                        function(msg) {

                           swal({
                                 title: "Konfirmasi!",
                                 text: msg,
                                 type: "success"
                                 //timer: 1000
                              });
                           location.reload(true);
                        }
                    );
              },
              submitError: function ($form, event, errors) { 
                 //alert("Data Belum Lengkap");
             }
            });
        }
     });    
});

function simpandetail (){
  if($('#qty').val() == ''){
    alert("Data Tidak Lengkap");

  } else {
    $('#typeform').val(1);
    var data = $('#form').serializeFormJSON();        
    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
    $.post('apps/transfergudang/proses.php?act=post',data,

        function(msg) {
           $('#prosesloading').html('');
            //$('#tampilformdetail').load("apps/transfergudang/tampilformdetail.php?reload=1");
            $('.rst1').trigger("reset");
            $('.rst1').val(null).trigger('change');
            $('#caribrg').load("apps/transfergudang/tampilcari.php?reload=1");
             document.getElementById('id_barang').value = '';
             document.getElementById('qty').value = '';
             document.getElementById('id_satuan').value = '';
             document.getElementById('stok').value = '';
             $('#stokshow').html(''); 
           //$('#transfergudangtable').DataTable().ajax.reload();
           $('#tampiltable').load("apps/transfergudang/tampiltable.php?reload=1");
           $('#typeform').val("");

           swal({
                 title: "Konfirmasi!",
                 text: msg,
                 type: "success"
                 //timer: 1000
              });
        }
    );
  }
}

function cekSubDep(val) {
    $('#id_sub').load("apps/transfergudang/tampilsubdep.php?dep="+val);
}

function cekKategori(val){
    $('#id_kat').load("apps/transfergudang/tampilkategori.php?sub="+val);
}

function cekCariBrg(val){
    $('#caribrg').load("apps/transfergudang/tampilcari.php?dep="+$('#id_dep').val()+"&sub="+$('#id_sub').val()+"&kat="+val);
}

function showBrg(val){
	spl = val.split('_');
    $('#id_barang').val(spl[0]);
    $('#id_satuan').val(spl[1]);
    $.post('apps/transfergudang/cekqtycari.php?act=save',{idbarang:spl[0],idgudang:$('#id_gudang').val()},
      function(msg) {
          $('#stok').val(msg);
          $('#stokshow').html(msg+" "+spl[2]);
      }
    );    
}

function reset() {
    $('#prosesloading').html('');
    $('#form').load("apps/transfergudang/tampilform.php?reload=1");
    $('#transfergudangtable').DataTable().ajax.reload();

}

function hapuskeluardtl (val) {
  $('#prosesloading').html('<img src="../assets/images/loading.gif">');
  
  
  $.post('apps/transfergudang/proses.php?act=post',{iddtl:val,typeform:'3'},
      function(msg) {
         $('#prosesloading').html('');
        // $('#tampilformdetail').load("apps/transfergudang/tampilformdetail.php?reload=1");
        $('.frdet').trigger("reset");
        $('.frdet').val(null).trigger('change');
        $('#caribrg').load("apps/transfergudang/tampilcari.php?reload=1");
         document.getElementById('id_barang').value = '';
         document.getElementById('qty').value = '';
         document.getElementById('id_satuan').value = '';
         //$('#transfergudangtable').DataTable().ajax.reload();
         $('#tampiltable').load("apps/transfergudang/tampiltable.php?reload=1");

         swal({
               title: "Deleted!",
               text: msg,
               type: "success"
               //timer: 1000
            });
      }
  );
}

function hitungqty(val){
  if($('#jenisbrg').val() == 1){
    if(parseInt(val) > parseInt($('#stok').val())){
      alert("Stok Kurang!!");
      $('#qty').val('');
      $('#qty').focus();
    }
  }
}

function cekgudang(id){
  $('#id_gudang2').load("apps/transfergudang/tampilgudang2.php?reload=1&id="+id);
}


</script>

