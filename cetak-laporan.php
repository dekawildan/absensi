<?php
    include "cek-sesi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
</head>
<body onload="javascript:window.print()">
    <h3 align="center">LAPORAN ABSENSI SISWA</h3>
    <h3 align="center">SMK BHAKTI NUSANTARA BOJA</h3>
    <table style="border:1px solid black;" align="center" width="90%" cellpadding="5" cellspacing="0">
                    <thead>
                        <tr style="border:1px solid black;">
                            <th style="border:1px solid black;">NO</th>
                            <th style="border:1px solid black;">NIS</th>
                            <th style="border:1px solid black;">NAMA SISWA</th>
                            <th style="border:1px solid black;">KELAS</th>
                            <th style="border:1px solid black;">HARI</th>
                            <th style="border:1px solid black;">TANGGAL ABSEN</th>
                            <th style="border:1px solid black;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include "koneksi.php";
                            if(!empty($_GET['bulan']) && !empty($_GET['kelas'])) {
                                $laporan=mysqli_query($koneksi,"CALL laporan_cetak('$_GET[bulan]','$_GET[kelas]')");
                                $no=1;
                                while($cetak=mysqli_fetch_assoc($laporan)) {    
                                    if($_GET['bulan'] == $cetak['bulan'] && $_GET['kelas'] == $cetak['kelas_nama']) {
                                        include "koneksi.php";
                                            $hari=$cetak['jadwal_hari'];
                                            echo "<tr style='border:1px solid black;'>
                                            <td style='border:1px solid black;'>".
                                            $no++
                                            ."</td>
                                            <td style='border:1px solid black;'>$cetak[siswa_nis]</td>
                                            <td style='border:1px solid black;'>$cetak[siswa_nama]</td>
                                            <td style='border:1px solid black;'>$cetak[kelas_nama]</td>";
                                        if($hari == '0') {
                                            echo "<td style='border:1px solid black;'>SENIN</td>";
                                        } else if($hari == '1') {
                                            echo "<td style='border:1px solid black;'>SELASA</td>";
                                        } else if($hari == '2') {
                                            echo "<td style='border:1px solid black;'>RABU</td>";
                                        } else if($hari == '3') {
                                            echo "<td style='border:1px solid black;'>KAMIS</td>";
                                        } else if($hari == '4') {
                                            echo "<td style='border:1px solid black;'>JUMAT</td>";
                                        } else if($hari == '5') {
                                            echo "<td style='border:1px solid black;'>SABTU</td>";
                                        }
                                            echo "<td style='border:1px solid black;'>$cetak[tgl_absen] $cetak[waktu]</td>
                                            <td style='border:1px solid black;'>$cetak[absen_status]</td>
                                            </tr>
                                            ";
                                    }
                                }
                            } else  if(!empty($_GET['tanggal']) && !empty($_GET['kelas'])) {
                                include "koneksi.php";
                                $laporan2=mysqli_query($koneksi,"CALL filter_laporan_harian('$_GET[tanggal]','$_GET[kelas]')");
                                $no=1;
                                while($cetak=mysqli_fetch_assoc($laporan2)) {    
                                    if($_GET['tanggal'] == $cetak['tgl_absen'] && $_GET['kelas'] == $cetak['kelas_nama']) {
                                        include "koneksi.php";
                                        $hari=$cetak['jadwal_hari'];
                                        echo "<tr style='border:1px solid black;'>
                                        <td style='border:1px solid black;'>".
                                        $no++
                                        ."</td>
                                        <td style='border:1px solid black;'>$cetak[siswa_nis]</td>
                                        <td style='border:1px solid black;'>$cetak[siswa_nama]</td>
                                        <td style='border:1px solid black;'>$cetak[kelas_nama]</td>";
                                    if($hari == '0') {
                                        echo "<td style='border:1px solid black;'>SENIN</td>";
                                    } else if($hari == '1') {
                                        echo "<td style='border:1px solid black;'>SELASA</td>";
                                    } else if($hari == '2') {
                                        echo "<td style='border:1px solid black;'>RABU</td>";
                                    } else if($hari == '3') {
                                        echo "<td style='border:1px solid black;'>KAMIS</td>";
                                    } else if($hari == '4') {
                                        echo "<td style='border:1px solid black;'>JUMAT</td>";
                                    } else if($hari == '5') {
                                        echo "<td style='border:1px solid black;'>SABTU</td>";
                                    }
                                        echo "<td style='border:1px solid black;'>$cetak[tgl_absen] $cetak[waktu]</td>
                                            <td style='border:1px solid black;'>$cetak[absen_status]</td>
                                            </tr>
                                            ";
                                    }
                                }
                            }
                        ?>
                    </tbody>
    </table>
</body>
</html>