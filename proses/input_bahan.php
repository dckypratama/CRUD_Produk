<?php
$conn = mysql_connect('localhost', 'root', '');
$db = mysql_select_db('crud-produk', $conn);

$id_produk = $_POST['id_produk'];
    


    if (isset($_POST['bahan'])||isset($_POST['kuantitas'])) {
        $bahan = $_POST['bahan'];
        $kuantitas = $_POST['kuantitas'];
        reset($bahan);
        while (list($key, $value) = each($bahan)) {
            $bahan = $_POST['bahan'][$key];
            $kuantitas = $_POST['kuantitas'][$key];
            $sql_bahan = "INSERT INTO bahan(bahan, kuantitas, id_produk)
			  VALUES('$bahan','$kuantitas','$id_produk')";
            $hasil_bahan = mysql_query($sql_bahan);
        }
    }


if ($hasil_bahan) {
   
//    echo "<script> window.alert('Bahan berhasil diinput'); window.location='../admin/table_data_produk.html'; </script>";
} else {
    echo "Data Gagal diinput";
}
?>