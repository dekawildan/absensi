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
                <li><a href="kelas.php" class="aktif">Kelas</a></li>
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
        <?php
                if($_SESSION['akses'] != 'admin') {
                    echo "<h1 align='center'>Maaf Akses Ditolak</h1>";
                } else {

            ?>
            <p>&nbsp; <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambahkelas">+ Tambah Kelas</button>
                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#tambahanggota">+ Tambah Anggota</button>
        </p>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    Cari : <br>
                    <input type="text" name="cari_data" placeholder="Masukkan data yang dicari..." class="form-control" style="width:85%; float:left;" required>&nbsp;<button class="btn btn-primary" type="submit" name="cari">Cari</button>
                </form>
                <h3 align="center"><strong>DATA KELAS</strong></h3>
            <p>&nbsp;
                <table class="table table-striped table-hover">
                        <tr>
                            <th>NO</th>
                            <th>NAMA KELAS</th>
                            <th>TINGKAT</th>
                            <th>JURUSAN</th>
                            <th>AKSI</th>
                        </tr>
                        <?php
                            include "koneksi.php";
                            if(!isset($_POST['cari'])) {
                                $sql=mysqli_query($koneksi,"CALL tampil_kelas()");
                                $no=1;
                                while($row=mysqli_fetch_array($sql)) {
                                    echo "<tr>
                                        <td>".
                                        $no++
                                        ."</td>
                                        <td>$row[kelas_nama]</td>
                                        <td>$row[tingkat]</td>
                                        <td>$row[jurusan_nama]</td>
                                        <td>
                                        <button class='btn btn-info' type='button' title='Edit $row[kelas_nama]' data-bs-toggle='modal' data-bs-target='#edit$row[kelas_id]'>Edit</button>
                                        <button class='btn btn-warning' type='button' title='Hapus $row[kelas_nama]' data-bs-toggle='modal' data-bs-target='#hapus$row[kelas_id]'>Hapus</button>
                                        <button class='btn btn-success' type='button' title='Lihat Anggota $row[kelas_nama]' data-bs-toggle='modal' data-bs-target='#lihat$row[kelas_id]'>Lihat Anggota</button>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td colspan='5'>
                                    
                                    <div class='modal fade' id='edit$row[kelas_id]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Edit Kelas $row[kelas_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='update_kelas.php'>
                                <input type='hidden' name='kelas_id' value='$row[kelas_id]'>
                                Nama Kelas : <input type='text' name='nama_kelas' value='$row[kelas_nama]' placeholder='Tambahkan data kelas...' class='form-control' required>
                                Tingkat : <select name='tingkat' class='form-control' required>
                                    <option selected>$row[tingkat]</option>
                                    <option>X</option>
                                    <option>XI</option>
                                    <option>XII</option>
                                </select>
                                Jurusan : <select name='jurusan_id' class='form-control' required>";
                                        include "koneksi.php";
                                        echo "<option selected>$row[jurusan_id]-$row[jurusan_nama]</option>";
                                        $ambiljurusan=mysqli_query($koneksi,"CALL tampil_jurusan()");
                                        while($rj=mysqli_fetch_array($ambiljurusan)) {
                                            echo "
                                            <option>$rj[jurusan_id]-$rj[jurusan_nama]</option>";
                                        }
                                echo "
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

            <div class='modal fade' id='hapus$row[kelas_id]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Hapus Kelas $row[kelas_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='hapus_kelas.php'>
                                <input type='hidden' name='kelas_id' value='$row[kelas_id]'>
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

            <div class='modal fade' id='lihat$row[kelas_id]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Anggota Kelas $row[kelas_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <table class='table table-hover table-striped' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td>NAMA SISWA</td>
                                <td>TINDAKAN</td>
                            </tr>";
                            include "koneksi.php";
                            $ambildetail=mysqli_query($koneksi,"CALL tampil_detail_kelas('$row[kelas_nama]')");
                            while($detail=mysqli_fetch_array($ambildetail)) {
                                echo "<tr>
                                    <td>$detail[siswa_nama]</td>
                                    <td>
                                        <button class='btn btn-danger' type='button' id='tombolhapusdetail$detail[detail_id]'>Hapus</button>
                                    </td>
                                </tr>
                                <!--tr-->
                                <!--td colspan='2'-->

                                <!--div class='modal fade' id='hapusdetail$detail[detail_id]'-->
                                <!--div class='modal-dialog'-->
                                    <div class='modal-content' id='hapusdetail$detail[detail_id]' style='display:none; position:fixed; z-index: 999; width: 50%;'>
                                        <div class='modal-header'>
                                            <h4>Hapus Anggota $detail[siswa_nama]</h4>
                                            <button type='button' class='btn-close' id='tutup$detail[detail_id]'>&nbsp;</button>
                                        </div>
                                        <div class='modal-body'>
                                            <form method='post' action='hapus_detail_kelas.php'>
                                                <input type='hidden' name='detail_id' value='$detail[detail_id]'>
                                                Anda yakin menghapus data ini ? <br>
                                                <button type='submit' class='btn btn-danger'>Ya</button>
                                                <button type='reset' class='btn btn-default' id='tomboltutup$detail[detail_id]'>Batal</button>
                                            </form>
                                        </div>
                                        <div class='modal-footer'>
                                            <p>&nbsp;</p>
                                        </div>
                                    </div>
                                <!--/div-->
                            <!--/div-->
                                <!--/td-->
                                <!--/tr-->";
                            }
                        echo "</table>
                        </div>
                        <div class='modal-footer'>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>

            </td>
            </tr>
                                    ";
                                }
                            } else {
                                $caridata=$_POST['cari_data'];
                                $sql=mysqli_query($koneksi,"CALL cari_kelas('%$caridata%')");
                                $no=1;
                                while($row=mysqli_fetch_array($sql)) {
                                    echo "<tr>
                                        <td>".
                                        $no++
                                        ."</td>
                                        <td>$row[kelas_nama]</td>
                                        <td>$row[tingkat]</td>
                                        <td>$row[jurusan_nama]</td>
                                        <td>
                                        <button class='btn btn-info' type='button' title='Edit $row[kelas_nama]' data-bs-toggle='modal' data-bs-target='#edit$row[kelas_id]'>Edit</button>
                                        <button class='btn btn-warning' type='button' title='Hapus $row[kelas_nama]' data-bs-toggle='modal' data-bs-target='#hapus$row[kelas_id]'>Hapus</button>
                                        <button class='btn btn-success' type='button' title='Lihat Anggota $row[kelas_nama]' data-bs-toggle='modal' data-bs-target='#lihat$row[kelas_id]'>Lihat Anggota</button>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td colspan='5'>

                                    <div class='modal fade' id='edit$row[kelas_id]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Edit Kelas $row[kelas_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='update_kelas.php'>
                                <input type='hidden' name='kelas_id' value='$row[kelas_id]'>
                                Nama Kelas : <input type='text' name='nama_kelas' value='$row[kelas_nama]' placeholder='Tambahkan data kelas...' class='form-control' required>
                                Tingkat : <select name='tingkat' class='form-control' required>
                                    <option selected>$row[tingkat]</option>
                                    <option>X</option>
                                    <option>XI</option>
                                    <option>XII</option>
                                </select>
                                Jurusan : <select name='jurusan_id' class='form-control' required>";
                                        include "koneksi.php";
                                        echo "<option selected>$row[jurusan_id]-$row[jurusan_nama]</option>";
                                        $ambiljurusan=mysqli_query($koneksi,"CALL tampil_jurusan()");
                                        while($rj=mysqli_fetch_array($ambiljurusan)) {
                                            echo "
                                            <option>$rj[jurusan_id]-$rj[jurusan_nama]</option>";
                                        }
                                echo "
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

            <div class='modal fade' id='hapus$row[kelas_id]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Hapus Kelas $row[kelas_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <form method='post' action='hapus_kelas.php'>
                                <input type='hidden' name='kelas_id' value='$row[kelas_id]'>
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

            <div class='modal fade' id='lihat$row[kelas_id]'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>Anggota Kelas $row[kelas_nama]</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'>&nbsp;</button>
                        </div>
                        <div class='modal-body'>
                            <table class='table table-hovered table-striped'>
                            <tr>
                                <td>NAMA SISWA</td>
                                <td>TINDAKAN</td>
                            </tr>";
                            include "koneksi.php";
                            $ambildetail=mysqli_query($koneksi,"CALL tampil_detail_kelas('$row[kelas_nama]')");
                            while($detail=mysqli_fetch_array($ambildetail)) {
                                echo "<tr>
                                    <td>$detail[siswa_nama]</td>
                                    <td>
                                        <button class='btn btn-danger' type='button' id='tombolhapusdetail$detail[detail_id]'>Hapus</button>
                                    </td>
                                </tr>
                                <!--tr-->
                                <!--td colspan='2'-->

                                <!--div class='modal fade' id='hapusdetail$detail[detail_id]'-->
                                <!--div class='modal-dialog'-->
                                    <div class='modal-content' id='hapusdetail$detail[detail_id]' style='display:none; position:fixed; z-index: 999; width: 50%;'>
                                        <div class='modal-header'>
                                            <h4>Hapus Anggota $detail[siswa_nama]</h4>
                                            <button type='button' class='btn-close' id='tutup$detail[detail_id]'>&nbsp;</button>
                                        </div>
                                        <div class='modal-body'>
                                            <form method='post' action='hapus_detail_kelas.php'>
                                                <input type='hidden' name='detail_id' value='$detail[detail_id]'>
                                                Anda yakin menghapus data ini ? <br>
                                                <button type='submit' class='btn btn-danger'>Ya</button>
                                                <button type='reset' class='btn btn-default' id='tomboltutup$detail[detail_id]'>Batal</button>
                                            </form>
                                        </div>
                                        <div class='modal-footer'>
                                            <p>&nbsp;</p>
                                        </div>
                                    </div>
                                <!--/div-->
                            <!--/div-->
                                <!--/td-->
                                <!--/tr-->";
                            }
                        echo "</table></div>
                        <div class='modal-footer'>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>

            </td>
            </tr>
                                    ";
                                }
                            }
                        ?>
                </table>
            </p>
            <div class="modal fade" id="tambahkelas">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Tambah Kelas</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">&nbsp;</button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="simpan_kelas.php">
                                Nama Kelas : <input type="text" name="nama_kelas" placeholder="Tambahkan data kelas..." class="form-control" required>
                                Tingkat : <select name="tingkat" class="form-control" required>
                                    <option selected>X</option>
                                    <option>XI</option>
                                    <option>XII</option>
                                </select>
                                Jurusan : <select name="jurusan_id" class="form-control" required>
                                    <?php
                                        include "koneksi.php";
                                        $ambiljurusan=mysqli_query($koneksi,"CALL tampil_jurusan()");
                                        while($rj=mysqli_fetch_array($ambiljurusan)) {
                                            echo "<option>$rj[jurusan_id]-$rj[jurusan_nama]</option>";
                                        }
                                    ?>
                                </select>
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

            <div class="modal fade" id="tambahanggota">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Tambah Anggota</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">&nbsp;</button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="simpan_detail_kelas.php">
                                Pilih Kelas : <select name="kelas_id" class="form-control" placeholder="Tidak boleh kosong" required>
                                    <?php
                                        include "koneksi.php";
                                        $sqldetail=mysqli_query($koneksi, "CALL tampil_kelas()");
                                        while($rd=mysqli_fetch_array($sqldetail)) {
                                            echo "<option>$rd[kelas_id]-$rd[kelas_nama]</option>";
                                        }
                                    ?>
                                </select>
                                Pilih Siswa : <select name="siswa_nis" class="form-control" placeholder="Tidak boleh kosong" required>
                                    <?php
                                        include "koneksi.php";
                                        $ambilsiswa=mysqli_query($koneksi,"CALL tampil_siswa()");
                                        while($rs=mysqli_fetch_array($ambilsiswa)) {
                                            echo "<option>$rs[siswa_nis]-$rs[siswa_nama]</option>";
                                        }
                                    ?>
                                </select>
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

    <!-- JQUERY modal -->
    <script>
        $(document).ready(function() {
            <?php
                    include "koneksi.php";
                    $getdetail=mysqli_query($koneksi,"CALL untuk_hapus_detail()");
                    while($rdetail=mysqli_fetch_array($getdetail)) {
                        echo "$('#tombolhapusdetail$rdetail[detail_id]').click(function() {
                            $('#hapusdetail$rdetail[detail_id]').fadeIn(300);
                        });
                        $('#tutup$rdetail[detail_id]').click(function() {
                            $('#hapusdetail$rdetail[detail_id]').fadeOut(300);
                        });
                        $('#tomboltutup$rdetail[detail_id]').click(function() {
                            $('#hapusdetail$rdetail[detail_id]').fadeOut(300);
                        });";
                    }
            ?>
        });
    </script>
</body>
</html>