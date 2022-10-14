<?php
if(empty($_POST['siswa_nis']) || empty($_POST['nama_siswa']) || empty($_POST['jenis']) || empty($_POST['tempat_lahir']) || empty($_POST['tgl_lahir'])) {
    echo '<script>alert("Maaf kolom wajib diisi");</script>
    <meta http-equiv="refresh" content="0, siswa.php">';
} else {
    include "koneksi.php";
    $idsiswa=strip_tags($_POST['siswa_id']);
    $nis=strip_tags($_POST['siswa_nis']);
    $namasiswa=strip_tags($_POST['nama_siswa']);
    $jenis=strip_tags($_POST['jenis']);
    $tempatlahir=strip_tags($_POST['tempat_lahir']);
    $tgllahir=strip_tags($_POST['tgl_lahir']);

    $sql="CALL update_siswa('$idsiswa','$nis','$namasiswa','$jenis','$tempatlahir','$tgllahir')";

    if(mysqli_query($koneksi,$sql)) {
        echo '<script>alert("Data telah diedit");</script>
        <meta http-equiv="refresh" content="0, siswa.php">';
    } else {
        echo '<script>alert("NIS sudah terdaftar, silahkan ganti NIS");</script>
        <meta http-equiv="refresh" content="0, siswa.php">';
    }
}