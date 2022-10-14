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
                <li><a href="index.php" class="aktif">Dashboard</a></li>
                <li><a href="jurusan.php">Jurusan</a></li>
                <li><a href="kelas.php">Kelas</a></li>
                <li><a href="jadwal.php">Jadwal</a></li>
                <li><a href="siswa.php">Siswa</a></li>
                <li><a href="absen-masuk.php">Absen Masuk</a></li>
                <li><a href="absen-pulang.php">Absen Pulang</a></li>
                <li><a href="laporan.php">Laporan</a></li>
                <li><a href="logout.php">Keluar</a></li>
            </ul>
        </nav>
    </aside>

    <!--Artikel untuk konten-->
    <article id="article">
        <section>
            <div class="petugas">
                <?php
                    include "koneksi.php";
                    $totaljurusan=mysqli_query($koneksi,"CALL tampil_jurusan()");
                    $hitungjurusan=mysqli_num_rows($totaljurusan);
                    echo "<h3>Total Jurusan : </h3><h2>$hitungjurusan</h2>";
                ?>
            </div>
            <div class="pelanggan">
                <?php
                    include "koneksi.php";
                    $totalkelas=mysqli_query($koneksi,"CALL tampil_kelas()");
                    $hitungkelas=mysqli_num_rows($totalkelas);
                    echo "<h3>Total Kelas : </h3><h2>$hitungkelas</h2>";
                ?>
            </div>
            <div class="obat">
                <?php
                    include "koneksi.php";
                    $totalsiswa=mysqli_query($koneksi,"CALL tampil_siswa()");
                    $hitungsiswa=mysqli_num_rows($totalsiswa);
                    echo "<h3>Total Siswa : </h3><h2>$hitungsiswa</h2>";
                ?>
            </div>
            <div class="jadwal">
                <?php
                    include "koneksi.php";
                    $totaljadwal=mysqli_query($koneksi,"CALL tampil_jadwal()");
                    $hitungjadwal=mysqli_num_rows($totaljadwal);
                    echo "<h3>Total Jadwal : </h3><h2>$hitungjadwal</h2>";
                ?>
            </div>
            <div class="transaksi">
                <?php
                    include "koneksi.php";
                    $totalabsenmasuk=mysqli_query($koneksi,"CALL tampil_absen_masuk()");
                    $hitungabsenmasuk=mysqli_num_rows($totalabsenmasuk);
                    echo "<h3>Total Absen Masuk Hari Ini : </h3><h2>$hitungabsenmasuk</h2>";
                ?>
            </div>
            <div class="mapel">
                <?php
                    include "koneksi.php";
                    $totalabsenpulang=mysqli_query($koneksi,"CALL tampil_absen_pulang()");
                    $hitungabsenpulang=mysqli_num_rows($totalabsenpulang);
                    echo "<h3>Total Absen Pulang Hari Ini : </h3><h2>$hitungabsenpulang</h2>";
                ?>
            </div>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </section>
    </article>

    <!--Footer berisi pembuat atau tim pengembang-->
    <footer>
        <p style="text-align: center;">Copyright &copy; <?php echo date('Y'); ?> Barokah Jaya Rizki All Reserved</p>
    </footer>


    <script>
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