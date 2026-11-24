
<?php

require_once 'User.php';

class Anggota extends User {

    public function pinjamBuku() {
        return "Anggota " . $this->nama . " melakukan peminjaman buku.";
    }
}
