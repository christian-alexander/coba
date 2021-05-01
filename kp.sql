-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2021 at 06:25 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kp`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosbing`
--

CREATE TABLE `dosbing` (
  `timestamp_dosbing` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_dosbing` int(50) NOT NULL,
  `email_dosbing` char(50) NOT NULL,
  `no_unik_dosbing` char(20) NOT NULL,
  `nama_dosbing` char(100) NOT NULL,
  `no_wa_dosbing` char(15) NOT NULL,
  `id_instansi_dosbing` int(50) DEFAULT NULL,
  `acc_by_dosbing` varchar(100) NOT NULL,
  `password_dosbing` varchar(1000) NOT NULL,
  `status_dosbing` char(5) NOT NULL DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dosbing`
--

INSERT INTO `dosbing` (`timestamp_dosbing`, `id_dosbing`, `email_dosbing`, `no_unik_dosbing`, `nama_dosbing`, `no_wa_dosbing`, `id_instansi_dosbing`, `acc_by_dosbing`, `password_dosbing`, `status_dosbing`) VALUES
('2021-04-14 03:37:34', 2, 'dosen2@gmail.com', '77700002', 'DosenDua', '08221789', 0, 'Tata Usaha', '$2y$10$vpKpfi7DVo.5Tro5.2vDke4YUvjkSa7C0Ghs7MD62qElmAMTmNuMK', 'on'),
('2021-04-26 13:19:08', 6, 'dosen1@email.mail', '77700001', 'DosenSatu', '082233574795', 0, 'Koordinator KP', '$2y$10$vpKpfi7DVo.5Tro5.2vDke4YUvjkSa7C0Ghs7MD62qElmAMTmNuMK', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `instansi`
--

CREATE TABLE `instansi` (
  `timestamp_instansi` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_instansi` int(50) NOT NULL,
  `nama_instansi` char(100) NOT NULL,
  `no_telepon_instansi` char(15) NOT NULL,
  `no_fax_instansi` char(15) NOT NULL,
  `email_instansi` char(100) NOT NULL,
  `alamat_instansi` char(100) NOT NULL,
  `status_instansi` char(3) NOT NULL DEFAULT 'on',
  `acc_by_instansi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instansi`
--

INSERT INTO `instansi` (`timestamp_instansi`, `id_instansi`, `nama_instansi`, `no_telepon_instansi`, `no_fax_instansi`, `email_instansi`, `alamat_instansi`, `status_instansi`, `acc_by_instansi`) VALUES
('2021-02-21 10:06:54', 0, 'Universitas Widya Kartika', '03124568', '03124568', 'admin@widyakartika.ac.id', 'Sutorejo Prima Utara II/1', 'on', 'Tata Usaha'),
('2021-02-10 03:14:41', 1, 'UD. Bangkit', '031245679', '031245679', 'bangkit@gmail.com', 'Jalan Bangkit No. 2-4', 'on', 'Tata Usaha'),
('2021-02-12 13:01:46', 2, 'PT. Berkarya', '03198980', '03198980', 'berkarya@berkarya.com', 'Jl. Karya Bakti No.5', 'on', 'Tata Usaha'),
('2021-02-04 09:49:02', 3, 'PT. Jaya', '031989809', '031989809', 'jaya@gmail.com', 'jl.buah', 'on', 'Tata Usaha');

-- --------------------------------------------------------

--
-- Table structure for table `mhs`
--

CREATE TABLE `mhs` (
  `timestamp_mhs` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_mhs` int(50) NOT NULL,
  `email_mhs` char(50) NOT NULL,
  `no_unik_mhs` char(20) NOT NULL,
  `nama_mhs` char(100) NOT NULL,
  `no_wa_mhs` char(15) NOT NULL,
  `id_instansi_mhs` int(50) DEFAULT NULL,
  `id_dosbing_mhs` int(50) DEFAULT NULL,
  `id_pemlap_mhs` int(50) DEFAULT NULL,
  `acc_by_mhs` varchar(100) NOT NULL,
  `jam_magang` char(10) NOT NULL DEFAULT '0',
  `password_mhs` varchar(1000) NOT NULL,
  `status_mhs` varchar(5) NOT NULL DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mhs`
--

INSERT INTO `mhs` (`timestamp_mhs`, `id_mhs`, `email_mhs`, `no_unik_mhs`, `nama_mhs`, `no_wa_mhs`, `id_instansi_mhs`, `id_dosbing_mhs`, `id_pemlap_mhs`, `acc_by_mhs`, `jam_magang`, `password_mhs`, `status_mhs`) VALUES
('2021-02-11 08:09:20', 7, 'mhs2@gmail.com', '99900002', 'MahasiswaDua', '08123456789', 0, 2, NULL, 'Tata Usaha', '0', '$2y$10$vpKpfi7DVo.5Tro5.2vDke4YUvjkSa7C0Ghs7MD62qElmAMTmNuMK', 'on'),
('2021-03-12 03:09:03', 12, 'satdua86@gmail.com', '99900003', 'satdua', '0288292929', 0, 6, NULL, 'Tata Usaha', '0', '$2y$10$ieVaJcinjj6evnp2Ysj18eIKv4HOSXymUYJVBAuNgSd3s5GAIv4ku', 'on'),
('2021-04-26 13:15:42', 22, 'mhs1@gmail.com', '99900001', 'MahasiswaSatu', '082233574795', 0, 6, NULL, 'Koordinator KP', '0', '$2y$10$ieVaJcinjj6evnp2Ysj18eIKv4HOSXymUYJVBAuNgSd3s5GAIv4ku', 'on');

--
-- Triggers `mhs`
--
DELIMITER $$
CREATE TRIGGER `trigger_status_magang` AFTER INSERT ON `mhs` FOR EACH ROW INSERT INTO status_magang (id_mhs,time1) VALUES(NEW.id_mhs,CURRENT_TIMESTAMP)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `nama_status_magang`
--

CREATE TABLE `nama_status_magang` (
  `id_status` int(1) NOT NULL,
  `nama_status` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nama_status_magang`
--

INSERT INTO `nama_status_magang` (`id_status`, `nama_status`) VALUES
(1, 'Belum Mengajukan Calon Instansi'),
(2, 'Menunggu Surat TU'),
(3, 'Menunggu Persetujuan Pembimbing Lapangan'),
(4, 'Proses Magang'),
(5, 'Menyelesaikan Laporan'),
(6, 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `pemlap`
--

CREATE TABLE `pemlap` (
  `timestamp_pemlap` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_pemlap` int(50) NOT NULL,
  `email_pemlap` char(50) NOT NULL,
  `no_unik_pemlap` char(20) NOT NULL,
  `nama_pemlap` char(100) NOT NULL,
  `no_wa_pemlap` char(15) NOT NULL,
  `id_instansi_pemlap` int(50) DEFAULT NULL,
  `acc_by_pemlap` varchar(100) NOT NULL,
  `password_pemlap` varchar(1000) NOT NULL,
  `status_pemlap` char(5) NOT NULL DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemlap`
--

INSERT INTO `pemlap` (`timestamp_pemlap`, `id_pemlap`, `email_pemlap`, `no_unik_pemlap`, `nama_pemlap`, `no_wa_pemlap`, `id_instansi_pemlap`, `acc_by_pemlap`, `password_pemlap`, `status_pemlap`) VALUES
('2021-04-26 13:45:08', 20, 'pemlap1@gmail.com', '88800001', 'PemlapSatu', '08123456789', 0, 'Koordinator KP', '$2y$10$vpKpfi7DVo.5Tro5.2vDke4YUvjkSa7C0Ghs7MD62qElmAMTmNuMK', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `sg_dosbing`
--

CREATE TABLE `sg_dosbing` (
  `timestamp_sg_dosbing` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_sg_dosbing` int(50) NOT NULL,
  `email_sg_dosbing` char(100) NOT NULL,
  `no_unik_sg_dosbing` char(20) NOT NULL,
  `password_sg_dosbing` varchar(1000) NOT NULL,
  `nama_sg_dosbing` char(100) NOT NULL,
  `no_wa_sg_dosbing` char(15) NOT NULL,
  `id_instansi_sg_dosbing` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sg_dosbing`
--

INSERT INTO `sg_dosbing` (`timestamp_sg_dosbing`, `id_sg_dosbing`, `email_sg_dosbing`, `no_unik_sg_dosbing`, `password_sg_dosbing`, `nama_sg_dosbing`, `no_wa_sg_dosbing`, `id_instansi_sg_dosbing`) VALUES
('2021-04-25 04:29:41', 4, 'zjsj@dkkd.dk', '29922828', '19191919', 'dujdjjx', '292288229', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sg_mhs`
--

CREATE TABLE `sg_mhs` (
  `timestamp_sg_mhs` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_sg_mhs` int(50) NOT NULL,
  `email_sg_mhs` char(100) NOT NULL,
  `no_unik_sg_mhs` char(20) NOT NULL,
  `password_sg_mhs` varchar(1000) NOT NULL,
  `nama_sg_mhs` char(100) NOT NULL,
  `no_wa_sg_mhs` char(15) NOT NULL,
  `id_instansi_sg_mhs` int(50) DEFAULT NULL,
  `id_dosbing_sg_mhs` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sg_mhs`
--

INSERT INTO `sg_mhs` (`timestamp_sg_mhs`, `id_sg_mhs`, `email_sg_mhs`, `no_unik_sg_mhs`, `password_sg_mhs`, `nama_sg_mhs`, `no_wa_sg_mhs`, `id_instansi_sg_mhs`, `id_dosbing_sg_mhs`) VALUES
('2021-04-25 04:34:12', 7, 'kd@dkkd.dk', '23232323', '12121212', 'sjsjjs', '12121212', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `status_magang`
--

CREATE TABLE `status_magang` (
  `timestamp_status_magang` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_status_magang` int(11) NOT NULL,
  `id_mhs` int(50) NOT NULL,
  `id_status` int(1) NOT NULL DEFAULT 1,
  `time1` char(50) NOT NULL,
  `time2` char(50) NOT NULL,
  `time3` char(50) NOT NULL,
  `time4` char(50) NOT NULL,
  `time5` char(50) NOT NULL,
  `time6` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status_magang`
--

INSERT INTO `status_magang` (`timestamp_status_magang`, `id_status_magang`, `id_mhs`, `id_status`, `time1`, `time2`, `time3`, `time4`, `time5`, `time6`) VALUES
('2021-04-14 14:24:09', 3, 7, 1, '2021-04-14 19:15:23', '', '', '', '', ''),
('2021-04-14 14:55:26', 4, 12, 1, '2021-04-14 19:15:23', '', '', '', '', ''),
('2021-04-26 13:15:42', 12, 22, 1, '2021-04-26 20:15:42', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `su`
--

CREATE TABLE `su` (
  `id_su` int(50) NOT NULL,
  `email_su` varchar(100) NOT NULL,
  `no_unik_su` char(20) NOT NULL,
  `password_su` varchar(1000) NOT NULL,
  `nama_su` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `su`
--

INSERT INTO `su` (`id_su`, `email_su`, `no_unik_su`, `password_su`, `nama_su`) VALUES
(1, 'su1', 'su1', '$2y$10$vpKpfi7DVo.5Tro5.2vDke4YUvjkSa7C0Ghs7MD62qElmAMTmNuMK', 'Koordinator KP'),
(2, 'su2', 'su2', '$2y$10$vpKpfi7DVo.5Tro5.2vDke4YUvjkSa7C0Ghs7MD62qElmAMTmNuMK', 'Tata Usaha');

-- --------------------------------------------------------

--
-- Table structure for table `template_izin`
--

CREATE TABLE `template_izin` (
  `id` int(11) NOT NULL,
  `nama_file` char(200) NOT NULL,
  `subjek_email` char(200) NOT NULL,
  `isi_email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `template_izin`
--

INSERT INTO `template_izin` (`id`, `nama_file`, `subjek_email`, `isi_email`) VALUES
(1, 'Template Izin (2) (2).docx', 'Pemberitahuan Izin KP', 'Kepada Yth,\r\n${nama_cp}\r\n${nama_ci}\r\n\r\nTerima kasih telah bersedia menerima mahasiswa kami atas nama ${nama_mhs} untuk dapat melakukan Kerja Praktek di perusahaan yang Bapak/Ibu pimpin. Berikut kami lampirkan surat izin agar mahasiswa kami dapat melaksanakan Kerja Praktek. \r\n\r\nHormat kami,\r\nUniversitas Widya Kartika\r\n\r\nSurabaya,\r\n${tanggal}');

-- --------------------------------------------------------

--
-- Table structure for table `tppi`
--

CREATE TABLE `tppi` (
  `timestamp_tppi` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_tppi` int(11) NOT NULL,
  `id_mhs_tppi` int(11) DEFAULT NULL,
  `id_dosbing_tppi` int(11) DEFAULT NULL,
  `id_pemlap_tppi` int(11) DEFAULT NULL,
  `id_instansi_tppi` int(11) DEFAULT NULL,
  `nama_pemlap_tppi` varchar(100) NOT NULL,
  `email_pemlap_tppi` varchar(100) NOT NULL,
  `no_wa_pemlap_tppi` varchar(15) NOT NULL,
  `no_unik_pemlap_tppi` varchar(20) NOT NULL,
  `id_instansi_pemlap_tppi` int(11) DEFAULT NULL,
  `nama_instansi_tppi` varchar(100) NOT NULL,
  `email_instansi_tppi` varchar(100) NOT NULL,
  `no_telepon_instansi_tppi` varchar(15) NOT NULL,
  `no_fax_instansi_tppi` varchar(15) NOT NULL,
  `alamat_instansi_tppi` varchar(200) NOT NULL,
  `acc_kampus_tppi` varchar(10) NOT NULL DEFAULT 'diajukan',
  `acc_pemlap_tppi` varchar(10) NOT NULL DEFAULT 'diajukan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='tppi = temp pengajuan pemlap dan instansi';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosbing`
--
ALTER TABLE `dosbing`
  ADD PRIMARY KEY (`id_dosbing`),
  ADD KEY `instansi` (`id_instansi_dosbing`);

--
-- Indexes for table `instansi`
--
ALTER TABLE `instansi`
  ADD PRIMARY KEY (`id_instansi`),
  ADD KEY `instansi_acc_by` (`acc_by_instansi`);

--
-- Indexes for table `mhs`
--
ALTER TABLE `mhs`
  ADD PRIMARY KEY (`id_mhs`),
  ADD KEY `id_instansi` (`id_instansi_mhs`),
  ADD KEY `id_dosbing` (`id_dosbing_mhs`),
  ADD KEY `id_pemlap` (`id_pemlap_mhs`);

--
-- Indexes for table `nama_status_magang`
--
ALTER TABLE `nama_status_magang`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `pemlap`
--
ALTER TABLE `pemlap`
  ADD PRIMARY KEY (`id_pemlap`),
  ADD KEY `id_instansi` (`id_instansi_pemlap`);

--
-- Indexes for table `sg_dosbing`
--
ALTER TABLE `sg_dosbing`
  ADD PRIMARY KEY (`id_sg_dosbing`),
  ADD KEY `id_instansi` (`id_instansi_sg_dosbing`);

--
-- Indexes for table `sg_mhs`
--
ALTER TABLE `sg_mhs`
  ADD PRIMARY KEY (`id_sg_mhs`),
  ADD KEY `id_instansi` (`id_instansi_sg_mhs`),
  ADD KEY `id_dosbing` (`id_dosbing_sg_mhs`);

--
-- Indexes for table `status_magang`
--
ALTER TABLE `status_magang`
  ADD PRIMARY KEY (`id_status_magang`),
  ADD KEY `id_utama` (`id_mhs`),
  ADD KEY `id_status` (`id_status`);

--
-- Indexes for table `su`
--
ALTER TABLE `su`
  ADD PRIMARY KEY (`id_su`);

--
-- Indexes for table `template_izin`
--
ALTER TABLE `template_izin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tppi`
--
ALTER TABLE `tppi`
  ADD PRIMARY KEY (`id_tppi`),
  ADD KEY `id_mhs_tppi1` (`id_mhs_tppi`),
  ADD KEY `id_dosbing_tppi1` (`id_dosbing_tppi`),
  ADD KEY `id_pemlap_tppi1` (`id_pemlap_tppi`),
  ADD KEY `id_instansi_tppi1` (`id_instansi_tppi`),
  ADD KEY `id_instansi_pemlap_tppi1` (`id_instansi_pemlap_tppi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dosbing`
--
ALTER TABLE `dosbing`
  MODIFY `id_dosbing` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id_instansi` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `mhs`
--
ALTER TABLE `mhs`
  MODIFY `id_mhs` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pemlap`
--
ALTER TABLE `pemlap`
  MODIFY `id_pemlap` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sg_dosbing`
--
ALTER TABLE `sg_dosbing`
  MODIFY `id_sg_dosbing` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sg_mhs`
--
ALTER TABLE `sg_mhs`
  MODIFY `id_sg_mhs` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `status_magang`
--
ALTER TABLE `status_magang`
  MODIFY `id_status_magang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `su`
--
ALTER TABLE `su`
  MODIFY `id_su` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tppi`
--
ALTER TABLE `tppi`
  MODIFY `id_tppi` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosbing`
--
ALTER TABLE `dosbing`
  ADD CONSTRAINT `dosbing_ibfk_1` FOREIGN KEY (`id_instansi_dosbing`) REFERENCES `instansi` (`id_instansi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `mhs`
--
ALTER TABLE `mhs`
  ADD CONSTRAINT `mhs_ibfk_1` FOREIGN KEY (`id_instansi_mhs`) REFERENCES `instansi` (`id_instansi`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mhs_ibfk_2` FOREIGN KEY (`id_dosbing_mhs`) REFERENCES `dosbing` (`id_dosbing`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mhs_ibfk_5` FOREIGN KEY (`id_pemlap_mhs`) REFERENCES `pemlap` (`id_pemlap`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pemlap`
--
ALTER TABLE `pemlap`
  ADD CONSTRAINT `pemlap_ibfk_1` FOREIGN KEY (`id_instansi_pemlap`) REFERENCES `instansi` (`id_instansi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `sg_dosbing`
--
ALTER TABLE `sg_dosbing`
  ADD CONSTRAINT `sg_dosbing_ibfk_1` FOREIGN KEY (`id_instansi_sg_dosbing`) REFERENCES `instansi` (`id_instansi`);

--
-- Constraints for table `sg_mhs`
--
ALTER TABLE `sg_mhs`
  ADD CONSTRAINT `sg_mhs_ibfk_1` FOREIGN KEY (`id_dosbing_sg_mhs`) REFERENCES `dosbing` (`id_dosbing`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sg_mhs_ibfk_3` FOREIGN KEY (`id_instansi_sg_mhs`) REFERENCES `instansi` (`id_instansi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `status_magang`
--
ALTER TABLE `status_magang`
  ADD CONSTRAINT `status_magang_ibfk_1` FOREIGN KEY (`id_mhs`) REFERENCES `mhs` (`id_mhs`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `status_magang_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `nama_status_magang` (`id_status`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
