<?php
if(empty($_POST['siswa_nis'])) {
    echo '<script>alert("Maaf kolom wajib diisi");</script>
    <meta http-equiv="refresh" content="0, siswa.php">';
} else {
    include "koneksi.php";
    $nis=strip_tags($_POST['siswa_nis']);

    $sql="CALL hapus_siswa('$nis')";

    if(mysqli_query($koneksi,$sql)) {
        echo '<script>alert("Data telah dihapus");</script>
        <meta http-equiv="refresh" content="0, siswa.php">';
    } else {
        echo '<script>alert("Gagal menghapus data");</script>
        <meta http-equiv="refresh" content="0, siswa.php">';
    }
}