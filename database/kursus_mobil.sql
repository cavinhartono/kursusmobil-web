-- Active: 1734018196245@@127.0.0.1@3306

CREATE DATABASE kursus_mobil;

USE kursus_mobil;

CREATE TABLE peserta (
    `id` INT AUTO_INCREMENT,
    `nama` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `tanggal_daftar` DATE NOT NULL,
    `status` ENUM(
        "aktif",
        "tidak lulus",
        "lulus"
    ),
    PRIMARY KEY (id)
)