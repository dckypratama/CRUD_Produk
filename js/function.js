var ip = "localhost";
window.tes = 'nilai lama';



function uploadGambar(id) {
    var id_produk = id;
    var name = document.getElementById("file-" + id).files[0].name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1)
    {
        alert("Invalid Image File");
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("file-" + id).files[0]);
    var f = document.getElementById("file-" + id).files[0];
    var fsize = f.size || f.fileSize;
    if (fsize > 2000000)
    {
        window.location.href = 'table_data_produk.html';
        alert("Image File Size is very big");
    } else
    {
        form_data.append("file-" + id, document.getElementById("file-" + id).files[0]);
        $.ajax({
            url: "http://" + ip + "/CRUD_Produk/proses/server.php?p=uploadImage&id_produk=" + id_produk,
            method: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
            },
            success: function (data)
            {
                window.location.href = 'table_data_produk.html';
            }
        });
    }
}


function pilihKategori() {
    $.ajax({
        url: "http://" + ip + "/CRUD_Produk/proses/ambilkategori.php",
        method: "POST",
        dataType: "html",
        success: function (resp) {
            $('#id_kategori').html(resp);
        }
    });
}

function tambahBahan(str) {
    var id_produk = str;
    var idb = document.getElementById("idb-" + id_produk).value;
    var bahan;
//    bahan = "<p id='srow" + idb + "'><input type='text' size='53' name='kompensasi[]' placeholder='Masukkan kompensasi' />  <a href='#' style=\"color:#3399FD;\" onclick='hapusBahan(\"#srow" + idb + "\"); return false;'>Delete</a></p>";
    bahan = "<div id='srow" + idb + "' class='box-body'>\n\
                    <div class='col-xs-5'><input type='text' name='bahan[]' class='form-control' placeholder='Bahan'/></div>\n\
                    <div class='col-xs-5'><input type='text' name='kuantitas[]' class='form-control' placeholder='Kuantitas'/></div>\n\
                    <div><a href='#' style=\"color:#3399FD;\" onclick='hapusBahan(\"#srow" + idb + "\"); return false;'>Delete</a></div>\n\
            </div>";
    $("#divBahan-" + id_produk).append(bahan);
    idb = (idb - 1) + 2;
    document.getElementById("idb-" + id_produk).value = idb;
}

function hapusBahan(idb) {
    $(idb).remove();
}

function insertDataBahan(str) {

//    var formdata=new FormData();
//    console.log(formdata);
//    var kategori_produk = $('#kategori_produk').val();
//    $.ajax({
//        type: "POST",
//        url: "http://" + ip + "/CRUD_Produk/proses/server.php?p=insertDK",
//        data: "kategori_produk=" + kategori_produk,
//        success: function (data) {
//            if (data == 'fail') {
//                alert('gagal tambah data');
//            }
//            viewDataKategori();
//            $('#addDataKategori').modal('hide');
//            $('.modal-backdrop').hide();
//        }
//    });

    var id_produk = str;
    var bahan = $('#bahan').val();
    ;
    var kuantitas = $('#kuantitas').val();
    ;

    console.log(bahan);
    console.log(kuantitas);

    $.ajax({
        url: "http://" + ip + "/CRUD_Produk/proses/server.php?p=insertDataB",
        type: 'post',
        dataType: "json",
        data: "id_produk=" + id_produk + "&bahan=" + bahan + "&kuantitas=" + kuantitas,
        success: function (data) {
            if (data == 'fail') {
                alert('gagal tambah data');
            }
            viewDataProduk();
            $('#addDataProduk').modal('hide');
            $('.modal-backdrop').hide();

        }

    });


}
function insertDataProduk() {

    var nama_produk = $('#nama_produk').val();
    var harga_produk = $('#harga_produk').val();
    var berat_produk = $('#berat_produk').val();
    var minimal_pemesanan_produk = $('#minimal_pemesanan_produk').val();
    var id_kategori = $('#id_kategori').val();
    $.ajax({
        type: "POST",
        url: "http://" + ip + "/CRUD_Produk/proses/server.php?p=insertDP",
        data: "nama_produk=" + nama_produk + "&harga_produk=" + harga_produk + "&berat_produk=" + berat_produk + "&minimal_pemesanan_produk=" + minimal_pemesanan_produk + "&id_kategori=" + id_kategori,
        success: function (data) {
            if (data == 'fail') {
                alert('gagal tambah data');
            }
            viewDataProduk();
            $('#addDataProduk').modal('hide');
            $('.modal-backdrop').hide();
        }
    });

}

function viewDataProduk() {
    $.ajax({
        type: "GET",
        url: "http://" + ip + "/CRUD_Produk/proses/server.php?p=viewDP",
        success: function (data) {
            $('tbody').html(data);
        }
    });
}

function updateDataProduk(str) {
    var id_produk = str;
    var nama_produk = $('#nama_produk-' + str).val();
    var harga_produk = $('#harga_produk-' + str).val();
    var berat_produk = $('#berat_produk-' + str).val();
    var minimal_pemesanan_produk = $('#minimal_pemesanan_produk-' + str).val();
    var id_kategori = $('#id_kategori-' + str).val();

    $.ajax({
        type: "POST",
        url: "http://" + ip + "/CRUD_Produk/proses/server.php?p=editDP",
        data: "id_produk=" + id_produk + "&nama_produk=" + nama_produk + "&harga_produk=" + harga_produk + "&berat_produk=" + berat_produk + "&minimal_pemesanan_produk=" + minimal_pemesanan_produk + "&id_kategori=" + id_kategori,
        success: function (data) {
            window.location.href = 'table_data_produk.html';
        }
    });
}

function deleteDataProduk(str) {
    var id_produk = str;
    $.ajax({
        type: "GET",
        url: "http://" + ip + "/CRUD_Produk/proses/server.php?p=deleteDP",
        data: "id_produk=" + id_produk,
        success: function (data) {
            viewDataProduk();
        }
    });
}

function insertDataKategori() {

//    var formdata=new FormData();
//    console.log(formdata);
    var kategori_produk = $('#kategori_produk').val();
    $.ajax({
        type: "POST",
        url: "http://" + ip + "/CRUD_Produk/proses/server.php?p=insertDK",
        data: "kategori_produk=" + kategori_produk,
        success: function (data) {
            if (data == 'fail') {
                alert('gagal tambah data');
            }
            viewDataKategori();
            $('#addDataKategori').modal('hide');
            $('.modal-backdrop').hide();
        }
    });
}

function viewDataKategori() {
    $.ajax({
        type: "GET",
        url: "http://" + ip + "/CRUD_Produk/proses/server.php?p=viewDK",
        success: function (data) {
            $('tbody').html(data);
        }
    });
}

function updateDataKategori(str) {
    var id_kategori = str;
    var kategori_produk = $('#kategori_produk-' + str).val();

    $.ajax({
        type: "POST",
        url: "http://" + ip + "/CRUD_Produk/proses/server.php?p=editDK",
        data: "id_kategori=" + id_kategori + "&kategori_produk=" + kategori_produk,
        success: function (data) {
            window.location.href = 'table_data_kategori.html';
        }
    });
}

function deleteDataKategori(str) {
    var id_kategori = str;
    $.ajax({
        type: "GET",
        url: "http://" + ip + "/CRUD_Produk/proses/server.php?p=deleteDK",
        data: "id_kategori=" + id_kategori,
        success: function (data) {
            viewDataKategori();
        }
    });
}