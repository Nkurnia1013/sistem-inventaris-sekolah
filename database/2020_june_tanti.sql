-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 07 Jan 2021 pada 12.38
-- Versi server: 5.7.24
-- Versi PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2020_june_tanti`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alokasi`
--

CREATE TABLE `alokasi` (
  `idalokasi` int(11) NOT NULL COMMENT 'ID Alokasi',
  `kondisi` varchar(20) DEFAULT NULL COMMENT 'Kondisi Barang',
  `idbarang` varchar(20) DEFAULT NULL COMMENT 'ID Barang',
  `jumlah` int(11) DEFAULT NULL COMMENT 'jumlah',
  `idruangan` varchar(5) NOT NULL,
  `sumber_dana` varchar(30) DEFAULT NULL,
  `tgl_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `alokasi`
--

INSERT INTO `alokasi` (`idalokasi`, `kondisi`, `idbarang`, `jumlah`, `idruangan`, `sumber_dana`, `tgl_input`) VALUES
(3, 'Baik', '7', 6, '2', '', '2020-09-21 12:44:31'),
(8, 'Baik', 'b06', 30, '1', 'SD001', '2020-09-21 12:44:31'),
(9, 'Baik', 'b06', 9, '1', 'SD001', '2020-09-21 12:44:31'),
(11, 'Baik', 'E.4.C.1', 8, 'R001', 'SD001', '2020-09-21 12:44:31'),
(12, 'Baik', 'E.4.C.1', 1, 'R001', 'SD001', '2020-09-21 12:44:31'),
(13, 'Baik', 'E.4.C.1.310.01.05', 1, 'R001', 'SD001', '2020-09-21 12:44:31'),
(14, 'Baik', 'E.4.C.1.310.02.19', 10, 'R001', 'SD001', '2020-09-21 12:44:31'),
(15, 'Baik', 'BT015', 3, 'R001', 'SD001', '2020-09-21 12:44:31'),
(16, 'Baik', 'E.4.C.1.310.04.01', 12, 'R001', 'SD001', '2020-09-21 12:44:31'),
(17, 'Baik', 'BD014-N001', 7, 'R001', 'SD001', '2020-09-21 12:44:31'),
(18, 'Baik', 'KS02-B001', 19, 'R001', 'SD001', '2020-09-21 12:44:31'),
(19, 'Baik', 'MJ01-A001', 19, 'R001', 'SD001', '2020-09-21 12:44:31'),
(20, 'Baik', 'GN08-H001', 1, 'R001', 'SD001', '2020-09-21 12:44:31'),
(21, 'Baik', 'PT03-C001', 1, 'R001', 'SD001', '2020-09-21 12:44:31'),
(22, 'Baik', 'KA04-D001', 1, 'R001', 'SD001', '2020-09-21 12:44:31'),
(23, 'Baik', 'FP06-F001', 2, 'R001', 'SD001', '2020-09-21 12:44:31'),
(24, 'Baik', 'FP06-F002', 1, 'R001', 'SD001', '2020-09-21 12:44:31'),
(25, 'Baik', 'KS02-B001', 20, 'R001', 'SD001', '2020-09-21 12:44:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `idbarang` varchar(20) NOT NULL,
  `nama_barang` varchar(15) DEFAULT NULL COMMENT 'Nama Barang',
  `habisPakai` varchar(5) DEFAULT NULL COMMENT 'Habis Pakai',
  `jenis` varchar(30) DEFAULT NULL,
  `nopabrik` varchar(30) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `merk` varchar(30) DEFAULT NULL,
  `bahan` varchar(20) DEFAULT NULL,
  `ukuran` varchar(30) DEFAULT NULL,
  `satuan` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`idbarang`, `nama_barang`, `habisPakai`, `jenis`, `nopabrik`, `foto`, `merk`, `bahan`, `ukuran`, `satuan`) VALUES
('BR001', 'Pena paster ', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR002', 'Pena kenko', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR003', 'spidol', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR004', 'Kertas F4', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR005', 'Kertas A4', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR006', 'Kertas jilid', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR007', 'Isi stapler', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR008', 'Lak ban jilid', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR009', 'penghapus', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR010', 'Stopmap folio', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR011', 'Lem kertas', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR012', 'pensil', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR013', 'Paper  clip', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR014', 'Tinta printer', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('BR015', 'amplop', 'Ya', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('FP06-F001', 'foto presiden &', 'Tidak', 'Foto Presiden & Wakil', '', NULL, NULL, NULL, NULL, NULL),
('FP06-F002', 'foto wakil pres', 'Tidak', 'Foto Presiden & Wakil', '', NULL, NULL, NULL, NULL, NULL),
('GN08-H001', 'gorden ', 'Tidak', 'Bendera', '', '5f5b1d94b9e4c.jpeg', NULL, NULL, NULL, NULL),
('JD09-I001', 'jam dinding', 'Tidak', 'Jam Dinding', '', '5f5b1c932635e.jpeg', NULL, NULL, NULL, NULL),
('KA04-D001', 'kipas angin gan', 'Tidak', 'Kipas Angin', '', '5f5b1cf15848c.jpeg', NULL, NULL, NULL, NULL),
('KS02-B001', 'kursi siswa', 'Tidak', 'Kursi', '', '5f5b1c334fe94.jpeg', NULL, NULL, NULL, NULL),
('KS02-B002', 'kursi guru', 'Tidak', 'Kursi', '', '5f5b1ddf661f9.jpeg', NULL, NULL, NULL, NULL),
('MJ01-A001', 'meja siswa', 'Tidak', 'Bendera', '', '5f5b1cb16277b.jpeg', NULL, NULL, NULL, NULL),
('MJ01-A002', 'meja guru', 'Tidak', 'Meja', '', '5f5b1dc7ce106.jpeg', NULL, NULL, NULL, NULL),
('PT03-C001', 'papan tulis', 'Tidak', 'Papan Tulis', '', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_permintaan`
--

CREATE TABLE `detail_permintaan` (
  `iddetail` int(11) NOT NULL,
  `idbarang` varchar(20) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `idtransaksi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_permintaan`
--

INSERT INTO `detail_permintaan` (`iddetail`, `idbarang`, `qty`, `idtransaksi`) VALUES
(8, 'BR001', 2, 7),
(9, 'BR002', 1, 8),
(10, 'BR001', 1, 8),
(11, 'BR003', 2, 9),
(12, 'BR005', 2, 9),
(13, 'BR002', 8, 10),
(15, 'BR005', 1, 10),
(16, 'BR008', 1, 11),
(17, 'BR002', 2, 12),
(18, 'BR007', 5, 13);

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `nip` varchar(16) NOT NULL COMMENT 'NIP',
  `nama` varchar(25) DEFAULT NULL COMMENT 'Nama',
  `alamat` varchar(100) DEFAULT NULL COMMENT 'Alamat',
  `nohp` varchar(12) NOT NULL COMMENT 'No HP',
  `pass` varchar(15) DEFAULT NULL,
  `status_guru` varchar(25) NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `status_kawin` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`nip`, `nama`, `alamat`, `nohp`, `pass`, `status_guru`, `tgl_lahir`, `status_kawin`) VALUES
('1967091019910320', 'Hernawaty', 'Purnama', '081234545654', '123', 'Guru Mapel', NULL, NULL),
('-1', 'Andriani Noita', 'JL. Kesuma', '081243545612', '123', 'Wali Kelas', NULL, NULL),
('-2', 'Suhaila', 'JL. Nelayan laut', '081267654345', '123', 'Guru Mapel', NULL, NULL),
('-3', 'Dewi Febrianny', 'JL. Paris', '081343455456', '1234', 'Guru Mapel', NULL, NULL),
('-4', 'Rika Mentari,', 'Tanjung palas', '0823443455', '123', 'Wali Kelas', NULL, NULL),
('-5', 'Rahma Dianti', 'JL.Teladan', '0852345676', '123', 'Wali Kelas', NULL, NULL),
('1965051519920320', 'Yusnelawati', 'Bukit timah', '0852346543', '123', 'Guru Mapel', NULL, NULL),
('1965051519920320', 'RIKA', 'TANJUNG PALAS', '087654321', '123', 'Wali Kelas', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `idruangan` varchar(5) NOT NULL,
  `ruangan` varchar(20) DEFAULT NULL COMMENT 'Nama Ruangan',
  `penanggung_jawab` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`idruangan`, `ruangan`, `penanggung_jawab`) VALUES
('R001', 'Ruang kelas VII', 'G001'),
('R002', 'Ruang kelas VIII', 'G002'),
('R003', 'Ruang kelas IX', 'G003');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rusak`
--

CREATE TABLE `rusak` (
  `idrusak` int(11) NOT NULL,
  `idalokasi` int(11) DEFAULT NULL,
  `jum` int(11) DEFAULT NULL,
  `tgl_rusak` date DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `bukti_rusak` varchar(100) DEFAULT NULL,
  `kondisi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rusak`
--

INSERT INTO `rusak` (`idrusak`, `idalokasi`, `jum`, `tgl_rusak`, `keterangan`, `bukti_rusak`, `kondisi`) VALUES
(4, 10, 1, '2020-09-09', '', NULL, 'Rusak Berat'),
(5, 11, 1, '2020-09-10', '', NULL, 'Kurang Baik'),
(7, 13, 1, '2020-09-10', '', NULL, 'Kurang Baik'),
(8, 13, 0, '2020-09-10', '', NULL, 'Rusak Berat'),
(9, 14, 1, '2020-09-10', '', NULL, 'Kurang Baik'),
(10, 13, 0, '2020-09-10', '', NULL, 'Kurang Baik'),
(11, 17, 1, '2020-09-11', '', '5f5af684200f1.jpeg', 'Kurang Baik'),
(12, 18, 1, '2020-09-11', '', NULL, 'Kurang Baik'),
(13, 18, 17, '2020-09-11', '', NULL, 'Kurang Baik'),
(14, 19, 19, '2020-09-11', '', NULL, 'Kurang Baik'),
(15, 20, 1, '2020-09-12', '', NULL, 'Kurang Baik'),
(16, 25, 1, '2020-09-12', '', NULL, 'Kurang Baik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_keluar`
--

CREATE TABLE `transaksi_keluar` (
  `idtransaksi` int(11) NOT NULL,
  `nip` varchar(16) DEFAULT NULL COMMENT 'ID Guru',
  `tgl` date DEFAULT NULL COMMENT 'Tanggal Transaksi',
  `status` varchar(10) NOT NULL DEFAULT 'Proses' COMMENT 'Status Transaksi'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaksi_keluar`
--

INSERT INTO `transaksi_keluar` (`idtransaksi`, `nip`, `tgl`, `status`) VALUES
(8, 'G001', '2020-09-10', 'ACC'),
(9, 'G001', '2020-09-10', 'Dibatalkan'),
(10, 'G001', '2020-09-10', 'ACC'),
(11, 'G001', '2020-09-11', 'ACC'),
(12, 'G001', NULL, 'Proses'),
(13, '1967091019910320', '2020-09-22', 'Menunggu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_masuk`
--

CREATE TABLE `transaksi_masuk` (
  `idtransaksi` int(11) NOT NULL,
  `tgl` date DEFAULT NULL COMMENT 'Tanggal Transaksi',
  `idbarang` varchar(20) DEFAULT NULL COMMENT 'Barang',
  `qty` int(11) DEFAULT NULL COMMENT 'Qty',
  `ket` varchar(100) DEFAULT NULL COMMENT 'Keterangan'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaksi_masuk`
--

INSERT INTO `transaksi_masuk` (`idtransaksi`, `tgl`, `idbarang`, `qty`, `ket`) VALUES
(20, '2020-09-10', 'BR001', 24, ''),
(21, '2020-09-10', 'BR002', 10, ''),
(22, '2020-09-10', 'BR003', 5, ''),
(23, '2020-09-10', 'BR005', 3, ''),
(24, '2020-09-10', 'BR004', 5, ''),
(25, '2020-09-10', 'BR006', 24, ''),
(26, '2020-09-10', 'BR007', 10, ''),
(27, '2020-09-10', 'BR008', 20, ''),
(28, '2020-09-10', 'BR002', 89, ''),
(29, '2020-09-11', 'BR001', 24, ''),
(30, '2020-09-11', 'BR002', 24, ''),
(31, '2020-09-11', 'BR003', 24, ''),
(32, '2020-09-11', 'BR004', 5, ''),
(33, '2020-09-11', 'BR005', 5, ''),
(34, '2020-09-11', 'BR001', 24, ''),
(35, '2020-09-11', 'BR011', 10, ''),
(36, '2020-09-11', 'BR014', 10, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user` varchar(10) NOT NULL COMMENT 'Username',
  `pass` varchar(15) DEFAULT NULL COMMENT 'Password',
  `nama` varchar(25) DEFAULT NULL COMMENT 'Nama Lengkap',
  `level` varchar(15) DEFAULT NULL COMMENT 'Level Akses'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user`, `pass`, `nama`, `level`) VALUES
('Seska', '123', 'Seska Widayanti, S.E', 'Kepala Sekolah'),
('Tanti', '123', 'Tanti Nurcaini', 'TU'),
('TIRA', '123', 'TIRA MASTI', 'Kepala Sekolah');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alokasi`
--
ALTER TABLE `alokasi`
  ADD PRIMARY KEY (`idalokasi`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`idbarang`);

--
-- Indeks untuk tabel `detail_permintaan`
--
ALTER TABLE `detail_permintaan`
  ADD PRIMARY KEY (`iddetail`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`nohp`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`idruangan`);

--
-- Indeks untuk tabel `rusak`
--
ALTER TABLE `rusak`
  ADD PRIMARY KEY (`idrusak`);

--
-- Indeks untuk tabel `transaksi_keluar`
--
ALTER TABLE `transaksi_keluar`
  ADD PRIMARY KEY (`idtransaksi`);

--
-- Indeks untuk tabel `transaksi_masuk`
--
ALTER TABLE `transaksi_masuk`
  ADD PRIMARY KEY (`idtransaksi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alokasi`
--
ALTER TABLE `alokasi`
  MODIFY `idalokasi` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Alokasi', AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `detail_permintaan`
--
ALTER TABLE `detail_permintaan`
  MODIFY `iddetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `rusak`
--
ALTER TABLE `rusak`
  MODIFY `idrusak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `transaksi_keluar`
--
ALTER TABLE `transaksi_keluar`
  MODIFY `idtransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `transaksi_masuk`
--
ALTER TABLE `transaksi_masuk`
  MODIFY `idtransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
