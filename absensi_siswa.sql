-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Jul 2022 pada 07.49
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_siswa`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cari_jadwal` (IN `carijadwal` VARCHAR(50))  SELECT mapel.*,jadwal.* FROM mapel,jadwal WHERE mapel.mapel_id=jadwal.mapel_id AND jadwal.jadwal_hari LIKE carijadwal$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cari_jurusan` (IN `namajurusan` VARCHAR(100))  SELECT * FROM jurusan WHERE jurusan.jurusan_nama LIKE namajurusan$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cari_kelas` (IN `namakelas` VARCHAR(100))  SELECT * FROM kelas WHERE kelas.kelas_nama LIKE namakelas$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cari_mapel` (IN `namamapel` VARCHAR(100))  SELECT * FROM mapel WHERE mapel.mapel_nama LIKE namamapel$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cari_siswa` (IN `namasiswa` VARCHAR(100))  SELECT jurusan.*,kelas.*,siswa.* FROM jurusan,kelas,siswa WHERE jurusan.jurusan_id=siswa.jurusan_id AND kelas.kelas_id=siswa.kelas_id AND siswa.siswa_nama LIKE namasiswa$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cek_absen` (IN `nis` CHAR(6), IN `tglskr` DATE)  SELECT * FROM absensi WHERE absensi.siswa_nis=nis AND absensi.tgl_absen=tglskr AND absensi.absen_status<>'Pulang'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cek_absen_pulang` (IN `nis` CHAR(6), IN `tglskr` DATE)  SELECT * FROM absensi WHERE absensi.siswa_nis=nis AND absensi.tgl_absen=tglskr AND absensi.absen_status='Pulang'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cek_login` (IN `user_name` VARCHAR(50), IN `pass` VARCHAR(50), IN `akses_login` ENUM('operator','admin'))  SELECT * FROM login WHERE username=user_name AND password=pass AND akses=akses_login$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `filter_laporan` (IN `bulan` INT(3), IN `kelas` VARCHAR(50))  SELECT jurusan.*,kelas.*,siswa.*,mapel.*,jadwal.*,absensi.* FROM jurusan,kelas,siswa,mapel,jadwal,absensi WHERE jurusan.jurusan_id=siswa.jurusan_id AND kelas.kelas_id=siswa.kelas_id AND mapel.mapel_id=jadwal.mapel_id AND siswa.siswa_nis=absensi.siswa_nis AND jadwal.jadwal_id=absensi.jadwal_id AND MONTH(absensi.tgl_absen)=bulan AND kelas.kelas_nama=kelas ORDER BY absensi.tgl_absen DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `filter_laporan_harian` (IN `tanggal` DATE, IN `kelas` VARCHAR(100))  SELECT jurusan.*,kelas.*,siswa.*,mapel.*,jadwal.*,absensi.* FROM jurusan,kelas,siswa,absensi WHERE jurusan.jurusan_id=siswa.jurusan_id AND kelas.kelas_id=siswa.kelas_id AND mapel.mapel_id=jadwal.mapel_id AND siswa.siswa_nis=absensi.siswa_nis AND jadwal.jadwal_id=absensi.jadwal_id AND absensi.tgl_absen=tanggal AND kelas.kelas_nama=kelas ORDER BY absensi.tgl_absen DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `grup_absen` ()  SELECT jurusan.*,kelas.*,siswa.*,mapel.*,jadwal.*,absensi.* FROM jurusan,kelas,siswa,mapel,jadwal,absensi WHERE jurusan.jurusan_id=siswa.jurusan_id AND kelas.kelas_id=siswa.kelas_id AND mapel.mapel_id=jadwal.mapel_id AND siswa.siswa_nis=absensi.siswa_nis AND jadwal.jadwal_id=absensi.jadwal_id GROUP BY absensi.tgl_absen ORDER BY absensi.tgl_absen DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_absen` (IN `idabsen` INT(11))  DELETE FROM absensi WHERE absensi.absen_id=idabsen$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_absen_pulang` (IN `idabsen` INT(11))  DELETE FROM absensi WHERE absensi.absen_id=idabsen$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_jadwal` (IN `idjadwal` INT(11))  DELETE FROM jadwal WHERE jadwal.jadwal_id=idjadwal$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_jurusan` (IN `idjurusan` INT(11))  DELETE FROM jurusan WHERE jurusan.jurusan_id=idjurusan$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_kelas` (IN `idkelas` INT(11))  DELETE FROM kelas WHERE kelas.kelas_id=idkelas$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_mapel` (IN `idmapel` INT(11))  DELETE FROM mapel WHERE mapel.mapel_id=idmapel$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_siswa` (IN `nis` CHAR(6))  DELETE FROM siswa WHERE siswa.siswa_nis=nis$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `laporan_cetak` (IN `bulan` INT(3), IN `kelas` VARCHAR(50))  SELECT jurusan.*,kelas.*,siswa.*,mapel.*,jadwal.*,absensi.absen_id,absensi.siswa_nis,absensi.hari,absensi.tgl_absen,MONTH(absensi.tgl_absen) AS bulan,absensi.waktu,absensi.absen_status FROM jurusan,kelas,siswa,mapel,jadwal,absensi WHERE jurusan.jurusan_id=siswa.jurusan_id AND kelas.kelas_id=siswa.kelas_id AND mapel.mapel_id=jadwal.mapel_id AND siswa.siswa_nis=absensi.siswa_nis AND jadwal.jadwal_id=absensi.jadwal_id AND MONTH(absensi.tgl_absen)=bulan AND kelas.kelas_nama=kelas$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `siswa_absen` (IN `nissiswa` CHAR(6))  SELECT jurusan.*,kelas.*,siswa.* FROM jurusan,kelas,siswa WHERE jurusan.jurusan_id=siswa.jurusan_id AND kelas.kelas_id=siswa.kelas_id AND siswa.siswa_nis=nissiswa$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_absensi` (IN `nis` CHAR(6), IN `hariabsen` VARCHAR(50), IN `tglabsen` DATETIME, IN `waktuabsen` TIME, IN `idjadwal` INT(11), IN `statusabsen` VARCHAR(50))  INSERT INTO absensi (siswa_nis,hari,tgl_absen,waktu,jadwal_id,absen_status) VALUES(nis,hariabsen,tglabsen,waktuabsen,idjadwal,statusabsen)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_jadwal` (IN `idmapel` INT(11), IN `hari` ENUM('SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU'), IN `ruangsiswa` ENUM('LAB RPL','LAB TKJ 1','LAB TKJ 2','LAB TKJ 3','LAB MM'))  INSERT INTO jadwal (jadwal.mapel_id,jadwal.jadwal_hari,jadwal.ruang) VALUES(idmapel,hari,ruangsiswa)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_jurusan` (IN `namajurusan` VARCHAR(100))  INSERT INTO jurusan (jurusan_nama) VALUES(namajurusan)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_kelas` (IN `namakelas` VARCHAR(50), IN `tingkatan` ENUM('X','XI','XII'))  INSERT INTO kelas (kelas_nama,tingkat) VALUES(namakelas,tingkatan)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_mapel` (IN `namamapel` VARCHAR(80), IN `jumlahjam` INT(5))  INSERT INTO mapel (mapel.mapel_nama,mapel.mapel_jumlah_jam) VALUES(namamapel,jumlahjam)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_siswa` (IN `nis` CHAR(6), IN `namasiswa` VARCHAR(60), IN `jeniskelamin` ENUM('L','P'), IN `tempatlahir` VARCHAR(100), IN `tgllahir` DATE, IN `idjurusan` INT(11), IN `idkelas` INT(11))  INSERT INTO siswa (siswa_nis,siswa_nama,siswa_jenis,siswa_tempat_lahir,siswa_tgl_lahir,jurusan_id,kelas_id) VALUES(nis,namasiswa,jeniskelamin,tempatlahir,tgllahir,idjurusan,idkelas)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tampil_absen` ()  SELECT jurusan.*,kelas.*,siswa.*,mapel.*,jadwal.*,absensi.* FROM jurusan,kelas,siswa,mapel,jadwal,absensi WHERE jurusan.jurusan_id=siswa.jurusan_id AND kelas.kelas_id=siswa.kelas_id AND mapel.mapel_id=jadwal.mapel_id AND siswa.siswa_nis=absensi.siswa_nis AND jadwal.jadwal_id=absensi.jadwal_id ORDER BY absensi.tgl_absen DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tampil_absen_masuk` ()  SELECT jurusan.*,kelas.*,siswa.*,mapel.*,jadwal.*,absensi.* FROM jurusan,kelas,siswa,mapel,jadwal,absensi WHERE jurusan.jurusan_id=siswa.jurusan_id AND kelas.kelas_id=siswa.kelas_id AND mapel.mapel_id=jadwal.mapel_id AND siswa.siswa_nis=absensi.siswa_nis AND jadwal.jadwal_id=absensi.jadwal_id AND absensi.tgl_absen=CURRENT_DATE AND absensi.absen_status<>'Pulang' ORDER BY absensi.waktu DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tampil_absen_pulang` ()  SELECT jurusan.*,kelas.*,siswa.*,mapel.*,jadwal.*,absensi.* FROM jurusan,kelas,siswa,mapel,jadwal,absensi WHERE jurusan.jurusan_id=siswa.jurusan_id AND kelas.kelas_id=siswa.kelas_id AND mapel.mapel_id=jadwal.mapel_id AND siswa.siswa_nis=absensi.siswa_nis AND jadwal.jadwal_id=absensi.jadwal_id AND absensi.tgl_absen=CURRENT_DATE AND absensi.absen_status='Pulang' ORDER BY absensi.waktu DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tampil_jadwal` ()  SELECT mapel.*,jadwal.* FROM mapel,jadwal WHERE mapel.mapel_id=jadwal.mapel_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tampil_jurusan` ()  SELECT * FROM jurusan$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tampil_kelas` ()  SELECT * FROM kelas$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tampil_laporan` ()  SELECT jurusan.*,kelas.*,siswa.*,mapel.*,jadwal.*,absensi.* FROM jurusan,kelas,siswa,mapel,jadwal,absensi WHERE jurusan.jurusan_id=siswa.jurusan_id AND kelas.kelas_id=siswa.kelas_id AND mapel.mapel_id=jadwal.mapel_id AND siswa.siswa_nis=absensi.siswa_nis AND jadwal.jadwal_id=absensi.jadwal_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tampil_mapel` ()  SELECT * FROM mapel$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tampil_siswa` ()  SELECT jurusan.*,kelas.*,siswa.* FROM jurusan,kelas,siswa WHERE jurusan.jurusan_id=siswa.jurusan_id AND kelas.kelas_id=siswa.kelas_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_jadwal` (IN `idjadwal` INT(11), IN `idmapel` INT(11), IN `hari` ENUM('SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU'), IN `ruangsiswa` ENUM('LAB RPL','LAB TKJ 1','LAB TKJ 2','LAB TKJ 3','LAB MM'))  UPDATE jadwal SET jadwal.mapel_id=idmapel, jadwal.jadwal_hari=hari, jadwal.ruang=ruangsiswa WHERE jadwal.jadwal_id=idjadwal$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_jurusan` (IN `idjurusan` INT(11), IN `namajurusan` VARCHAR(100))  UPDATE jurusan SET jurusan.jurusan_nama=namajurusan WHERE jurusan.jurusan_id=idjurusan$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_kelas` (IN `idkelas` INT(11), IN `namakelas` VARCHAR(50), IN `tingkatan` ENUM('X','XI','XII'))  UPDATE kelas SET kelas.kelas_nama=namakelas, kelas.tingkat=tingkatan WHERE kelas.kelas_id=idkelas$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_mapel` (IN `idmapel` INT(11), IN `namamapel` VARCHAR(80), IN `jumlahjam` INT(5))  UPDATE mapel SET mapel.mapel_nama=namamapel, mapel.mapel_jumlah_jam=jumlahjam WHERE mapel.mapel_id=idmapel$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_siswa` (IN `idsiswa` INT(11), IN `nis` CHAR(6), IN `namasiswa` VARCHAR(60), IN `jeniskelamin` ENUM('L','P'), IN `tempatlahir` VARCHAR(100), IN `tgllahir` DATE, IN `idjurusan` INT(11), IN `idkelas` INT(11))  UPDATE siswa SET siswa.siswa_nis=nis, siswa.siswa_nama=namasiswa, siswa.siswa_jenis=jeniskelamin, siswa.siswa_tempat_lahir=tempatlahir, siswa.siswa_tgl_lahir=tgllahir, siswa.jurusan_id=idjurusan, siswa.kelas_id=idkelas WHERE siswa.siswa_id=idsiswa$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `absen_id` int(11) NOT NULL,
  `siswa_nis` char(6) NOT NULL,
  `hari` varchar(50) NOT NULL,
  `tgl_absen` date NOT NULL,
  `waktu` time NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  `absen_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `jadwal_id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `jadwal_hari` enum('SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU') NOT NULL,
  `ruang` enum('LAB RPL','LAB TKJ 1','LAB TKJ 2','LAB TKJ 3','LAB MM') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`jadwal_id`, `mapel_id`, `jadwal_hari`, `ruang`) VALUES
(2, 2, 'SENIN', 'LAB RPL'),
(3, 3, 'SELASA', 'LAB RPL'),
(4, 4, 'SENIN', 'LAB RPL'),
(5, 5, 'SENIN', 'LAB RPL'),
(6, 5, 'SELASA', 'LAB RPL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `jurusan_id` int(11) NOT NULL,
  `jurusan_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`jurusan_id`, `jurusan_nama`) VALUES
(1, 'Teknik Komputer dan Jaringan'),
(2, 'Multimedia'),
(3, 'Rekayasa Perangkat Lunak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `kelas_id` int(11) NOT NULL,
  `kelas_nama` varchar(50) NOT NULL,
  `tingkat` enum('X','XI','XII') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`kelas_id`, `kelas_nama`, `tingkat`) VALUES
(1, 'X RPL', 'X'),
(2, 'XI RPL', 'XI'),
(3, 'XII RPL', 'XII'),
(4, 'X TKJ 1', 'X'),
(5, 'X TKJ 2', 'X'),
(6, 'XI TKJ 1', 'XI'),
(7, 'XI TKJ 2', 'XI'),
(8, 'XII TKJ 1', 'XII'),
(9, 'XII TKJ 2', 'XII'),
(10, 'XII TKJ 3', 'XII'),
(11, 'X MM', 'X'),
(12, 'XI MM', 'XI'),
(13, 'XII MM', 'XII');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `akses` enum('operator','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`user_id`, `username`, `password`, `akses`) VALUES
(1, 'admin', 'admin123', 'admin'),
(2, 'operator', 'operator', 'operator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `mapel_id` int(11) NOT NULL,
  `mapel_nama` varchar(100) NOT NULL,
  `mapel_jumlah_jam` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`mapel_id`, `mapel_nama`, `mapel_jumlah_jam`) VALUES
(2, 'Basis Data', 4),
(3, 'Pemrograman Web dan Mobile', 6),
(4, 'Permodelan Perangkat Lunak', 3),
(5, 'Pemrograman Berorientasi Obyek', 6),
(6, 'Teknologi Layanan Jaringan', 5),
(7, 'Administrasi Infrastruktur Jaringan', 5),
(8, 'Administrasi Sistem Jaringan', 6),
(10, 'Teknologi Jaringan Berbasis Luas (WAN)', 5),
(11, 'Desain Grafis Percetakan', 5),
(12, 'Desain Media Interaktif', 4),
(13, 'Teknik Animasi 2D dan 3D', 4),
(14, 'Teknik Pengolahan Audio dan Video', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `siswa_id` int(11) NOT NULL,
  `siswa_nis` char(6) NOT NULL,
  `siswa_nama` varchar(60) NOT NULL,
  `siswa_jenis` enum('L','P') NOT NULL,
  `siswa_tempat_lahir` varchar(100) NOT NULL,
  `siswa_tgl_lahir` date NOT NULL,
  `jurusan_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`siswa_id`, `siswa_nis`, `siswa_nama`, `siswa_jenis`, `siswa_tempat_lahir`, `siswa_tgl_lahir`, `jurusan_id`, `kelas_id`) VALUES
(1, '02642', 'Azri Rifqi Fadhilla', 'L', 'Kendal', '2005-03-30', 3, 3),
(3, '02644', 'Bagus Prastio', 'L', 'Jakarta', '2004-01-18', 3, 3),
(4, '02649', 'Dafa Rafli Ariyanto', 'L', 'SEMARANG', '2022-05-02', 3, 3),
(7, '02744', 'AGUNG HIDAYATULLAH', 'L', 'Kendal', '2003-08-29', 3, 2),
(8, '02745', 'AGUSTINA INDAH WAHANI', 'P', 'Semarang', '2005-08-21', 3, 2),
(9, '02746', 'AHMAD BAITUL FAJAR', 'L', 'Kendal', '2005-12-03', 3, 2),
(10, '02752', 'ANDRIAN DWI LAKSONO', 'L', 'KENDAL', '2006-07-07', 3, 2),
(11, '02755', 'APRIWAGENTA', 'L', 'Kendal', '2005-04-22', 3, 2),
(12, '02760', 'ARYAN EKA SATRIA', 'L', 'Semarang', '2005-09-22', 3, 2),
(13, '02768', 'CANDRA ADITYA', 'L', 'Kendal', '2005-11-30', 3, 2),
(14, '02777', 'DWI FATMAWATI', 'P', 'Kendal', '2021-02-15', 3, 2),
(15, '02794', 'HAKIKI TEGAR SAPUTRO', 'L', 'Kendal', '2005-12-06', 3, 2),
(16, '02802', 'KARIDA AYU SEPDIANI', 'P', 'Semarang', '2005-09-04', 3, 2),
(17, '02804', 'LA PANCA SUGIHARTO', 'L', 'Kendal', '2006-06-19', 3, 2),
(18, '02820', 'OLWIN SAPUTRA', 'P', 'Pekalongan', '2005-09-12', 3, 2),
(19, '02824', 'RAFI RAFAEL', 'L', 'Kendal', '2006-08-30', 3, 2),
(20, '02828', 'RENDY NANDHA IKWAN', 'L', 'Kendal', '2005-03-14', 3, 2),
(21, '02834', 'RISANG AGUS P.', 'L', 'Kendal', '2006-01-20', 3, 2),
(22, '02835', 'RIZKY AMRULLAH', 'L', 'Kendal', '2006-11-11', 3, 2),
(23, '02848', 'UMI SARI FATCHUL ULUM', 'P', 'Kendal', '2005-11-25', 3, 2),
(24, '02849', 'VANDITO SATRIA HENDIAWAN NUR SAPUTRA', 'L', 'Kendal', '2006-12-01', 3, 2),
(25, '02859', 'ZAKTIFIYA ADE RISKHA MAHADEWI', 'P', 'Grobogan', '2005-08-25', 3, 2),
(26, '02861', 'MAULINDA EKA SOFIANA', 'P', 'Kendal', '2006-03-30', 3, 2),
(27, '02862', 'MOCH.SYARIF HIDAYAT', 'L', 'Semarang', '2005-03-25', 3, 2),
(28, '02863', 'M. RISKI SETIAWAN', 'L', 'Kendal', '2006-02-20', 3, 2),
(29, '02864', 'ELSA SUSILA NINGRUM', 'P', 'Kendal', '2007-02-22', 3, 2),
(30, '02657', 'Erlangga Dwi Kurnia', 'L', 'Kendal', '2005-05-07', 3, 3),
(31, '02660', 'Faris Hidayat', 'L', 'Kendal', '2005-09-04', 3, 3),
(32, '02663', 'Faza Zain Fuada', 'L', 'Kendal', '2006-06-03', 3, 3),
(33, '02699', 'Nurlaila Heny Indriyani', 'P', 'Kendal', '2003-04-29', 3, 3),
(34, '02714', 'Rizal Maulana', 'L', 'Kendal', '2005-04-13', 3, 3),
(35, '02736', 'Zaky Fatkhurokhman', 'L', 'Kendal', '2006-03-13', 3, 3),
(36, '02740', 'Putri Kinanthi Arima Nugraheni', 'P', 'Kendal', '2004-03-22', 3, 3);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`absen_id`),
  ADD KEY `siswa_nis` (`siswa_nis`),
  ADD KEY `jadwal_id` (`jadwal_id`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`jadwal_id`),
  ADD KEY `mapel_id` (`mapel_id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`jurusan_id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kelas_id`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`mapel_id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`siswa_id`),
  ADD UNIQUE KEY `siswa_nis` (`siswa_nis`) USING BTREE,
  ADD KEY `jurusan_id` (`jurusan_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `absen_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `jadwal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `jurusan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kelas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `mapel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `siswa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`siswa_nis`) REFERENCES `siswa` (`siswa_nis`),
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`jadwal_id`);

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`mapel_id`);

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`jurusan_id`),
  ADD CONSTRAINT `siswa_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
