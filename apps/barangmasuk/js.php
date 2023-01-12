<script type="text/javascript">
$('.datalist').DataTable( {
        "processing": true,
        "serverSide": true,
        //"ajax": "../server_side/scripts/server_processing.php" NOTE: use serverside script to fatch the data
        "ajax": "apps/barangmasuk/data.php"
    } );
function typeFormInp (val) {
  //alert(val);
  $('#typeform').val(val);
}


$(document).ready(function(){
    $("#simpan").click(function(){

        if($('#date_brgmasuk').val() == '' || $('#nama_supp').val() == '' || $('#no_sj').val() == '' || $('#id_gudang').val() == ''){
          alert("Data Tidak Lengkap");
        } else {
            $('#form input,#form select, #form select2 , #form textarea').jqBootstrapValidation({
                preventSubmit: true,
                submitSuccess: function($form, event){     
                    event.preventDefault();
                    $('#typeform').val(2);
                    var data = $('#form').serializeFormJSON();        
                    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
                    $.post('apps/barangmasuk/proses.php?act=post',data,

                        function(msg) {
                           

                           swal({
                                 title: "Konfirmasi!",
                                 text: msg,
                                 type: "success"
                                 //timer: 1000
                              });
                           window.location.reload();
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
  if($('#qty').val() == '' || $('#harga').val() == ''){
    alert("Data Tidak Lengkap");

  } else {
    $('#typeform').val(1);
    var data = $('#form').serializeFormJSON();        
    $('#prosesloading').html('<img src="../assets/images/loading.gif">');
    $.post('apps/barangmasuk/proses.php?act=post',data,

        function(msg) {
           $('#prosesloading').html('');
            //$('#tampilformdetail').load("apps/barangmasuk/tampilformdetail.php?reload=1");
            $('.frdet').trigger("reset");
            $('.frdet').val(null).trigger('change');
            $('#caribrg').load("apps/barangmasuk/tampilcari.php?reload=1");
             document.getElementById('id_barang').value = '';
             document.getElementById('qty').value = '';
             document.getElementById('id_satuan').value = '';
             document.getElementById('harga').value = '';
             document.getElementById('hargajual').value = '';
           //$('#barangmasuktable').DataTable().ajax.reload();
           $('#tampiltable').load("apps/barangmasuk/tampiltable.php?reload=1");

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

function getEdit(a){
    $.get( "apps/barangmasuk/proses.php?act=get&id="+a, function( data ) {
        // $( ".result" ).html( data );
        var jsonData = JSON.parse(data);
        for (var i = 0; i < jsonData.length; i++) {
            var counter = jsonData[i];
            // console.log(counter.cust_name);
            $('#id_barangmasuk').val(counter.id_barangmasuk);
            $('#kode_barangmasuk').val(counter.kode_barangmasuk); 
            $('#nama_barangmasuk').val(counter.nama_barangmasuk);
            $('#id_dep').load("apps/barangmasuk/tampildepartemen.php?dep="+counter.id_dep);
            $('#id_sub').load("apps/barangmasuk/tampilsubdep.php?dep="+counter.id_dep+"&sub="+counter.id_sub);
            $('#id_kat').load("apps/barangmasuk/tampilkategori.php?sub="+counter.id_sub+"&kat="+counter.id_kat);
            $('#id_dep_edit').val(counter.id_dep);
            $('#id_sub_edit').val(counter.id_sub);
            $('#id_kat_edit').val(counter.id_kat);
            $('#id_satuan').load("apps/barangmasuk/tampilsatuan.php?idsatuan="+counter.id_satuan);
            $('#status').load("apps/barangmasuk/tampilstatus.php?status="+counter.status);
            document.getElementById('kode_barangmasuk').readOnly = true;
            $('#id_dep').prop('disabled', 'disabled');
            $('#id_sub').prop('disabled', 'disabled');
            $('#id_kat').prop('disabled', 'disabled');
                      
        }
        
    });
    
}

function getModalDetail(a){
    
    $("#defaultSize").modal('show');
    $.post('apps/barangmasuk/detailbrgmasuk.php?id='+a,
        function(html){
        $("#tampilhis").html(html);
        }   
    );
    
}

function cekSubDep(val) {
    $('#id_sub').load("apps/barangmasuk/tampilsubdep.php?dep="+val);
}

function cekKategori(val){
    $('#id_kat').load("apps/barangmasuk/tampilkategori.php?sub="+val);
}

function cekCariBrg(val){
    $('#caribrg').load("apps/barangmasuk/tampilcari.php?dep="+$('#id_dep').val()+"&sub="+$('#id_sub').val()+"&kat="+val);
}

function showBrg(val){
	spl = val.split('_');
    $('#id_barang').val(spl[0]);
   // $('#kode_barang').val(spl[1]);
   // $('#nama_barang').val(spl[2]);
   // $('#satuan').val(spl[4]);
    $('#id_satuan').val(spl[3]);
}

function reset() {
    $('#prosesloading').html('');
    $('#form').load("apps/barangmasuk/tampilform.php?reload=1");
    $('#barangmasuktable').DataTable().ajax.reload();

}

function hapusmasukdtl (val) {
  $('#prosesloading').html('<img src="../assets/images/loading.gif">');
  
  
  $.post('apps/barangmasuk/proses.php?act=post',{iddtl:val,typeform:'3'},
      function(msg) {
         $('#prosesloading').html('');
        // $('#tampilformdetail').load("apps/barangmasuk/tampilformdetail.php?reload=1");
        $('.frdet').trigger("reset");
        $('.frdet').val(null).trigger('change');
        $('#caribrg').load("apps/barangmasuk/tampilcari.php?reload=1");
         document.getElementById('id_barang').value = '';
         document.getElementById('qty').value = '';
         document.getElementById('id_satuan').value = '';
         document.getElementById('harga').value = '';
         document.getElementById('hargajual').value = '';
         //$('#barangmasuktable').DataTable().ajax.reload();
         $('#tampiltable').load("apps/barangmasuk/tampiltable.php?reload=1");

         swal({
               title: "Deleted!",
               text: msg,
               type: "success"
               //timer: 1000
            });
      }
  );
}

function htjual(){
    var ht=parseFloat($('#harga').val())+parseFloat($('#harga').val()*(20/100));

    $('#hargajual').val(ht);


}
</script>

