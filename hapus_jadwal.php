<?php
if(empty($_POST['jadwal_id'])) {
    echo '<script>alert("Maaf kolom wajib diisi");</script>
    <meta http-equiv="refresh" content="0, jadwal.php">';
} else {
    include "koneksi.php";
    $idjadwal=$_POST['jadwal_id'];

    $sql="CALL hapus_jadwal('$idjadwal')";

    if(mysqli_query($koneksi,$sql)) {
        echo '<script>alert("Data telah dihapus");</script>
        <meta http-equiv="refresh" content="0, jadwal.php">';
    } else {
        echo '<script>alert("Gagal menghapus data");</script>
        <meta http-equiv="refresh" content="0, jadwal.php">';
    }
}