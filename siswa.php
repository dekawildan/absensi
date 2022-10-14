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
    <link href="select2.min.css" rel="stylesheet">
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
                <li><a href="siswa.php" class="aktif">Siswa</a></li>
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
            <p>&nbsp; <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambahsiswa">+ Tambah Siswa</button> 
                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#importsiswa">Import Excel</button>
            </p>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    Cari : <br>
                    <input type="text" name="cari_data" placeholder="Masukkan data yang dicari..." class="form-control" style="width:85%; float:left;" required>&nbsp;<button class="btn btn-primary" type="submit" name="cari">Cari</button>
                </form>
            <p>&nbsp;
                <a href="kartu-all.php" target="_blank" class="btn btn-success">Generate Kartu</a>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th colspan="8" style="text-align:center; font-size: 1.5em;">DATA SISWA</th>
                        </tr>
                        <tr>
                            <th>NO</th>
                            <th>NIS</th>
                            <th>NAMA SISWA</th>
                            <th>JENIS</th>
                            <th>TTL</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include "koneksi.php";
                            if(!isset($_POST['cari'])) {
                                $sql=mysqli_query($koneksi,"CALL tampil_siswa()");
                                $no=1;
                                while($row=mysqli_fetch_array($sql)) {
                                    echo "<tr>
                                        <td>".
                                        $no++
                                        ."</td>
                                        <td>$row[siswa_nis]</td>
                                        <td>$row[siswa_nama]</td>
                                        <td>$row[siswa_jenis]</td>
                                        <td>$row[siswa_tempat_lahir], $row[siswa_tgl_lahir]</td>
                                        <td>
                                        <button class='btn btn-info' type='button' title='Edit $row[siswa_nama]' data-bs-toggle='modal' data-bs-target='#edit$row[siswa_nis]'>Edit</button>
                                        <button class='btn btn-warning' type='button' title='Hapus $row[siswa_nama]' data-bs-toggle='modal' data-bs-target='#hapus$row[siswa_nis]'>Hapus</button>
                                        <a href='kartu.php?cetak=$row[siswa_nis]' target='_blank' class='btn btn-success'>Cetak Kartu</a>
                                        </td>
                                    </tr>
                                    <div class='modal fade' id='edit$row[siswa_nis]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Edit Siswa $row[siswa_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='update_siswa.php'>
                                <input type='hidden' name='siswa_id' value='$row[siswa_id]'>
                                NIS : <input type='text' name='siswa_nis' class='form-control' value='$row[siswa_nis]'>
                                Nama Siswa : <input type='text' name='nama_siswa' value='$row[siswa_nama]' placeholder='Tambahkan data siswa...' class='form-control' required>
                                Jenis Kelamin : <select name='jenis' class='form-control' required>
                                    <option selected>$row[siswa_jenis]</option>
                                    <option>L</option>
                                    <option>P</option>
                                </select>
                                Tempat Lahir : <input type='text' name='tempat_lahir' value='$row[siswa_tempat_lahir]' placeholder='Tambahkan tempat lahir...' class='form-control' required>
                                Tanggal Lahir : <input type='date' name='tgl_lahir' value='$row[siswa_tgl_lahir]' class='form-control' required>
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

            <div class='modal fade' id='hapus$row[siswa_nis]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Hapus Siswa $row[siswa_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='hapus_siswa.php'>
                                <input type='hidden' name='siswa_nis' value='$row[siswa_nis]'>
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
                                $sql=mysqli_query($koneksi,"CALL cari_siswa('%$caridata%')");
                                $no=1;
                                while($row=mysqli_fetch_array($sql)) {
                                    echo "<tr>
                                        <td>".
                                        $no++
                                        ."</td>
                                        <td>$row[siswa_nis]</td>
                                        <td>$row[siswa_nama]</td>
                                        <td>$row[siswa_jenis]</td>
                                        <td>$row[siswa_tempat_lahir], $row[siswa_tgl_lahir]</td>
                                        <td>
                                        <button class='btn btn-info' type='button' title='Edit $row[siswa_nama]' data-bs-toggle='modal' data-bs-target='#edit$row[siswa_nis]'>Edit</button>
                                        <button class='btn btn-warning' type='button' title='Hapus $row[siswa_nama]' data-bs-toggle='modal' data-bs-target='#hapus$row[siswa_nis]'>Hapus</button>
                                        <a href='kartu.php?cetak=$row[siswa_nis]' target='_blank' class='btn btn-success'>Cetak Kartu</a>
                                        </td>
                                    </tr>
                                    <div class='modal fade' id='edit$row[siswa_nis]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Edit Siswa $row[siswa_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='update_siswa.php'>
                                <input type='hidden' name='siswa_id' value='$row[siswa_id]'>
                                NIS : <input type='text' name='siswa_nis' class='form-control' value='$row[siswa_nis]' disabled>
                                Nama Siswa : <input type='text' name='nama_siswa' value='$row[siswa_nama]' placeholder='Tambahkan data siswa...' class='form-control' required>
                                Jenis Kelamin : <select name='jenis' class='form-control' required>
                                    <option selected>$row[siswa_jenis]</option>
                                    <option>L</option>
                                    <option>P</option>
                                </select>
                                Tempat Lahir : <input type='text' name='tempat_lahir' value='$row[siswa_tempat_lahir]' placeholder='Tambahkan tempat lahir...' class='form-control' required>
                                Tanggal Lahir : <input type='date' name='tgl_lahir' value='$row[siswa_tgl_lahir]' class='form-control' required>
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

            <div class='modal fade' id='hapus$row[siswa_nis]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Hapus Siswa $row[siswa_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='hapus_siswa.php'>
                                <input type='hidden' name='siswa_nis' value='$row[siswa_nis]'>
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
            <div class="modal fade" id="tambahsiswa">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Tambah Siswa</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">&nbsp;</button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="simpan_siswa.php">
                                NIS : <input type="text" name="nis_siswa" placeholder="Angka..." class="form-control" required>
                                Nama Siswa : <input type="text" name="nama_siswa" placeholder="Tambahkan data siswa..." class="form-control" required>
                                Jenis : <select name="jenis" class="form-control" required>
                                    <option selected>L</option>
                                    <option>P</option>
                                </select>
                                Tempat Lahir : <input type="text" name="tempat_lahir" placeholder="Tambahkan tempat lahir..." class="form-control" required>
                                Tanggal Lahir : <input type="date" name="tgl_lahir" class="form-control" required>
                                <script>
                                    $(document).ready(function() {
                                        $("#kelasid").select2();
                                    });
                                </script>
                                <br>
                                <button type="submit" class="btn btn-success">Tambahkan</button>
                                <button type="reset" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="importsiswa">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Import Siswa Dari Excel</h3>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="import-siswa.php" enctype="multipart/form-data">
                                    Unggah File Excel : <input type="file" name="import_siswa" accept=".xls" required>
                                    <button type="submit" class="btn btn-primary">Import</button> 
                                    <a href="import/siswa.xls" target="_blank"><button type="button" class="btn btn-success">Download Format Excel</button></a>
                            </form>
                        </div>
                        <div class="modal-footer">

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
    <script src="select2.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>