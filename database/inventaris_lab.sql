-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Apr 2026 pada 19.05
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris_lab`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventaris`
--

CREATE TABLE `inventaris` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `kondisi` enum('Baik','Rusak Ringan','Rusak Berat') DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `inventaris`
--

INSERT INTO `inventaris` (`id`, `kode_barang`, `nama_barang`, `jumlah`, `kondisi`, `lokasi`, `keterangan`) VALUES
(7, 'SK/SMKUNU/2026', 'KOMPUTER CLIEN', 10, 'Baik', 'LAB', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `peminjam` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan') DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `kode_barang`, `nama_barang`, `peminjam`, `jumlah`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(1, 'SI/SMKUNU/2026', 'LAN TESTER', 'ulum', 1, '2026-02-03', '2026-02-04', 'Dikembalikan'),
(2, 'SK/SMKUNU/2026', 'KOMPUTER CLIEN', 'ulum', 2, '2026-02-04', '2026-02-05', 'Dikembalikan'),
(3, 'SK/SMKUNU/2026', 'KOMPUTER CLIEN', 'SRI', 5, '2026-02-04', '2026-02-04', 'Dikembalikan'),
(4, 'SP/SMKUNU/2026', 'MONITOR', 'ERVIN', 2, '2026-02-05', '2026-02-05', 'Dikembalikan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_lab`
--

CREATE TABLE `pengajuan_lab` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `pemohon` varchar(100) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `keperluan` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Menunggu',
  `dibuat_oleh` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `dibaca` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengajuan_lab`
--

INSERT INTO `pengajuan_lab` (`id`, `tanggal`, `jam_mulai`, `jam_selesai`, `pemohon`, `kelas`, `keperluan`, `status`, `dibuat_oleh`, `created_at`, `dibaca`) VALUES
(1, '2026-02-09', '10:00:00', '10:50:00', 'PAK SRI', 'XI TKJ 2', 'PRAKTEK', 'Disetujui', 'sri', '2026-02-09 02:47:20', '1'),
(2, '0000-00-00', '00:00:00', '00:00:00', '', '', '', 'Ditolak', 'sri', '2026-02-09 02:51:52', '1'),
(3, '0000-00-00', '00:00:00', '00:00:00', '', '', '', 'Ditolak', 'sri', '2026-02-09 02:52:10', '1'),
(4, '0000-00-00', '00:00:00', '00:00:00', '', '', '', 'Ditolak', 'sri', '2026-02-09 02:52:11', '1'),
(5, '0000-00-00', '00:00:00', '00:00:00', '', '', '', 'Ditolak', 'sri', '2026-02-09 02:52:16', '1'),
(6, '2026-02-09', '10:50:00', '11:00:00', 'PAK ULUM', 'XI TKJ 2', 'PRAKTEK', 'Disetujui', 'admin', '2026-02-09 02:58:17', '1'),
(7, '2026-04-29', '10:00:00', '10:30:00', 'PAK ULUM', 'XI TKJ 2', 'PRAKTEK', 'Disetujui', NULL, '2026-04-28 15:03:29', '1'),
(8, '2026-04-29', '12:00:00', '12:30:00', 'PAK SRI', 'XI TKJ 1', 'PRAKTEK', 'Disetujui', NULL, '2026-04-28 15:12:15', '1'),
(9, '2026-04-30', '07:00:00', '08:00:00', 'PAK ULUM', 'XII', 'TES', 'Disetujui', NULL, '2026-04-28 15:14:32', '1'),
(10, '2026-04-30', '12:12:00', '12:24:00', 'PAK ULUM', 'XI TKJ 2', 'p', 'Menunggu', NULL, '2026-04-28 15:44:55', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','petugas') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(3, 'admin', '$2y$10$Z1tXul4.ykOQ4gFnXtzLm.qSIR1Ydibk5z/3BgV.MnJVK7dD7YbDW', 'admin'),
(4, 'sri', '$2y$10$7PgmcS2LgAjASv9Ppz.I3ud6NHWWk3TnxRpF4Zwub44SmsS139ZAa', 'petugas');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengajuan_lab`
--
ALTER TABLE `pengajuan_lab`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_lab`
--
ALTER TABLE `pengajuan_lab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
