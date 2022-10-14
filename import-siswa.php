<?php
 include "cek-sesi.php";

 if(empty($_FILES['import_siswa'])) {
    echo '<script>
        alert("Maaf form masih kosong");
    </script>
    <meta http-equiv="refresh" content="0, siswa.php">';
 } else {
    include "excel_reader2.php";

    $file=basename($_FILES['import_siswa']['name']);
    //$folder='import/';
    //$proses=$folder.$file;
    move_uploaded_file($_FILES['import_siswa']['tmp_name'], $file);
    chmod($_FILES['import_siswa']['name'],0777);

    $data=new Spreadsheet_Excel_Reader($_FILES['import_siswa']['name'], false);
    $baris=$data->rowcount($sheet_index=0);
    $berhasil=0;
    for($i=2;$i<=$baris;$i++) {
        $nis=$data->val($i,1);
        $nama=$data->val($i,2);
        $jenis=$data->val($i,3);
        $tempatlahir=$data->val($i,4);
        $tgllahir=$data->val($i,5);
        
        if(!empty($nis) || !empty($nama) || !empty($jenis) || !empty($tempatlahir) || !empty($tgllahir) || !empty($jurusan) || !empty($kelas)) {
            include "koneksi.php";
            if(mysqli_query($koneksi,"CALL tambah_siswa('$nis','$nama','$jenis','$tempatlahir','$tgllahir')")) {
                $berhasil++;
                echo '<script>alert("Data siswa berhasil diimpor");</script>
                <meta http-equiv="refresh" content="0, siswa.php">';
            } else {
                echo '<script>alert("Data siswa gagal diimpor");</script>
                <meta http-equiv="refresh" content="0, siswa.php">';
            }
        } else {
            echo '<script>alert("File excel ada yang kosong");</script>
                <meta http-equiv="refresh" content="0, siswa.php">';
            break;
        }
    }
    unlink($_FILES['import_siswa']['name']);
    //header('location:siswa.php');
 }
?>