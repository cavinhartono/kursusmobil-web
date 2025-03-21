<?php

include_once('koneksi.php');

$sql = "CREATE DATABASE IF NOT EXISTS kursus_mobil";

if (mysqli_query($koneksi, $sql)) {
  echo "Database berhasil dibuat / sudah ada.<br>";
} else {
  echo "Error membuat database: " . mysqli_error($koneksi);
}

mysqli_select_db($koneksi, 'kursus_mobil');

$sql_peserta = "CREATE TABLE IF NOT EXISTS peserta (
    id INT AUTO_INCREMENT,
    nama VARCHAR(50) NOT NULL,
    umur INT NOT NULL,
    no_hp VARCHAR(15),
    tanggal_daftar DATE,
    status enum('aktif', 'tidak lulus', 'lulus'),
    PRIMARY KEY (id)
)";

if (mysqli_query($koneksi, $sql_peserta)) {
  echo "Tabel peserta berhasil dibuat.";
} else {
  echo "Error tabel peserta: " . mysqli_error($koneksi);
}

$sql_transaksi = "CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    peserta_id INT,
    tanggal_transaksi DATE,
    jumlah DECIMAL(10,2),
    FOREIGN KEY (peserta_id) REFERENCES peserta(id)
)";

if (mysqli_query($koneksi, $sql_transaksi)) {
  echo "Tabel transaksi berhasil dibuat.";
} else {
  echo "Error tabel transaksi: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);
