<?php
$conn = mysql_connect('localhost', 'root', '');
$db = mysql_select_db('crud-produk', $conn);
$page = isset($_GET['p']) ? $_GET['p'] : '';
if ($page == 'uploadImage') {

    $id_produk = $_GET['id_produk'];
    if ($_FILES["file-" . $id_produk]["name"] != '') {
        $test = explode('.', $_FILES["file-" . $id_produk]["name"]);
        $ext = end($test);
        $name = rand(100, 999) . '.' . $ext;
        $location = './../upload/' . $name;
        move_uploaded_file($_FILES["file-" . $id_produk]["tmp_name"], $location);
        $sql = mysql_query("update produk set gambar_produk='$name' where id_produk='$id_produk' ");
    }
} else if ($page == 'insertDataB') {


    $id_produk = $_POST['id_produk'];
    $bahan = $_POST['bahan'];
    $kuantitas = $_POST['kuantitas'];


// Converting the array to comma separated string
    // insert
    $sql = mysql_query("INSERT INTO bahan(bahan,kuantitas,id_produk) VALUES('" . $bahan . "','" . $kuantitas . "','" . $id_produk . "')");
    if ($sql) {
        echo "success";
    } else {
        echo "fail";
    }
//    $return_arr = array('name' => $name, 'email' => $email, 'lang' => $lang, "foundjquery" => $foundjquery);
//    echo json_encode($return_arr);
////    $nama_produk = $_POST['nama_produk'];
//    $harga_produk = $_POST['harga_produk'];
//    $berat_produk = $_POST['berat_produk'];
//    $minimal_pemesanan_produk = $_POST['minimal_pemesanan_produk'];
//    $id_kategori = $_POST['id_kategori'];
//    $gambar_produk = $_POST['gambar_produk'];
//    $sql = mysql_query("insert into produk (nama_produk, harga_produk, berat_produk, minimal_pemesanan_produk, id_kategori, gambar_produk) 
//            values('$nama_produk', '$harga_produk', '$berat_produk', '$minimal_pemesanan_produk', '$id_kategori', '$gambar_produk')");
//    if ($sql) {
//        echo "success";
//    } else {
//        echo "fail";
//    }
} else if ($page == 'insertDP') {

    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $berat_produk = $_POST['berat_produk'];
    $minimal_pemesanan_produk = $_POST['minimal_pemesanan_produk'];
    $id_kategori = $_POST['id_kategori'];
    $sql = mysql_query("insert into produk (nama_produk, harga_produk, berat_produk, minimal_pemesanan_produk, id_kategori) 
            values('$nama_produk', '$harga_produk', '$berat_produk', '$minimal_pemesanan_produk', '$id_kategori')");
    if ($sql) {
        echo "success";
    } else {
        echo "fail";
    }
} else if ($page == 'insertDPF') {

    if (!empty($_POST['nama_produk']) || !empty($_FILES['file']['name'])) {
        $uploadedFile = '';
        if (!empty($_FILES["file"]["type"])) {
            $fileName = time() . '_' . $_FILES['file']['name'];
            $valid_extensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $_FILES["file"]["name"]);
            $file_extension = end($temporary);
            if ((($_FILES["hard_file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)) {
                $sourcePath = $_FILES['file']['tmp_name'];
                $targetPath = "upload/" . $fileName;
                if (move_uploaded_file($sourcePath, $targetPath)) {
                    $uploadedFile = $fileName;
                }
            }
        }

        $nama_produk = $_POST['nama_produk'];
        $harga_produk = $_POST['harga_produk'];
        $berat_produk = $_POST['berat_produk'];
        $minimal_pemesanan_produk = $_POST['minimal_pemesanan_produk'];
        $id_kategori = $_POST['id_kategori'];
        $gambar_produk = $_POST['gambar_produk'];

        //insert form data in the database
        //$insert = $db->query("INSERT form_data (name,email,file_name) VALUES ('" . $name . "','" . $email . "','" . $uploadedFile . "')");
        $insert = mysql_query("insert into produk (nama_produk, harga_produk, berat_produk, minimal_pemesanan_produk, id_kategori, gambar_produk) 
            values('$nama_produk', '$harga_produk', '$berat_produk', '$minimal_pemesanan_produk', '$id_kategori', '$uploadedFile')");

        echo $insert ? 'ok' : 'err';
    }
} else if ($page == 'viewDP') {

    function rupiah($angka) {

        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }

    $sql = mysql_query("select p.*, k.kategori_produk as kategori from produk p join kategori k on p.id_kategori = k.id_kategori order by id_produk");
    while ($row = mysql_fetch_array($sql)) {
        $a = $row['id_produk'];
        $sql1 = mysql_query("select * from bahan where id_produk= $a");
        $row2 = mysql_fetch_array($sql1);
        ?>
        <tr> 
            <td><?php echo $row['id_produk']; ?> </td>
            <td><?php echo $row['nama_produk']; ?> </td>
            <td><?php echo $row['kategori']; ?> </td>
            <td><?php echo rupiah($row['harga_produk']); ?> </td>
            <td><?php echo $row['berat_produk']; ?> </td>
            <td><?php echo $row['minimal_pemesanan_produk']; ?> </td>
            <td>
        <?php if ($row['gambar_produk'] != null) {
            ?><img class = 'img-responsive' src = '../upload/<?php echo $row['gambar_produk'] ?> 'width="60px"></td>

                <?php } else {
                    ?>
            <span class="glyphicon glyphicon-alert"></span>
                <?php
            }
            ?>
        <td>
            <button class="btn btn-success" data-toggle="modal" onclick="console.log('#editDataBahan-<?php echo $row['id_produk'] ?>')" data-target="#editDataBahan-<?php echo $row['id_produk'] ?>">Insert</button>              
            <div class="modal fade" id="editDataBahan-<?php echo $row['id_produk'] ?>" tabindex="-1" role="dialog" aria-labelledby="editLabelDataBahan-<?php echo $row['id_produk'] ?>">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="editLabel-<?php echo $row['id_produk'] ?>">Insert Data Bahan</h4>
                        </div>
                        <form>
                            <div class="modal-body">   
                                <div class="form-group">
                                    <input type="hidden" id="id_produk" value="<?php echo $row['id_produk'] ?>" class="form-control" />
                                </div>   
                                <div class="form-group">
                                    <label for="nama_produk">Nama Produk</label>
                                    <input type="text" id="nama_produk-<?php echo $row['id_produk'] ?>" value="<?php echo $row['nama_produk'] ?>" class="form-control" disabled />
                                </div>

                                <input id="idb-<?php echo $row['id_produk'] ?>" value="1" type="hidden" />
                                <button type="button"  class="btn btn-success" onclick="tambahBahan(<?php echo $row['id_produk'] ?>);
                                                return false;">Tambah Bahan</button>
                                <div class="box-body" id="divBahan-<?php echo $row['id_produk'] ?>">
                                    <a>*Klik sebanyak bahan yang ingin ditambahkan</a>
                                    <div class="form-group" id="divBahan-<?php echo $row['id_produk'] ?>">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" onclick="insertDataBahan(<?php echo $row['id_produk'] ?>)">Insert Bahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </td>
        }
        <td>
            <button data-toggle="modal" data-target="#upload-<?php echo $row['id_produk'] ?>" class="btn btn-primary">Upload</button>           
            <button class="btn btn-warning" data-toggle="modal" onclick="console.log('#editDataProduk-<?php echo $row['id_produk'] ?>')" data-target="#editDataProduk-<?php echo $row['id_produk'] ?>">Edit</button>              
            <div class="modal fade" id="editDataProduk-<?php echo $row['id_produk'] ?>" tabindex="-1" role="dialog" aria-labelledby="editLabelDataProduk-<?php echo $row['id_produk'] ?>">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="editLabel-<?php echo $row['id_produk'] ?>">Edit Data Produk</h4>
                        </div>
                        <form>
                            <div class="modal-body">
                                <input type="hidden" id="<?php echo $row['id_produk'] ?>" value="<?php echo $row['id_produk'] ?>"/>                          

                                <div class="form-group">
                                    <label for="nama_produk">Nama Produk</label>
                                    <input type="text" id="nama_produk-<?php echo $row['id_produk'] ?>" value="<?php echo $row['nama_produk'] ?>" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="id_kategori">Kategori Produk</label>
                                    <select id="id_kategori-<?php echo $row['id_produk'] ?>" class="form-control" >
        <?php
        $sql1 = mysql_query("select * from kategori order by id_kategori");
        $b = $row['id_kategori'];
        $sql2 = mysql_query("select kategori_produk from kategori where id_kategori='$b'");
        $row2 = mysql_fetch_array($sql2);
        $b1 = $row2['kategori_produk'];
        $datakategori = "<option value='$b' > $b1 </option>";
        if (mysql_num_rows($sql1) > 0) {
            while ($row1 = mysql_fetch_object($sql1)) {
                $datakategori.="<option value='$row1->id_kategori' > $row1->kategori_produk </option>";
            }
        }
        echo $datakategori;
        ?>
                                    </select>
                                    <a href='table_data_kategori.html' style="color:#3399FD;">*Klik untuk menambahkan kategori</a>

                                </div>

                                <div class="form-group">
                                    <label for="harga_produk">Harga Produk</label>
                                    <input type="text" id="harga_produk-<?php echo $row['id_produk'] ?>" value="<?php echo $row['harga_produk'] ?>" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="gambar_produk">Gambar Produk</label>
                                    <input type="text" id="gambar_produk-<?php echo $row['id_produk'] ?>" value="<?php echo $row['gambar_produk'] ?>" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="berat_produk">Berat Produk</label>
                                    <input type="text" id="berat_produk-<?php echo $row['id_produk'] ?>" value="<?php echo $row['berat_produk'] ?>" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="minimal_pemesanan_produk">Minimal Pemesanan Produk</label>
                                    <input type="text" id="minimal_pemesanan_produk-<?php echo $row['id_produk'] ?>" value="<?php echo $row['minimal_pemesanan_produk'] ?>" class="form-control" />
                                </div>                                   
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" onclick="updateDataProduk(<?php echo $row['id_produk'] ?>)">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>     
            <button onclick="deleteDataProduk(<?php echo $row['id_produk'] ?>)" class="btn btn-danger">Delete</button> 
            <div class="modal fade" id="upload-<?php echo $row['id_produk'] ?>" tabindex="-1" role="dialog" aria-labelledby="uploadLabel-<?php echo $row['id_produk'] ?>">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="editLabel-<?php echo $row['id_wisata'] ?>">Upload Image</h4>
                        </div>
                        <form>
                            <div class="modal-body">
                                <input type="hidden" name="id_produk" id="<?php echo $row['id_produk'] ?>" value="<?php echo $row['id_produk'] ?>"/>                          
                                <div class="form-group">
                                    <label for="nama_produk">Nama Produk</label>
                                    <input disabled type="text" id="nama_produk-<?php echo $row['id_produk'] ?>" value="<?php echo $row['nama_produk'] ?>" class="form-control" />
                                </div>
                                <div class="form-group">
        <?php if ($row['gambar_produk'] != null) {
            ?><img class = 'img-responsive' src = '../upload/<?php echo $row['gambar_produk'] ?> ' alt = 'Gambar' width="60px">

                                    <?php }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="gambar_produk">Gambar Produk</label>
                                    <input type="file" id="file-<?php echo $row['id_produk'] ?>" name="file" class="form-control" />
                                </div>
                                <div id="uploaded_image"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" onclick="uploadGambar(<?php echo $row['id_produk'] ?>)">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </td>
        </tr>
        <script type="text/javascript" src="../js/function.js"></script>

        <?php
    }
} else if ($page == 'editDP') {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $berat_produk = $_POST['berat_produk'];
    $minimal_pemesanan_produk = $_POST['minimal_pemesanan_produk'];
    $id_kategori = $_POST['id_kategori'];

    $sql = mysql_query("update produk set nama_produk='$nama_produk', harga_produk='$harga_produk', berat_produk='$berat_produk', minimal_pemesanan_produk='$minimal_pemesanan_produk', id_kategori='$id_kategori' where id_produk='$id_produk'");
    if ($sql) {
        echo "success";
    } else {
        echo "fail";
    }
} else if ($page == 'deleteDP') {
    $id_produk = $_GET['id_produk'];
    $sql = mysql_query("delete from produk where id_produk='$id_produk'");
    if ($sql) {
        echo "success";
    } else {
        echo "fail";
    }
} else if ($page == 'insertDK') {

    $kategori_produk = $_POST['kategori_produk'];
    $sql = mysql_query("insert into kategori (kategori_produk) 
            values('$kategori_produk')");
    if ($sql) {
        echo "success";
    } else {
        echo "fail";
    }
} else if ($page == 'viewDK') {
    $sql = mysql_query("select * from kategori order by id_kategori");
    while ($row = mysql_fetch_array($sql)) {
        ?>
        <tr>
            <td><?php echo $row['id_kategori']; ?> </td>
            <td><?php echo $row['kategori_produk']; ?> </td>
            <td>
                <button class="btn btn-warning" data-toggle="modal" onclick="console.log('#editDataKategori-<?php echo $row['id_kategori'] ?>')" data-target="#editDataKategori-<?php echo $row['id_kategori'] ?>">Edit</button>              
                <div class="modal fade" id="editDataKategori-<?php echo $row['id_kategori'] ?>" tabindex="-1" role="dialog" aria-labelledby="editLabelDataKategori-<?php echo $row['id_kategori'] ?>">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="editLabel-<?php echo $row['id_kategori'] ?>">Edit Data Kategori</h4>
                            </div>
                            <form>
                                <div class="modal-body">
                                    <input type="hidden" id="<?php echo $row['id_kategori'] ?>" value="<?php echo $row['id_kategori'] ?>"/>                          

                                    <div class="form-group">
                                        <label for="kategori_produk">Kategori Produk</label>
                                        <input type="text" id="kategori_produk-<?php echo $row['id_kategori'] ?>" value="<?php echo $row['kategori_produk'] ?>" class="form-control" />
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" onclick="updateDataKategori(<?php echo $row['id_kategori'] ?>)">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>     
                <button onclick="deleteDataKategori(<?php echo $row['id_kategori'] ?>)" class="btn btn-danger">Delete</button> 

            </td>
        </tr>
        <script type="text/javascript" src="../js/function.js"></script>
        <?php
    }
} else if ($page == 'editDK') {
    $id_kategori = $_POST['id_kategori'];
    $kategori_produk = $_POST['kategori_produk'];
    $sql = mysql_query("update kategori set kategori_produk='$kategori_produk' where id_kategori='$id_kategori'");
    if ($sql) {
        echo "success";
    } else {
        echo "fail";
    }
} else if ($page == 'deleteDK') {
    $id_kategori = $_GET['id_kategori'];
    $sql = mysql_query("delete from kategori where id_kategori='$id_kategori'");
    if ($sql) {
        echo "success";
    } else {
        echo "fail";
    }
} 