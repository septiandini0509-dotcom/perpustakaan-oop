
<?php

require_once 'User.php';

class Admin extends User {

    public function kelolaBuku() {
        return "Admin " . $this->nama . " sedang mengelola data buku.";
    }
}
