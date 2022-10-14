<?php
if(empty($_POST['kelas_id']) || empty($_POST['siswa_nis'])) {
    echo '<script>alert("Maaf kolom wajib diisi");</script>
    <meta http-equiv="refresh" content="0, kelas.php">';
} else {
    include "koneksi.php";
    $kelas=explode("-",$_POST['kelas_id']);
    $idkelas=$kelas[0];
    $siswa=explode("-",$_POST['siswa_nis']);
    $nissiswa=$siswa[0];

    $sql="CALL tambah_detail_kelas('$idkelas','$nissiswa')";

    if(mysqli_query($koneksi,$sql)) {
        echo '<script>alert("Anggota telah ditambahkan");</script>
        <meta http-equiv="refresh" content="0, kelas.php">';
    } else {
        echo '<script>alert("Siswa telah mempunyai kelas");</script>
        <meta http-equiv="refresh" content="0, kelas.php">';
    }
}