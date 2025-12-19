<?php
include 'config/koneksi.php';

// Handle Delete (DELETE)
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id_hapus = mysqli_real_escape_string($koneksi, $_GET['id']);
    $query_hapus = "DELETE FROM kunjungan WHERE id_kunjungan = $id_hapus"; 
    
    if (mysqli_query($koneksi, $query_hapus)) {
        header("Location: daftar.php?status=sukses_hapus");
        exit;
    } else {
        header("Location: daftar.php?status=gagal_hapus");
        exit;
    }
}

// Ambil semua data kunjungan (READ)
$query = "SELECT * FROM kunjungan ORDER BY waktu_masuk DESC";
$hasil = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kunjungan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Data Kunjungan Pasien</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="tambah.php">Input Kunjungan Baru</a>
            <a href="daftar.php">Data Kunjungan (CRUD)</a>
        </nav>
    </header>

    <main>
        <h2>Tabel Daftar Pengunjung</h2>
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'sukses_hapus') echo "<p class='notif'>Data kunjungan berhasil dihapus!</p>"; ?>
            <?php if ($_GET['status'] == 'sukses_edit') echo "<p class='notif'>Data kunjungan berhasil diubah!</p>"; ?>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pengunjung</th>
                    <th>No. ID</th>
                    <th>Nama Pasien</th>
                    <th>Ruangan</th>
                    <th>Tujuan</th>
                    <th>Waktu Masuk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($hasil)): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama_pengunjung']); ?></td>
                    <td><?php echo htmlspecialchars($row['no_identitas']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_pasien']); ?></td>
                    <td><?php echo htmlspecialchars($row['ruangan']); ?></td>
                    <td><?php echo htmlspecialchars($row['tujuan_kunjungan']); ?></td>
                    <td><?php echo $row['waktu_masuk']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id_kunjungan']; ?>">Edit</a> | 
                        <a href="daftar.php?aksi=hapus&id=<?php echo $row['id_kunjungan']; ?>" onclick="return confirm('Yakin menghapus data ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if (mysqli_num_rows($hasil) == 0): ?>
                <tr><td colspan="8">Belum ada data pengunjung yang tercatat.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>