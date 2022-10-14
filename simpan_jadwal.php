<?php
if(empty($_POST['kelas_id']) || empty($_POST['jadwal_hari']) || empty($_POST['ruang'])) {
    echo '<script>alert("Maaf kolom wajib diisi");</script>
    <meta http-equiv="refresh" content="0, jadwal.php">';
} else {
    include "koneksi.php";
    $kelas=explode("-",$_POST['kelas_id']);
    $idkelas=$kelas[0];
    $pecahhari=explode("-",strip_tags($_POST['jadwal_hari']));
    $hari=$pecahhari[0];
    $ruang=strip_tags($_POST['ruang']);

    $sql="CALL tambah_jadwal('$idkelas','$hari','$ruang')";

    if(mysqli_query($koneksi,$sql)) {
        echo '<script>alert("Data telah ditambahkan");</script>
        <meta http-equiv="refresh" content="0, jadwal.php">';
    } else {
        echo '<script>alert("Gagal menambahkan data");</script>
        <meta http-equiv="refresh" content="0, jadwal.php">';
    }
}