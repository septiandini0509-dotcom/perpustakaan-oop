
<?php

require_once 'classes/Peminjaman.php';
require_once 'config/Database.php';

$db = new Database();
$conn = $db->getConnection();

$peminjaman = new Peminjaman();

if (isset($_POST['pinjam'])) {
    $user_id = (int) $_POST['user_id'];
    $buku_id = (int) $_POST['buku_id'];

    if ($peminjaman->pinjamBuku($user_id, $buku_id)) {
        $pesan = "Peminjaman berhasil!";
    } else {
        $pesan = "Peminjaman gagal atau stok habis!";
    }
}

$anggota = $conn->query(
    "SELECT * FROM users WHERE role = 'anggota'"
);

$buku = $conn->query(
    "SELECT * FROM buku WHERE stok > 0"
);

$riwayat = $peminjaman->tampilkanPeminjaman();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peminjaman Buku</title>
</head>
<body>

<h1>Peminjaman Buku</h1>

<?php if (isset($pesan)) : ?>
    <p><?= htmlspecialchars($pesan); ?></p>
<?php endif; ?>

<form method="POST">

    <label>Nama Anggota:</label>
    <select name="user_id" required>
        <?php while ($u = $anggota->fetch_assoc()) : ?>
            <option value="<?= $u['id']; ?>">
                <?= htmlspecialchars($u['nama']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <label>Pilih Buku:</label>
    <select name="buku_id" required>
        <?php while ($b = $buku->fetch_assoc()) : ?>
            <option value="<?= $b['id']; ?>">
                <?= htmlspecialchars($b['judul']); ?>
                (Stok: <?= $b['stok']; ?>)
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <button type="submit" name="pinjam">
        Pinjam Buku
    </button>

</form>

<hr>

<h2>Riwayat Peminjaman</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Anggota</th>
        <th>Judul Buku</th>
        <th>Tanggal Pinjam</th>
        <th>Status</th>
    </tr>

    <?php $no = 1; ?>

    <?php while ($row = $riwayat->fetch_assoc()) : ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td><?= htmlspecialchars($row['judul']); ?></td>
            <td><?= $row['tanggal_pinjam']; ?></td>
            <td><?= htmlspecialchars($row['status']); ?></td>
        </tr>
    <?php endwhile; ?>

</table>

<br>

<a href="buku.php">Kembali ke Data Buku</a>

</body>
</html>
