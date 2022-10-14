<?php
$koneksi=mysqli_connect("localhost","root","","absensi_siswa") or die("Gagal mengkoneksikan dbms");
$selectdb=mysqli_select_db($koneksi,"absensi_siswa") or die("Gagal memilih database");