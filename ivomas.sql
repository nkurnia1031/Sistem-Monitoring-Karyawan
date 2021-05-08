-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 08 Bulan Mei 2021 pada 12.26
-- Versi server: 5.7.24
-- Versi PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ivomas`
--

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `absen`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `absen` (
`dept_id` int(3)
,`dept_name` varchar(25)
,`bln` int(2)
,`thn` int(4)
,`tipe2` int(3)
,`nik2` varchar(8)
,`nik` varchar(198)
,`tipe` varchar(32)
,`id` int(11)
,`day` decimal(10,2)
,`ket` text
,`tgl` date
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `user` varchar(5) NOT NULL,
  `pass` text NOT NULL,
  `tanya` text,
  `jawab` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`user`, `pass`, `tanya`, `jawab`) VALUES
('admin', 'e10adc3949ba59abbe56e057f20f883e', 'Warna Kesukaan?', 'Dark Blue');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `bagian`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `bagian` (
`dept_id` int(3)
,`dept_name` varchar(25)
,`sect_id` int(3)
,`dept_id2` int(3)
,`sect_name` varchar(25)
,`sect_id2` int(3)
,`subsect_id` int(3)
,`subsect_name` varchar(25)
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dept`
--

CREATE TABLE `dept` (
  `dept_id` int(3) NOT NULL,
  `dept_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dept`
--

INSERT INTO `dept` (`dept_id`, `dept_name`) VALUES
(1, 'Production'),
(3, 'Engineering'),
(4, 'Commercial'),
(5, 'HRGA'),
(6, 'QM'),
(7, 'FA'),
(8, 'MGM'),
(9, 'MR'),
(10, 'PPIC'),
(11, 'PE'),
(12, 'Warehouse'),
(13, 'OLC'),
(14, 'EHFS'),
(15, 'Procurement'),
(16, 'IT'),
(17, 'Dumai Bulking'),
(18, 'Security'),
(19, 'Logistic');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ewd`
--

CREATE TABLE `ewd` (
  `tgl` date NOT NULL,
  `nik` varchar(8) NOT NULL,
  `id` int(11) NOT NULL,
  `tipe` int(3) NOT NULL,
  `day` decimal(10,2) DEFAULT '0.00',
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gol`
--

CREATE TABLE `gol` (
  `gol` varchar(25) NOT NULL,
  `idgol` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gol`
--

INSERT INTO `gol` (`gol`, `idgol`) VALUES
('05-Worker', 5),
('06-Sr Worker', 6),
('07-Jr Clerk', 7),
('08-Clerk', 8),
('09-Sr Clerk', 9),
('11-Supervisor', 11),
('12-Supervisor', 12),
('13-Ast Manager', 13),
('14-Ast Manager', 14),
('15-Manager', 15),
('16-Manager', 16),
('18-Ast Vice President', 18),
('19-Vice President', 19);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kar`
--

CREATE TABLE `kar` (
  `nik` varchar(8) NOT NULL,
  `gender` char(1) DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL,
  `gola` int(3) DEFAULT NULL,
  `subsect_id2` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `karyawan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `karyawan` (
`nik` varchar(8)
,`gender` char(1)
,`nama` varchar(25)
,`level` varchar(10)
,`status` varchar(15)
,`gola` int(3)
,`subsect_id2` varchar(3)
,`dept_id` int(3)
,`dept_name` varchar(25)
,`sect_id` int(3)
,`dept_id2` int(3)
,`sect_name` varchar(25)
,`sect_id2` int(3)
,`subsect_id` int(3)
,`subsect_name` varchar(25)
,`gol` varchar(25)
,`idgol` int(3)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `lembur`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `lembur` (
`thn` int(4)
,`bln` int(2)
,`id` int(11)
,`nik2` varchar(8)
,`nik` varchar(198)
,`tipe` varchar(5)
,`type` int(1)
,`x15` decimal(10,2)
,`x2` decimal(10,2)
,`x3` decimal(10,2)
,`x4` decimal(10,2)
,`tgl` date
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `lembur2`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `lembur2` (
`nik` varchar(8)
,`id` int(11)
,`type` int(1)
,`x15` decimal(10,2)
,`x2` decimal(10,2)
,`x3` decimal(10,2)
,`x4` decimal(10,2)
,`tgl` date
,`thn` int(4)
,`bln` int(2)
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `libur`
--

CREATE TABLE `libur` (
  `id` int(3) NOT NULL,
  `tanggal` date NOT NULL,
  `ket` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `libur`
--

INSERT INTO `libur` (`id`, `tanggal`, `ket`) VALUES
(2, '2017-01-01', 'Tahun Baru Masehi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `overtime`
--

CREATE TABLE `overtime` (
  `nik` varchar(8) NOT NULL,
  `id` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `x15` decimal(10,2) NOT NULL DEFAULT '0.00',
  `x2` decimal(10,2) NOT NULL DEFAULT '0.00',
  `x3` decimal(10,2) NOT NULL DEFAULT '0.00',
  `x4` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tgl` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sect`
--

CREATE TABLE `sect` (
  `sect_id` int(3) NOT NULL,
  `dept_id2` int(3) NOT NULL,
  `sect_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sect`
--

INSERT INTO `sect` (`sect_id`, `dept_id2`, `sect_name`) VALUES
(1, 1, 'Refinery'),
(2, 1, 'FRACTINATION'),
(3, 1, 'KCP'),
(4, 1, 'KCP'),
(5, 3, 'Engineering'),
(6, 3, 'Mechanical'),
(7, 3, 'Electrical'),
(8, 3, 'Project'),
(9, 3, 'Utility'),
(10, 4, 'Operation'),
(11, 4, 'Jetty'),
(12, 19, 'Logistic'),
(13, 4, 'KB/Export Adm'),
(14, 17, 'Dumai Bulking'),
(15, 5, 'HR'),
(16, 5, 'HR'),
(17, 5, 'GA'),
(18, 18, 'Security'),
(19, 6, 'QM'),
(20, 6, 'QC'),
(21, 6, 'QA'),
(22, 7, 'FA'),
(23, 7, 'RC'),
(24, 8, 'MGM'),
(25, 9, 'MR'),
(26, 10, 'PPIC'),
(27, 11, 'PE'),
(28, 12, 'Warehouse'),
(29, 13, 'OLC'),
(30, 14, 'EHFS'),
(31, 15, 'Procurement'),
(32, 16, 'IT'),
(33, 4, 'Commercial'),
(34, 17, 'Export Administration'),
(35, 7, 'OC'),
(36, 1, 'Production'),
(37, 1, 'Refinery');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `section`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `section` (
`dept_id` int(3)
,`dept_name` varchar(25)
,`sect_id` int(3)
,`dept_id2` int(3)
,`sect_name` varchar(25)
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `subsect`
--

CREATE TABLE `subsect` (
  `sect_id2` int(3) NOT NULL,
  `subsect_id` int(3) NOT NULL,
  `subsect_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `subsect`
--

INSERT INTO `subsect` (`sect_id2`, `subsect_id`, `subsect_name`) VALUES
(0, 0, 'Refinery'),
(1, 1, 'Refinery'),
(2, 2, 'FRACTINATION'),
(3, 3, 'KCP'),
(4, 4, 'KCP Process'),
(4, 5, 'KCP Maintenance-Welder'),
(4, 6, 'KCP Maintenance-Mechanica'),
(5, 7, 'Engineering'),
(6, 8, 'Maintenance'),
(6, 9, 'Fabrication'),
(7, 10, 'Electrical'),
(7, 11, 'Genset'),
(7, 12, 'Instrumantation'),
(7, 13, 'Calibration'),
(7, 14, 'CILT'),
(8, 15, 'Project/drafter'),
(9, 16, 'WTP/WWTP'),
(9, 17, 'LPB'),
(9, 18, 'HPB'),
(10, 20, 'Loader'),
(10, 21, 'PK Storage/Silo'),
(10, 22, 'PKE Warehouse'),
(10, 23, 'Loader PK'),
(10, 24, 'Tank Yard/Pump House'),
(10, 25, 'Unloading CPO'),
(10, 26, 'WB'),
(10, 27, 'Driver Langsir'),
(11, 28, 'Jetty'),
(12, 29, 'Logistic'),
(13, 30, 'KB'),
(14, 32, 'OTD'),
(14, 33, 'Terminal Driver'),
(14, 34, 'WB'),
(14, 35, 'QC'),
(14, 36, 'Utility'),
(14, 37, 'Mechanical'),
(14, 38, 'Adm'),
(14, 39, 'Security'),
(14, 40, 'Patroli'),
(15, 41, 'HR'),
(16, 42, 'HR'),
(17, 43, 'GA'),
(18, 44, 'Security'),
(19, 45, 'QM'),
(20, 46, 'QC'),
(21, 47, 'QA'),
(22, 48, 'FA'),
(23, 49, 'RC'),
(35, 50, 'OC'),
(24, 51, 'MGM'),
(25, 52, 'MR'),
(26, 53, 'PPIC'),
(27, 54, 'PE'),
(28, 55, 'Warehouse'),
(29, 56, 'OLC'),
(30, 57, 'EHFS'),
(31, 58, 'Procurement'),
(32, 59, 'IT'),
(6, 60, 'Mechanical'),
(7, 61, 'Electrical'),
(10, 62, 'Operation'),
(33, 63, 'Commercial'),
(14, 64, 'Dumai Bulking'),
(9, 65, 'Utility'),
(34, 66, 'KB/Export Adm'),
(14, 67, 'Jetty'),
(14, 69, 'Driver Loader'),
(14, 70, 'Checker'),
(34, 71, 'KB'),
(36, 72, 'Production');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `thn`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `thn` (
`thn` int(4)
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tipeewd`
--

CREATE TABLE `tipeewd` (
  `id` int(3) NOT NULL,
  `kode` varchar(4) NOT NULL,
  `ket` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tipeewd`
--

INSERT INTO `tipeewd` (`id`, `kode`, `ket`) VALUES
(1, 'DT', 'Datang Terlambat'),
(2, 'PC', 'Pulang Cepat'),
(3, 'S', 'Sakit'),
(4, 'M', 'Mangkir'),
(5, 'T', 'Cuti');

-- --------------------------------------------------------

--
-- Struktur untuk view `absen`
--
DROP TABLE IF EXISTS `absen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `absen`  AS  select `karyawan`.`dept_id` AS `dept_id`,`karyawan`.`dept_name` AS `dept_name`,month(`ewd`.`tgl`) AS `bln`,year(`ewd`.`tgl`) AS `thn`,`tipeewd`.`id` AS `tipe2`,`karyawan`.`nik` AS `nik2`,concat(`karyawan`.`nama`,' (<strong><small><a href="#" class="text-success" data-toggle="modal" data-target=".modal-kar" onclick="app.getall(\'nik\',',`karyawan`.`nik`,',\'karyawan\')">',`karyawan`.`nik`,'</a></small></strong>)') AS `nik`,concat(`tipeewd`.`ket`,' (',`tipeewd`.`kode`,')') AS `tipe`,`ewd`.`id` AS `id`,`ewd`.`day` AS `day`,`ewd`.`ket` AS `ket`,`ewd`.`tgl` AS `tgl` from ((`ewd` join `karyawan`) join `tipeewd`) where ((`karyawan`.`nik` = `ewd`.`nik`) and (`ewd`.`tipe` = `tipeewd`.`id`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `bagian`
--
DROP TABLE IF EXISTS `bagian`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bagian`  AS  select `dept`.`dept_id` AS `dept_id`,`dept`.`dept_name` AS `dept_name`,`sect`.`sect_id` AS `sect_id`,`sect`.`dept_id2` AS `dept_id2`,`sect`.`sect_name` AS `sect_name`,`subsect`.`sect_id2` AS `sect_id2`,`subsect`.`subsect_id` AS `subsect_id`,`subsect`.`subsect_name` AS `subsect_name` from ((`dept` join `sect`) join `subsect`) where ((`dept`.`dept_id` = `sect`.`dept_id2`) and (`sect`.`sect_id` = `subsect`.`sect_id2`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `karyawan`
--
DROP TABLE IF EXISTS `karyawan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `karyawan`  AS  select `kar`.`nik` AS `nik`,`kar`.`gender` AS `gender`,`kar`.`nama` AS `nama`,`kar`.`level` AS `level`,`kar`.`status` AS `status`,`kar`.`gola` AS `gola`,`kar`.`subsect_id2` AS `subsect_id2`,`bagian`.`dept_id` AS `dept_id`,`bagian`.`dept_name` AS `dept_name`,`bagian`.`sect_id` AS `sect_id`,`bagian`.`dept_id2` AS `dept_id2`,`bagian`.`sect_name` AS `sect_name`,`bagian`.`sect_id2` AS `sect_id2`,`bagian`.`subsect_id` AS `subsect_id`,`bagian`.`subsect_name` AS `subsect_name`,`gol`.`gol` AS `gol`,`gol`.`idgol` AS `idgol` from ((`kar` join `bagian`) join `gol`) where ((`kar`.`gola` = `gol`.`idgol`) and (`kar`.`subsect_id2` = `bagian`.`subsect_id`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `lembur`
--
DROP TABLE IF EXISTS `lembur`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lembur`  AS  select year(`overtime`.`tgl`) AS `thn`,month(`overtime`.`tgl`) AS `bln`,`overtime`.`id` AS `id`,`karyawan`.`nik` AS `nik2`,concat(`karyawan`.`nama`,' (<strong><small><a href="#" class="text-success" data-toggle="modal" data-target=".modal-kar" onclick="app.getall(\'nik\',',`karyawan`.`nik`,',\'karyawan\')">',`karyawan`.`nik`,'</a></small></strong>)') AS `nik`,if((`overtime`.`type` > 0),'Wajib','SPL') AS `tipe`,`overtime`.`type` AS `type`,`overtime`.`x15` AS `x15`,`overtime`.`x2` AS `x2`,`overtime`.`x3` AS `x3`,`overtime`.`x4` AS `x4`,`overtime`.`tgl` AS `tgl` from (`overtime` join `karyawan`) where (`karyawan`.`nik` = `overtime`.`nik`) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `lembur2`
--
DROP TABLE IF EXISTS `lembur2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lembur2`  AS  select `overtime`.`nik` AS `nik`,`overtime`.`id` AS `id`,`overtime`.`type` AS `type`,`overtime`.`x15` AS `x15`,`overtime`.`x2` AS `x2`,`overtime`.`x3` AS `x3`,`overtime`.`x4` AS `x4`,`overtime`.`tgl` AS `tgl`,year(`overtime`.`tgl`) AS `thn`,month(`overtime`.`tgl`) AS `bln` from `overtime` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `section`
--
DROP TABLE IF EXISTS `section`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `section`  AS  select `dept`.`dept_id` AS `dept_id`,`dept`.`dept_name` AS `dept_name`,`sect`.`sect_id` AS `sect_id`,`sect`.`dept_id2` AS `dept_id2`,`sect`.`sect_name` AS `sect_name` from (`dept` join `sect`) where (`dept`.`dept_id` = `sect`.`dept_id2`) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `thn`
--
DROP TABLE IF EXISTS `thn`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `thn`  AS  select distinct `absen`.`thn` AS `thn` from `absen` ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user`);

--
-- Indeks untuk tabel `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indeks untuk tabel `ewd`
--
ALTER TABLE `ewd`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gol`
--
ALTER TABLE `gol`
  ADD PRIMARY KEY (`idgol`);

--
-- Indeks untuk tabel `kar`
--
ALTER TABLE `kar`
  ADD PRIMARY KEY (`nik`);

--
-- Indeks untuk tabel `libur`
--
ALTER TABLE `libur`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sect`
--
ALTER TABLE `sect`
  ADD PRIMARY KEY (`sect_id`);

--
-- Indeks untuk tabel `subsect`
--
ALTER TABLE `subsect`
  ADD PRIMARY KEY (`subsect_id`);

--
-- Indeks untuk tabel `tipeewd`
--
ALTER TABLE `tipeewd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`kode`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dept`
--
ALTER TABLE `dept`
  MODIFY `dept_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `ewd`
--
ALTER TABLE `ewd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gol`
--
ALTER TABLE `gol`
  MODIFY `idgol` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `libur`
--
ALTER TABLE `libur`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sect`
--
ALTER TABLE `sect`
  MODIFY `sect_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `subsect`
--
ALTER TABLE `subsect`
  MODIFY `subsect_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `tipeewd`
--
ALTER TABLE `tipeewd`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
