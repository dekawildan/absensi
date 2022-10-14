<?php
if(empty($_POST['nama_kelas']) || empty($_POST['tingkat'])) {
    echo '<script>alert("Maaf kolom wajib diisi");</script>
    <meta http-equiv="refresh" content="0, kelas.php">';
} else {
    include "koneksi.php";
    $namakelas=strip_tags($_POST['nama_kelas']);
    $tingkat=strip_tags($_POST['tingkat']);
    $jurusan=explode("-",$_POST['jurusan_id']);
    $idjurusan=$jurusan[0];

    $sql="CALL tambah_kelas('$namakelas','$tingkat','$idjurusan')";

    if(mysqli_query($koneksi,$sql)) {
        echo '<script>alert("Data telah ditambahkan");</script>
        <meta http-equiv="refresh" content="0, kelas.php">';
    } else {
        echo '<script>alert("Gagal menambahkan data");</script>
        <meta http-equiv="refresh" content="0, kelas.php">';
    }
}