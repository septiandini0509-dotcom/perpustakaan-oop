
<?php

require_once 'classes/Buku.php';

$buku = new Buku();

$id = (int) ($_GET['id'] ?? 0);

$stmt = $buku->getConnection()->prepare(
    "SELECT * FROM buku WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Data buku tidak ditemukan.");
}

if (isset($_POST['update'])) {

    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $stok = (int) $_POST['stok'];

    if ($buku->editBuku($id, $judul, $penulis, $stok)) {
        header("Location: buku.php");
        exit;
    }

    echo "Gagal mengubah data buku.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
</head>
<body>

<h1>Edit Data Buku</h1>

<form method="POST">

    <label>Judul Buku</label><br>
    <input type="text" name="judul"
        value="<?= htmlspecialchars($data['judul']); ?>"
        required>

    <br><br>

    <label>Penulis</label><br>
    <input type="text" name="penulis"
        value="<?= htmlspecialchars($data['penulis']); ?>"
        required>

    <br><br>

    <label>Stok</label><br>
    <input type="number" name="stok"
        value="<?= $data['stok']; ?>"
        min="0" required>

    <br><br>

    <button type="submit" name="update">
        Simpan Perubahan
    </button>

</form>

</body>
</html>
