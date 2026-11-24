
<?php

require_once __DIR__ . '/../config/Database.php';

class Buku extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function tampilkanBuku() {
        $sql = "SELECT * FROM buku";
        return $this->conn->query($sql);
    }

    public function tambahBuku($judul, $penulis, $stok) {
        $sql = "INSERT INTO buku (judul, penulis, stok)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $judul, $penulis, $stok);

        return $stmt->execute();
    }

    public function hapusBuku($id) {
        $sql = "DELETE FROM buku WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

public function editBuku($id, $judul, $penulis, $stok) {

    $sql = "UPDATE buku
            SET judul = ?, penulis = ?, stok = ?
            WHERE id = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ssii", $judul, $penulis, $stok, $id);

    return $stmt->execute();
}

}
