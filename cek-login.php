<?php

//memulai sesi
session_start();

//syntax memanggil file
include "koneksi.php";

//autentikasi username dan password
if(empty($_POST['username']) || empty($_POST['password'])) {
    echo '<script>
        alert("Username atau password harap diisi");
    </script>
    <meta http-equiv="refresh" content="0, login.php">';
} else {
    //merekam data dari form
    $user=mysqli_real_escape_string($koneksi,$_POST['username']);
    $password=mysqli_real_escape_string($koneksi,$_POST['password']);
    $akses=$_POST['akses'];

    //memproses akun dengan sql
    $sqlcek=mysqli_query($koneksi, "CALL cek_login('$user','$password','$akses')");
    if(mysqli_num_rows($sqlcek) > 0) {
        $_SESSION['username'] = $user;
        $_SESSION['akses'] = $akses;
        header('location:index.php');
    } else {
        echo '<script>
        alert("Username atau password tidak terdaftar");
    </script>
    <meta http-equiv="refresh" content="0, login.php">';
    }
}