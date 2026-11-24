
<?php

require_once __DIR__ . '/../config/Database.php';

class Peminjaman extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function pinjamBuku($user_id, $buku_id) {

        // Cek stok buku
        $cek = $this->conn->prepare(
            "SELECT stok FROM buku WHERE id = ?"
        );

        $cek->bind_param("i", $buku_id);
        $cek->execute();

        $hasil = $cek->get_result();
        $buku = $hasil->fetch_assoc();

        if (!$buku || $buku['stok'] <= 0) {
            return false;
        }

        // Simpan transaksi peminjaman
        $sql = "INSERT INTO peminjaman
                (user_id, buku_id, tanggal_pinjam)
                VALUES (?, ?, CURDATE())";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $buku_id);

        if ($stmt->execute()) {

            // Kurangi stok buku
            $update = $this->conn->prepare(
                "UPDATE buku SET stok = stok - 1 WHERE id = ?"
            );

            $update->bind_param("i", $buku_id);
            return $update->execute();
        }

        return false;
    }

    public function tampilkanPeminjaman() {
        $sql = "SELECT peminjaman.*, 
                       users.nama, 
                       buku.judul
                FROM peminjaman
                JOIN users ON peminjaman.user_id = users.id
                JOIN buku ON peminjaman.buku_id = buku.id";

        return $this->conn->query($sql);
    }
}
