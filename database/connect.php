<?php
session_start();

$connect = mysqli_connect("localhost", "root", "", "driving_school");

if (!$connect) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
