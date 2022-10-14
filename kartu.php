<?php
 include "cek-sesi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pelajar</title>

    <style>
        body {
            text-align: center;
        }
        .body {
            width: 400px;
            margin: 1% 25% 10% 25%;
            padding: 5px;
            float: left;
            background: linear-gradient(purple, red);
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            color: white;
        }
        .body h3 {
            margin: 0;
            padding: 5px;
        }
        .body h4 {
            margin: 0;
            padding: 5px;
        }
        .konten {
            background-color: rgb(214, 227, 252);
            margin: 0;
            padding: 5px 5px 20px 5px;
            float: left;
            width: 97%;
            text-align: left;
            color: darkblue;
        }

        .body img {
            width: 70px;
            height: 60px;
            float: left;
        }

        .gambar {
            width: 60% !important;
            height: 80px !important;
        }

    </style>
</head>
<body onload="javascript:window.print()">
    <div class="body">
        <img src="kendal.png">
        <h3>KARTU PELAJAR</h3>
        <h4>SMK BHAKTI NUSANTARA BOJA</h4>
        <div class="konten">
            <?php
                include "koneksi.php";
                $sqlsiswa=mysqli_query($koneksi,"CALL tampil_siswa()");
                while($siswa=mysqli_fetch_array($sqlsiswa)) {
                    if(!empty($_GET['cetak'])) {
                        if($_GET['cetak'] == $siswa['siswa_nis']) {
                            echo "<table width='100%'>
                                <tr>
                                    <td>NIS</td>
                                    <td>: $siswa[siswa_nis]</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>: $siswa[siswa_nama]</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>: $siswa[siswa_jenis]</td>
                                </tr>
                                <tr>
                                    <td>TTL</td>
                                    <td>: $siswa[siswa_tempat_lahir], $siswa[siswa_tgl_lahir]</td>
                                </tr>
                                <tr>
                                    <td colspan='2'>
                                    <img src='barcode.php?text=$siswa[siswa_nis]&print=true&size=40&codetype=code128' class='gambar' />
                                    </td>
                                </tr>
                            </table>";
                        }
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>