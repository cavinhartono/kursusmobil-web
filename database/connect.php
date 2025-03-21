<?php

$koneksi = mysqli_connect("localhost", "root", "", "kursus_mobil");

if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

echo "Koneksi ke MySQL berhasil!";
