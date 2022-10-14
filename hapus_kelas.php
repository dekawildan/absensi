<?php
if(empty($_POST['kelas_id'])) {
    echo '<script>alert("Maaf kolom wajib diisi");</script>
    <meta http-equiv="refresh" content="0, kelas.php">';
} else {
    include "koneksi.php";
    $idkelas=$_POST['kelas_id'];

    $sql="CALL hapus_kelas('$idkelas')";

    if(mysqli_query($koneksi,$sql)) {
        echo '<script>alert("Data telah dihapus");</script>
        <meta http-equiv="refresh" content="0, kelas.php">';
    } else {
        echo '<script>alert("Gagal menghapus data");</script>
        <meta http-equiv="refresh" content="0, kelas.php">';
    }
}