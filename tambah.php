<?php
include 'config/koneksi.php';

if (isset($_POST['submit'])) {
    // Pengamanan data input
    $nama_pengunjung = mysqli_real_escape_string($koneksi, $_POST['nama_pengunjung']);
    $no_identitas = mysqli_real_escape_string($koneksi, $_POST['no_identitas']);
    $nama_pasien = mysqli_real_escape_string($koneksi, $_POST['nama_pasien']);
    $ruangan = mysqli_real_escape_string($koneksi, $_POST['ruangan']);
    $tujuan_kunjungan = mysqli_real_escape_string($koneksi, $_POST['tujuan_kunjungan']);

    // Query untuk menyimpan data
    $query = "INSERT INTO kunjungan (nama_pengunjung, no_identitas, nama_pasien, ruangan, tujuan_kunjungan) 
              VALUES ('$nama_pengunjung', '$no_identitas', '$nama_pasien', '$ruangan', '$tujuan_kunjungan')";

    if (mysqli_query($koneksi, $query)) {
        $pesan = "Kunjungan atas nama **$nama_pengunjung** berhasil dicatat!";
    } else {
        if (mysqli_errno($koneksi) == 1062) {
            $pesan = "Gagal: Nomor Identitas **$no_identitas** sudah terdaftar sebagai pengunjung.";
        } else {
            $pesan = "Gagal mencatat kunjungan: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Kunjungan Baru</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Input Kunjungan Baru</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="tambah.php">Input Kunjungan Baru</a>
            <a href="daftar.php">Data Kunjungan (CRUD)</a>
        </nav>
    </header>

    <main>
        <h2>Form Catatan Pengunjung</h2>
        <?php if (isset($pesan)) echo "<p class='notif'>$pesan</p>"; ?>
        
        <form action="" method="POST">
            <label for="nama_pengunjung">Nama Pengunjung:</label>
            <input type="text" id="nama_pengunjung" name="nama_pengunjung" required>

            <label for="no_identitas">No. KTP/ID (Unik):</label>
            <input type="text" id="no_identitas" name="no_identitas" required maxlength="20">

            <label for="nama_pasien">Nama Pasien yang Dikunjungi:</label>
            <input type="text" id="nama_pasien" name="nama_pasien" required>

            <label for="ruangan">Ruangan/Nomor Kamar Pasien:</label>
            <input type="text" id="ruangan" name="ruangan" required>

            <label for="tujuan_kunjungan">Tujuan Kunjungan Detail:</label>
            <textarea id="tujuan_kunjungan" name="tujuan_kunjungan" required></textarea>

            <button type="submit" name="submit">Catat Kunjungan Masuk</button>
        </form>
    </main>
</body>
</html>