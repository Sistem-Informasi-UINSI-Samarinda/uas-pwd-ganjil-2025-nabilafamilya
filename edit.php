<?php
include 'config/koneksi.php';

$id_edit = mysqli_real_escape_string($koneksi, $_GET['id']);

// Proses Update
if (isset($_POST['submit'])) {
    $nama_pengunjung = mysqli_real_escape_string($koneksi, $_POST['nama_pengunjung']);
    $no_identitas = mysqli_real_escape_string($koneksi, $_POST['no_identitas']);
    $nama_pasien = mysqli_real_escape_string($koneksi, $_POST['nama_pasien']);
    $ruangan = mysqli_real_escape_string($koneksi, $_POST['ruangan']);
    $tujuan_kunjungan = mysqli_real_escape_string($koneksi, $_POST['tujuan_kunjungan']);

    $query_update = "UPDATE kunjungan SET 
                        nama_pengunjung='$nama_pengunjung', 
                        no_identitas='$no_identitas', 
                        nama_pasien='$nama_pasien', 
                        ruangan='$ruangan', 
                        tujuan_kunjungan='$tujuan_kunjungan' 
                    WHERE id_kunjungan=$id_edit";

    if (mysqli_query($koneksi, $query_update)) {
        header("Location: daftar.php?status=sukses_edit");
        exit;
    } else {
        if (mysqli_errno($koneksi) == 1062) {
             $pesan = "Gagal: Nomor ID **$no_identitas** sudah terdaftar pada data lain.";
        } else {
             $pesan = "Gagal mengubah data: " . mysqli_error($koneksi);
        }
    }
}

// Ambil data lama untuk ditampilkan di form
$query_lama = "SELECT * FROM kunjungan WHERE id_kunjungan = $id_edit";
$result_lama = mysqli_query($koneksi, $query_lama);
$data_lama = mysqli_fetch_assoc($result_lama);

if (!$data_lama) {
    die("Data tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Kunjungan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Edit Data Kunjungan</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="tambah.php">Input Kunjungan Baru</a>
            <a href="daftar.php">Data Kunjungan (CRUD)</a>
        </nav>
    </header>

    <main>
        <h2>Form Edit Data Kunjungan Pasien</h2>
        <?php if (isset($pesan)) echo "<p class='notif'>$pesan</p>"; ?>
        
        <form action="" method="POST">
            <label for="nama_pengunjung">Nama Pengunjung:</label>
            <input type="text" id="nama_pengunjung" name="nama_pengunjung" value="<?php echo htmlspecialchars($data_lama['nama_pengunjung']); ?>" required>

            <label for="no_identitas">No. KTP/ID (Unik):</label>
            <input type="text" id="no_identitas" name="no_identitas" value="<?php echo htmlspecialchars($data_lama['no_identitas']); ?>" required maxlength="20">

            <label for="nama_pasien">Nama Pasien yang Dikunjungi:</label>
            <input type="text" id="nama_pasien" name="nama_pasien" value="<?php echo htmlspecialchars($data_lama['nama_pasien']); ?>" required>

            <label for="ruangan">Ruangan/Nomor Kamar Pasien:</label>
            <input type="text" id="ruangan" name="ruangan" value="<?php echo htmlspecialchars($data_lama['ruangan']); ?>" required>

            <label for="tujuan_kunjungan">Tujuan Kunjungan Detail:</label>
            <textarea id="tujuan_kunjungan" name="tujuan_kunjungan" required><?php echo htmlspecialchars($data_lama['tujuan_kunjungan']); ?></textarea>

            <button type="submit" name="submit">Simpan Perubahan</button>
            <a href="daftar.php" class="button-batal">Batal</a>
        </form>
    </main>
</body>
</html>