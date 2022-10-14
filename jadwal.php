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
                <li><a href="jadwal.php" class="aktif">Jadwal</a></li>
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
        <?php
                if($_SESSION['akses'] != 'admin') {
                    echo "<h1 align='center'>Maaf Akses Ditolak</h1>";
                } else {

            ?>
            <p>&nbsp; <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambahjadwal">+ Tambah Jadwal</button></p>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    Cari : <br>
                    <input type="text" name="cari_data" placeholder="Masukkan data yang dicari..." class="form-control" style="width:85%; float:left;" required>&nbsp;<button class="btn btn-primary" type="submit" name="cari">Cari</button>
                </form>
            <p>&nbsp;
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th colspan="5" style="text-align:center; font-size: 1.5em;">PENJADWALAN</th>
                        </tr>
                        <tr>
                            <th>NO</th>
                            <th>KELAS</th>
                            <th>JADWAL</th>
                            <th>RUANG</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include "koneksi.php";
                            if(!isset($_POST['cari'])) {
                                $sql=mysqli_query($koneksi,"CALL tampil_jadwal()");
                                $no=1;
                                while($row=mysqli_fetch_array($sql)) {
                                    $hari=$row['jadwal_hari'];
                                    echo "<tr>
                                        <td>".
                                        $no++
                                        ."</td>
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
                                        echo "<td>$row[ruang]</td>
                                        <td>
                                        <button class='btn btn-info' type='button' title='Edit jadwal $row[kelas_nama]' data-bs-toggle='modal' data-bs-target='#edit$row[jadwal_id]'>Edit</button>
                                        <button class='btn btn-warning' type='button' title='Hapus jadwal $row[kelas_nama]' data-bs-toggle='modal' data-bs-target='#hapus$row[jadwal_id]'>Hapus</button>
                                        </td>
                                    </tr>
                                    <div class='modal fade' id='edit$row[jadwal_id]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Edit Jadwal $row[kelas_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='update_jadwal.php'>
                                <input type='hidden' name='jadwal_id' value='$row[jadwal_id]'>
                                Kelas : <select name='kelas_id' class='form-control' required>
                                    <option selected>$row[kelas_id]-$row[kelas_nama]</option>";
                                    include "koneksi.php";
                                    $sqlkelas=mysqli_query($koneksi,"CALL kelas_untuk_jadwal()");
                                    while($rowkelas=mysqli_fetch_array($sqlkelas)) {
                                        echo "<option>$rowkelas[kelas_id]-$rowkelas[kelas_nama]</option>";
                                    }
                                echo "</select>
                                Hari : <select name='jadwal_hari' class='form-control' required>";
                                    if($row[jadwal_hari] == '0') {
                                        echo "<option selected>$row[jadwal_hari]-SENIN</option>";
                                    } else if($row[jadwal_hari] == '1') {
                                        echo "<option selected>$row[jadwal_hari]-SELASA</option>";
                                    } else if($row[jadwal_hari] == '2') {
                                        echo "<option selected>$row[jadwal_hari]-RABU</option>";
                                    } else if($row[jadwal_hari] == '3') {
                                        echo "<option selected>$row[jadwal_hari]-KAMIS</option>";
                                    } else if($row[jadwal_hari] == '4') {
                                        echo "<option selected>$row[jadwal_hari]-JUMAT</option>";
                                    } else if($row[jadwal_hari] == '5') {
                                        echo "<option selected>$row[jadwal_hari]-SABTU</option>";
                                    }
                                echo "<option>0-SENIN</option>
                                <option>1-SELASA</option>
                                <option>2-RABU</option>
                                <option>3-KAMIS</option>
                                <option>4-JUMAT</option>
                                <option>5-SABTU</option>
                            </select>
                            Ruang : <select name='ruang' class='form-control' required>
                            <option selected>$row[ruang]</option>
                                <option>LAB RPL</option>
                                <option>LAB TKJ 1</option>
                                <option>LAB TKJ 2</option>
                                <option>LAB TKJ 3</option>
                                <option>LAB MM</option>
                            </select>
                                <br>
                                <button type='submit' class='btn btn-success'>Perbarui</button>
                                <button type='reset' class='btn btn-default' data-bs-dismiss='modal'>Batal</button>
                            </form>
                        </div>
                        <div class='modal-footer'>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class='modal fade' id='hapus$row[jadwal_id]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Hapus Jadwal $row[kelas_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='hapus_jadwal.php'>
                                <input type='hidden' name='jadwal_id' value='$row[jadwal_id]'>
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
                            } else {
                                $caridata=$_POST['cari_data'];
                                $sql=mysqli_query($koneksi,"CALL cari_jadwal('%$caridata%')");
                                $no=1;
                                while($row=mysqli_fetch_array($sql)) {
                                    $hari=$row['jadwal_hari'];
                                    echo "<tr>
                                        <td>".
                                        $no++
                                        ."</td>
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
                                        echo "<td>$row[ruang]</td>
                                        <td>
                                        <button class='btn btn-info' type='button' title='Edit jadwal $row[kelas_nama]' data-bs-toggle='modal' data-bs-target='#edit$row[jadwal_id]'>Edit</button>
                                        <button class='btn btn-warning' type='button' title='Hapus jadwal $row[kelas_nama]' data-bs-toggle='modal' data-bs-target='#hapus$row[jadwal_id]'>Hapus</button>
                                        </td>
                                    </tr>
                                    <div class='modal fade' id='edit$row[jadwal_id]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Edit Jadwal $row[kelas_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='update_jadwal.php'>
                                <input type='hidden' name='jadwal_id' value='$row[jadwal_id]'>
                                Kelas : <select name='kelas_id' class='form-control' required>
                                    <option selected>$row[kelas_id]-$row[kelas_nama]</option>";
                                    include "koneksi.php";
                                    $sqlkelas=mysqli_query($koneksi,"CALL kelas_untuk_jadwal()");
                                    while($rowkelas=mysqli_fetch_array($sqlkelas)) {
                                        echo "<option>$rowkelas[kelas_id]-$rowkelas[kelas_nama]</option>";
                                    }
                                echo "</select>
                                Hari : <select name='jadwal_hari' class='form-control' required>";
                                if($row[jadwal_hari] == '0') {
                                    echo "<option selected>$row[jadwal_hari]-SENIN</option>";
                                } else if($row[jadwal_hari] == '1') {
                                    echo "<option selected>$row[jadwal_hari]-SELASA</option>";
                                } else if($row[jadwal_hari] == '2') {
                                    echo "<option selected>$row[jadwal_hari]-RABU</option>";
                                } else if($row[jadwal_hari] == '3') {
                                    echo "<option selected>$row[jadwal_hari]-KAMIS</option>";
                                } else if($row[jadwal_hari] == '4') {
                                    echo "<option selected>$row[jadwal_hari]-JUMAT</option>";
                                } else if($row[jadwal_hari] == '5') {
                                    echo "<option selected>$row[jadwal_hari]-SABTU</option>";
                                }
                                echo "<option>0-SENIN</option>
                                <option>1-SELASA</option>
                                <option>2-RABU</option>
                                <option>3-KAMIS</option>
                                <option>4-JUMAT</option>
                                <option>5-SABTU</option>
                            </select>
                            Ruang : <select name='ruang' class='form-control' required>
                            <option selected>$row[ruang]</option>
                                <option>LAB RPL</option>
                                <option>LAB TKJ 1</option>
                                <option>LAB TKJ 2</option>
                                <option>LAB TKJ 3</option>
                                <option>LAB MM</option>
                            </select>
                                <br>
                                <button type='submit' class='btn btn-success'>Perbarui</button>
                                <button type='reset' class='btn btn-default' data-bs-dismiss='modal'>Batal</button>
                            </form>
                        </div>
                        <div class='modal-footer'>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class='modal fade' id='hapus$row[jadwal_id]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Hapus Jadwal $row[kelas_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='hapus_jadwal.php'>
                                <input type='hidden' name='jadwal_id' value='$row[jadwal_id]'>
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
                            }
                        ?>
                    </tbody>
                </table>
            </p>
            <div class="modal fade" id="tambahjadwal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Tambah Jadwal</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">&nbsp;</button>
                        </div>
                        <div class="modal-body">
                        <form method='post' action='simpan_jadwal.php'>
                                Kelas : <select name='kelas_id' class='form-control' required>
                                    <?php
                                    include "koneksi.php";
                                    $sqlkelas=mysqli_query($koneksi,"CALL kelas_untuk_jadwal()");
                                    while($rowkelas=mysqli_fetch_array($sqlkelas)) {
                                        echo "<option>$rowkelas[kelas_id]-$rowkelas[kelas_nama]</option>";
                                    }
                                    ?>
                               </select>
                                Hari : <select name='jadwal_hari' class='form-control' required>
                                <option>0-SENIN</option>
                                <option>1-SELASA</option>
                                <option>2-RABU</option>
                                <option>3-KAMIS</option>
                                <option>4-JUMAT</option>
                                <option>5-SABTU</option>
                            </select>
                            Ruang : <select name='ruang' class='form-control' required>
                                <option>LAB RPL</option>
                                <option>LAB TKJ 1</option>
                                <option>LAB TKJ 2</option>
                                <option>LAB TKJ 3</option>
                                <option>LAB MM</option>
                            </select>
                                <br>
                                <button type='submit' class='btn btn-success'>Tambahkan</button>
                                <button type='reset' class='btn btn-default' data-bs-dismiss='modal'>Batal</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
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