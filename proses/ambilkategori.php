<?php
$conn = mysql_connect('localhost', 'root', '');
$db = mysql_select_db('crud-produk', $conn);
$sql = mysql_query("select * from kategori order by id_kategori");
$datawisata="<option value='' > --Pilih Kategori-- </option>";
if (mysql_num_rows($sql) > 0) {
    while ($row = mysql_fetch_object($sql)) {
        $datawisata.="<option value='$row->id_kategori' > $row->kategori_produk </option>";
    }
}
echo $datawisata;