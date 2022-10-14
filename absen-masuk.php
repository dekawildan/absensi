<?php
 include "cek-sesi.php";
 date_default_timezone_set('Asia/Jakarta');
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
                <li><a href="absen-masuk.php" class="aktif">Absen Masuk</a></li>
                <li><a href="absen-pulang.php">Absen Pulang</a></li>
                <li><a href="laporan.php">Laporan</a></li>
                <li><a href="logout.php">Keluar</a></li>
            </ul>
        </nav>
    </aside>

    <!--Artikel untuk konten-->
    <article id="article">
        <section>
                <div style="float:right; margin: 5px 0 10px 0; padding: 0 0 0 80%; display:inline-block; width: 100%; text-align:left;">
                    <?php
                        $tanggal=date('d-m-Y');
                        $hr=date('D');
                        echo "Tanggal : $tanggal<br>";
                        switch ($hr) {
                            case "Sun":
                                $hari="Minggu";
                                echo "Hari : Minggu, ";
                                break;
                            case "Mon":
                                $hari="Senin";
                                echo "Hari : Senin, ";
                                break;
                            case "Tue":
                                $hari="Selasa";
                                echo "Hari : Selasa, ";
                                break;
                            case "Wed":
                                $hari="Rabu";
                                echo "Hari : Rabu, ";
                                break;
                            case "Thu":
                                $hari="Kamis";
                                echo "Hari : Kamis, ";
                                break;
                            case "Fri":
                                $hari="Jumat";
                                echo "Hari : Jumat, ";
                                break;
                            case "Sat":
                                $hari="Sabtu";
                                echo "Hari : Sabtu, ";
                                break;
                        }
                        echo "
                        <span id='jam'></span>
                        <script type='text/javascript'>
                        window.onload = function() { jam(); }
                       
                        function jam() {
                         var e = document.getElementById('jam'),
                         d = new Date(), h, m, s;
                         h = d.getHours();
                         m = set(d.getMinutes());
                         s = set(d.getSeconds());
                       
                         e.innerHTML = h +':'+ m +':'+ s;
                       
                         setTimeout('jam()', 1000);
                        }
                       
                        function set(e) {
                         e = e < 10 ? '0'+ e : e;
                         return e;
                        }
                       </script>";
                    ?>
                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    Absen : <br>
                    <input type="text" name="cari_data" placeholder="Masukkan NIS..." class="form-control" style="width:85%; float:left;" autofocus required>&nbsp;<button class="btn btn-primary" type="submit" name="cari">Absen</button>
                </form>
                <p>&nbsp;
                    <?php
                        include "koneksi.php";
                        if(isset($_POST['cari'])) {
                            $caridata=strip_tags($_POST['cari_data']);
                            $sqlcarisiswa=mysqli_query($koneksi, "CALL siswa_absen('$caridata')");
                            while($cek=mysqli_fetch_array($sqlcarisiswa)) {
                                include "koneksi.php";
                                $cekjumlah=mysqli_query($koneksi, "CALL siswa_absen('$caridata')");
                                if(mysqli_num_rows($cekjumlah) < 1) {
                                    echo "<div class='alert alert-warning'>Maaf data siswa tidak ditemukan atau siswa tidak ada dalam jadwal hari ini</div>";
                                } else {
                                    $waktu=date('H:i:s');
                                    if($waktu>='08:00:00') {
                                        include "koneksi.php";
                                        $tglskr=date('Y-m-d');
                                        $tgl=date('D');
                                        $nis=$cek['siswa_nis'];
                                        $status="Terlambat";
                                        $sqlcek=mysqli_query($koneksi, "CALL cek_absen('$nis','$tglskr')");
                                        if(mysqli_num_rows($sqlcek) > 0) {
                                            echo "<div class='alert alert-danger' data-bs-dismiss='alert'>
                                            Maaf, nis sudah absen hari ini
                                            <button class='btn btn-close close' data-bs-dismiss='alert'></button>
                                            </div>";
                                        } else {
                                            echo "<p>
                                            NIS : $cek[siswa_nis]<br>
                                            Nama Siswa : $cek[siswa_nama]<br>
                                            Hari : ";
                                            switch ($tgl) {
                                                case "Sun":
                                                    echo "Minggu";
                                                    break;
                                                case "Mon":
                                                    echo "Senin";
                                                    break;
                                                case "Tue":
                                                    echo "Selasa";
                                                    break;
                                                case "Wed":
                                                    echo "Rabu";
                                                    break;
                                                case "Thu":
                                                    echo "Kamis";
                                                    break;
                                                case "Fri":
                                                    echo "Jumat";
                                                    break;
                                                case "Sat":
                                                    echo "Sabtu";
                                                    break;
                                            }
                                            echo "<br>
                                            Tanggal Absen : $tglskr <br>
                                            Status : $status<br>
                                            </p>";
                                            include "koneksi.php";
                                            $sqlsimpan="CALL tambah_absensi('$nis','$tglskr','$waktu','$status')";
                                            if(mysqli_query($koneksi,$sqlsimpan)) {
                                                echo "<div style='width:95%;' class='alert alert-success' data-bs-dismiss='alert'>Absen berhasil disimpan
                                                <button class='btn btn-close close' data-bs-dismiss='alert'></button>
                                                </div>";
                                            } else {
                                                echo "<div style='width:95%;' class='alert alert-danger' data-bs-dismiss='alert'>Absen gagal disimpan, mungkin nis sudah absen
                                                <button class='btn btn-close close' data-bs-dismiss='alert'></button>
                                                </div>";
                                            }
                                        }
                                    } else {
                                        include "koneksi.php";
                                        $tglskr=date('Y-m-d');
                                        $tgl=date('D');
                                        $nis=$cek['siswa_nis'];
                                        $status="Hadir";
                                        $sqlcek=mysqli_query($koneksi, "CALL cek_absen('$nis','$tglskr')");
                                        if(mysqli_num_rows($sqlcek) > 0) {
                                            echo "<div class='alert alert-danger' data-bs-dismiss='alert'>
                                            Maaf, nis sudah absen hari ini
                                            <button class='btn btn-close close' data-bs-dismiss='alert'></button>
                                            </div>";
                                        } else {
                                            echo "<p>
                                            NIS : $cek[siswa_nis]<br>
                                            Nama Siswa : $cek[siswa_nama]<br>
                                            Hari : ";
                                            switch ($tgl) {
                                                case "Sun":
                                                    $hari="Minggu";
                                                    echo "Minggu";
                                                    break;
                                                case "Mon":
                                                    $hari="Senin";
                                                    echo "Senin";
                                                    break;
                                                case "Tue":
                                                    $hari="Selasa";
                                                    echo "Selasa";
                                                    break;
                                                case "Wed":
                                                    $hari="Rabu";
                                                    echo "Rabu";
                                                    break;
                                                case "Thu":
                                                    $hari="Kamis";
                                                    echo "Kamis";
                                                    break;
                                                case "Fri":
                                                    $hari="Jumat";
                                                    echo "Jumat";
                                                    break;
                                                case "Sat":
                                                    $hari="Sabtu";
                                                    echo "Sabtu";
                                                    break;
                                            }
                                            echo "<br>
                                            Tanggal Absen : $tglskr <br>
                                            Status : $status<br>
                                            </p>";
                                            include "koneksi.php";
                                            $sqlsimpan="CALL tambah_absensi('$nis','$tglskr','$waktu','$status')";
                                            if(mysqli_query($koneksi,$sqlsimpan)) {
                                                echo "<div style='width:95%;' class='alert alert-success' data-bs-dismiss='alert'>Absen berhasil disimpan
                                                <button class='btn btn-close close' data-bs-dismiss='alert'></button>
                                                </div>";
                                            } else {
                                                echo "<div style='width:95%;' class='alert alert-danger' data-bs-dismiss='alert'>Absen gagal disimpan, mungkin nis sudah absen
                                                <button class='btn btn-close close' data-bs-dismiss='alert'></button>
                                                </div>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    ?>
                </p>
            <p>&nbsp;
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th colspan="7" style="text-align:center; font-size: 1.5em;">DATA ABSENSI</th>
                        </tr>
                        <tr>
                            <th>NO</th>
                            <th>NIS</th>
                            <th>NAMA SISWA</th>
                            <th>HARI</th>
                            <th>TANGGAL ABSEN</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include "koneksi.php";
                                $sql=mysqli_query($koneksi,"CALL tampil_absen_masuk()");
                                $no=1;
                                while($row=mysqli_fetch_array($sql)) {
                                    $hari=$row['jadwal_hari'];
                                    echo "<tr>
                                        <td>".
                                        $no++
                                        ."</td>
                                        <td>$row[siswa_nis]</td>
                                        <td>$row[siswa_nama]</td>";
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
                                        <td>
                                        <button class='btn btn-warning' type='button' title='Hapus $row[siswa_nama]' data-bs-toggle='modal' data-bs-target='#hapus$row[absen_id]'>Hapus</button>
                                        </td>
                                    </tr>

            <div class='modal fade' id='hapus$row[absen_id]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Hapus Absen $row[siswa_nama] $row[tgl_absen]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='hapus_absen.php'>
                                <input type='hidden' name='absen_id' value='$row[absen_id]'>
                                Anda yakin menghapus data ini ? <br>
                                <button type='submit' class='btn btn-danger'>Ya</button>
                                <button type='reset' class='btn btn-default' data-bs-dismiss='modal'>Batal</button>
                            </form>
                        </div>
                        <div class='modal-footer'>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
                                    ";
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

    <!-- Library Javascript -->
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>