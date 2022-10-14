<?php
include "cek-sesi.php";
if($_SESSION['akses'] != 'admin') {
    echo '<script>alert("Maaf anda bukan admin");</script>
    <meta http-equiv="refresh" content="0, absen-masuk.php">';
} else {
    if(empty($_POST['absen_id'])) {
        echo '<script>alert("Maaf kolom wajib diisi");</script>
        <meta http-equiv="refresh" content="0, absen-masuk.php">';
    } else {
        include "koneksi.php";
        $idabsen=strip_tags($_POST['absen_id']);
    
        $sql="CALL hapus_absen('$idabsen')";
    
        if(mysqli_query($koneksi,$sql)) {
            echo '<script>alert("Data telah dihapus");</script>
            <meta http-equiv="refresh" content="0, absen-masuk.php">';
        } else {
            echo '<script>alert("Gagal menghapus data");</script>
            <meta http-equiv="refresh" content="0, absen-masuk.php">';
        }
    }
}