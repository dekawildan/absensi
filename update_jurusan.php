<?php
if(empty($_POST['nama_jurusan'])) {
    echo '<script>alert("Maaf kolom wajib diisi");</script>
    <meta http-equiv="refresh" content="0, jurusan.php">';
} else {
    include "koneksi.php";
    $idjurusan=$_POST['jurusan_id'];
    $namajurusan=strip_tags($_POST['nama_jurusan']);

    $sql="CALL update_jurusan('$idjurusan','$namajurusan')";

    if(mysqli_query($koneksi,$sql)) {
        echo '<script>alert("Data telah diedit");</script>
        <meta http-equiv="refresh" content="0, jurusan.php">';
    } else {
        echo '<script>alert("Gagal mengedit data");</script>
        <meta http-equiv="refresh" content="0, jurusan.php">';
    }
}