
<?php

require_once __DIR__ . '/../config/Database.php';

class User extends Database {

    protected $nama;
    protected $email;
    private $password;

    public function __construct($nama, $email, $password) {
        parent::__construct();

        $this->nama = $nama;
        $this->email = $email;
        $this->password = $password;
    }

    public function tampilkanNama() {
        return $this->nama;
    }

    public static function informasi() {
        return "Sistem Perpustakaan";
    }
}
