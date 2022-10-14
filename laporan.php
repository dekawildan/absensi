<?php
 include "cek-sesi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi</title>
    <link href="desain.css" rel="stylesheet">
    <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!--Header aplikasi-->
    <header>
        <div class="header1">
            <h3 style="text-align: center;">ADMIN</h3>
        </div>
        <div class="header2">
            <button type="button" class="ham" id="ham" onclick="sembunyi()">
                <div class="burger"></div>
                <div class="burger"></div>
                <div class="burger"></div>
            </button>
            <button type="button" class="ham" id="burger" onclick="tampil()" style="display: none;">
                <p style="margin: 0; padding: 0; font-weight: bolder; font-size: 12pt; color: white;">&times;</p>
            </button>
            <h3>SISTEM ABSENSI SISWA</h3>
            <div class="user">
            <h4><?php $pengguna=strtoupper($_SESSION['username']); echo "HALO, $pengguna"; ?></h4>
            </div>
        </div>
    </header>

    <!--Sidebar sebelah kiri-->
    <aside id="aside">
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="jurusan.php">Jurusan</a></li>
                <li><a href="kelas.php">Kelas</a></li>
                <li><a href="jadwal.php">Jadwal</a></li>
                <li><a href="siswa.php">Siswa</a></li>
                <li><a href="absen-masuk.php">Absen Masuk</a></li>
                <li><a href="absen-pulang.php">Absen Pulang</a></li>
                <li><a href="laporan.php" class="aktif">Laporan</a></li>
                <li><a href="logout.php">Keluar</a></li>
            </ul>
        </nav>
    </aside>

    <!--Artikel untuk konten-->
    <article id="article">
        <section>
            <a href="javascript:void(0)" id="harian" class="filter">Filter Harian</a>
            <div id="filterbulanan">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    Filter bulan: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Filter kelas :<br>
                    <select name="bulan" class="form-control" style="width:40%; float:left;" required>
                        <?php
                            for($a=01;$a<=12;$a++) {
                                echo "<option>$a</option>";
                            }
                        ?>
                    </select>
                    <select name="kelas" class="form-control" style="width:40%; float: left;">
                        <?php
                            include "koneksi.php";
                            $ambilkelas=mysqli_query($koneksi, "CALL tampil_kelas()");
                            while($getkelas=mysqli_fetch_array($ambilkelas)) {
                                echo "<option>$getkelas[kelas_nama]</option>";
                            }
                        ?>
                    </select>
                        &nbsp;<button class="btn btn-primary" type="submit" name="caribulan">Filter</button>
                </form>
            </div>

                <a href="javascript:void(0)" id="bulanan" class="filter" style="display:none;">Filter Bulanan</a>
                <div id="filterharian" style="display:none;">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    Filter Harian: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Filter kelas :<br>
                    <select name="tanggal" class="form-control" style="width:40%; float:left;" required>
                        <?php
                            include "koneksi.php";
                            $ambiltanggal=mysqli_query($koneksi, "CALL grup_absen()");
                            while($gettanggal=mysqli_fetch_array($ambiltanggal)) {
                                echo "<option>$gettanggal[tgl_absen]</option>";
                            }
                        ?>
                    </select>
                    <select name="kelas" class="form-control" style="width:40%; float: left;">
                        <?php
                            include "koneksi.php";
                            $ambilkelas=mysqli_query($koneksi, "CALL tampil_kelas()");
                            while($getkelas=mysqli_fetch_array($ambilkelas)) {
                                echo "<option>$getkelas[kelas_nama]</option>";
                            }
                        ?>
                    </select>
                        &nbsp;<button class="btn btn-primary" type="submit" name="carihari">Filter</button>
                </form>
                </div>
            <p>&nbsp;
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th colspan="7" style="text-align:center; font-size: 1.5em;">LAPORAN ABSENSI</th>
                        </tr>
                        <tr>
                            <th>NO</th>
                            <th>NIS</th>
                            <th>NAMA SISWA</th>
                            <th>KELAS</th>
                            <th>HARI</th>
                            <th>TANGGAL ABSEN</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include "koneksi.php";
                            if(isset($_POST['caribulan'])) {
                                $bulan=$_POST['bulan'];
                                $kelas=$_POST['kelas'];
                                echo "<tr>
                                    <td colspan='7' style='text-align:left;'>
                                        <a href='cetak-laporan.php?bulan=$bulan&kelas=$kelas' target='_blank'><button class='btn btn-success' type='button'>Cetak Laporan</button></a>
                                    </td>
                                </tr>";
                                $sql=mysqli_query($koneksi,"CALL filter_laporan('$bulan','$kelas')");
                                $no=1;
                                while($row=mysqli_fetch_array($sql)) {
                                    $hari=$row['jadwal_hari'];
                                    echo "<tr>
                                        <td>".
                                        $no++
                                        ."</td>
                                        <td>$row[siswa_nis]</td>
                                        <td>$row[siswa_nama]</td>
                                        <td>$row[kelas_nama]</td>";
                                        if($hari == '0') {
                                            echo "<td>SENIN</td>";
                                        } else if($hari == '1') {
                                            echo "<td>SELASA</td>";
                                        } else if($hari == '2') {
                                            echo "<td>RABU</td>";
                                        } else if($hari == '3') {
                                            echo "<td>KAMIS</td>";
                                        } else if($hari == '4') {
                                            echo "<td>JUMAT</td>";
                                        } else if($hari == '5') {
                                            echo "<td>SABTU</td>";
                                        }
                                        echo "<td>$row[tgl_absen] $row[waktu]</td>
                                        <td>$row[absen_status]</td>
                                    </tr>
                                    ";
                                }
                            } else if(isset($_POST['carihari'])) {
                                $tanggal=$_POST['tanggal'];
                                $kelas=$_POST['kelas'];
                                echo "<tr>
                                    <td colspan='7' style='text-align:left;'>
                                        <a href='cetak-laporan.php?tanggal=$tanggal&kelas=$kelas' target='_blank'><button class='btn btn-success' type='button'>Cetak Laporan</button></a>
                                    </td>
                                </tr>";
                                $sql=mysqli_query($koneksi,"CALL filter_laporan_harian('$tanggal','$kelas')");
                                $no=1;
                                while($row=mysqli_fetch_array($sql)) {
                                    $hari=$row['jadwal_hari'];
                                    echo "<tr>
                                        <td>".
                                        $no++
                                        ."</td>
                                        <td>$row[siswa_nis]</td>
                                        <td>$row[siswa_nama]</td>
                                        <td>$row[kelas_nama]</td>";
                                        if($hari == '0') {
                                            echo "<td>SENIN</td>";
                                        } else if($hari == '1') {
                                            echo "<td>SELASA</td>";
                                        } else if($hari == '2') {
                                            echo "<td>RABU</td>";
                                        } else if($hari == '3') {
                                            echo "<td>KAMIS</td>";
                                        } else if($hari == '4') {
                                            echo "<td>JUMAT</td>";
                                        } else if($hari == '5') {
                                            echo "<td>SABTU</td>";
                                        }
                                        echo "<td>$row[tgl_absen] $row[waktu]</td>
                                        <td>$row[absen_status]</td>
                                    </tr>
                                    ";
                                }
                            } else {
                                $sql=mysqli_query($koneksi,"CALL tampil_absen()");
                                $no=1;
                                while($row=mysqli_fetch_array($sql)) {
                                    $hari=$row['jadwal_hari'];
                                    echo "<tr>
                                        <td>".
                                        $no++
                                        ."</td>
                                        <td>$row[siswa_nis]</td>
                                        <td>$row[siswa_nama]</td>
                                        <td>$row[kelas_nama]</td>";
                                        if($hari == '0') {
                                            echo "<td>SENIN</td>";
                                        } else if($hari == '1') {
                                            echo "<td>SELASA</td>";
                                        } else if($hari == '2') {
                                            echo "<td>RABU</td>";
                                        } else if($hari == '3') {
                                            echo "<td>KAMIS</td>";
                                        } else if($hari == '4') {
                                            echo "<td>JUMAT</td>";
                                        } else if($hari == '5') {
                                            echo "<td>SABTU</td>";
                                        }
                                        echo "<td>$row[tgl_absen] $row[waktu]</td>
                                        <td>$row[absen_status]</td>
                                    </tr>
                                    ";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </p>
        </section>
    </article>

    <!--Footer berisi pembuat atau tim pengembang-->
    <footer>
        <p style="text-align: center;">Copyright &copy; <?php echo date('Y'); ?> Barokah Jaya Rizki All Reserved</p>
    </footer>

    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#harian").click(function() {
                $("#harian").hide("slow");
                $("#filterbulanan").hide("slow");
                $("#bulanan").show("slow");
                $("#filterharian").show("slow");
            });
            $("#bulanan").click(function() {
                $("#harian").show("slow");
                $("#filterbulanan").show("slow");
                $("#bulanan").hide("slow");
                $("#filterharian").hide("slow");
            });
        });
        function sembunyi() {
            document.getElementById("aside").style.display="none";
            document.getElementById("article").style.width="100%";
            document.getElementById("ham").style.display="none";
            document.getElementById("burger").style.display="block";
        }
        function tampil() {
            document.getElementById("aside").style.display="block";
            document.getElementById("article").style.width="80%";
            document.getElementById("ham").style.display="block";
            document.getElementById("burger").style.display="none";
        }
    </script>

</body>
</html>