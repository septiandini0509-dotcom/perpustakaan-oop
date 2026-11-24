
<?php
require_once 'classes/Buku.php';

$buku = new Buku();

if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $stok = (int) $_POST['stok'];

    if ($buku->tambahBuku($judul, $penulis, $stok)) {
        header("Location: buku.php");
        exit;
    }
}

if (isset($_GET['hapus'])) {
    $buku->hapusBuku((int) $_GET['hapus']);
    header("Location: buku.php");
    exit;
}

$dataBuku = $buku->tampilkanBuku();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Buku</title>
</head>
<body>

<h1>Perpustakaan</h1>
<h2>Data Buku</h2>

<form method="POST">
    <input type="text" name="judul"
           placeholder="Judul Buku" required>

    <input type="text" name="penulis"
           placeholder="Nama Penulis" required>

    <input type="number" name="stok"
           placeholder="Stok Buku" min="0" required>

    <button type="submit" name="tambah">
        Tambah Buku
    </button>
</form>

<hr>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Judul Buku</th>
        <th>Penulis</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; ?>

    <?php while ($row = $dataBuku->fetch_assoc()) : ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($row['judul']); ?></td>
        <td><?= htmlspecialchars($row['penulis']); ?></td>
        <td><?= $row['stok']; ?></td>

        <td>
            <a href="edit_buku.php?id=<?= $row['id']; ?>">
                Edit
            </a>

            |

            <a href="buku.php?hapus=<?= $row['id']; ?>"
               onclick="return confirm('Hapus buku ini?')">
                Hapus
            </a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

<br>

<a href="index.php">Kembali ke Halaman Utama</a>

</body>
</html>
