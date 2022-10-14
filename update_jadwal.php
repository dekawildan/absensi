<?php
if(empty($_POST['kelas_id']) || empty($_POST['jadwal_hari']) || empty($_POST['ruang']) || empty($_POST['jadwal_id'])) {
    echo '<script>alert("Maaf kolom wajib diisi");</script>
    <meta http-equiv="refresh" content="0, jadwal.php">';
} else {
    include "koneksi.php";
    $idjadwal=strip_tags($_POST['jadwal_id']);
    $kelas=explode("-",$_POST['kelas_id']);
    $idkelas=$kelas[0];
    $pecahhari=explode("-",strip_tags($_POST['jadwal_hari']));
    $hari=$pecahhari[0];
    $ruang=strip_tags($_POST['ruang']);

    $sql="CALL update_jadwal('$idjadwal','$idkelas','$hari','$ruang')";

    if(mysqli_query($koneksi,$sql)) {
        echo '<script>alert("Data telah diedit");</script>
        <meta http-equiv="refresh" content="0, jadwal.php">';
    } else {
        echo '<script>alert("Gagal mengedit data");</script>
        <meta http-equiv="refresh" content="0, jadwal.php">';
    }
}