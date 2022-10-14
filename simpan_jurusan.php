<?php
if(empty($_POST['nama_jurusan'])) {
    echo '<script>alert("Maaf kolom wajib diisi");</script>
    <meta http-equiv="refresh" content="0, jurusan.php">';
} else {
    include "koneksi.php";
    $namajurusan=strip_tags($_POST['nama_jurusan']);

    $sql="CALL tambah_jurusan('$namajurusan')";

    if(mysqli_query($koneksi,$sql)) {
        echo '<script>alert("Data telah ditambahkan");</script>
        <meta http-equiv="refresh" content="0, jurusan.php">';
    } else {
        echo '<script>alert("Gagal menambahkan data");</script>
        <meta http-equiv="refresh" content="0, jurusan.php">';
    }
}