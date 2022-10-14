<?php
if(empty($_POST['jurusan_id'])) {
    echo '<script>alert("Maaf kolom wajib diisi");</script>
    <meta http-equiv="refresh" content="0, jurusan.php">';
} else {
    include "koneksi.php";
    $idjurusan=$_POST['jurusan_id'];
    $sql="CALL hapus_jurusan('$idjurusan')";
    if(mysqli_query($koneksi,$sql)) {
        echo '<script>alert("Data telah dihapus");</script>
        <meta http-equiv="refresh" content="0, jurusan.php">';
    } else {
        echo '<script>alert("Gagal menghapus data");</script>
        <meta http-equiv="refresh" content="0, jurusan.php">';
    }
}