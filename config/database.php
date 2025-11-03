<?php

class Database {
    private $host = 'localhost'; // Ganti dengan host Anda
    private $db_name = 'akademik'; // Ganti dengan nama database Anda
    private $username = 'root'; // Ganti dengan username Anda
    private $password = ''; // Ganti dengan password Anda
    public $conn;

    /**
     * Metode untuk mendapatkan koneksi database
     * @return PDO|null
     */
    public function getConnection(): ?PDO {
        $this->conn = null;

        try {
            // Data Source Name (DSN) untuk MySQL
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            
            // Opsi PDO: 
            // 1. ATTR_ERRMODE: Mengatur mode error ke EXCEPTION agar PDO membuang exception (lebih baik untuk menangani error)
            // 2. ATTR_DEFAULT_FETCH_MODE: Mengatur mode fetch default ke ASSOC (mengembalikan hasil sebagai array asosiatif)
            // 3. ATTR_EMULATE_PREPARES: Diatur ke false untuk menggunakan prepare statement native dari database (lebih aman)
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch(PDOException $exception) {
            // Tangani kegagalan koneksi
            echo "Kesalahan koneksi: " . $exception->getMessage();
            // PENTING: Dalam aplikasi produksi, jangan tampilkan pesan error PDO langsung ke pengguna! 
            // Sebaiknya catat (log) error-nya dan tampilkan pesan generik.
        }

        return $this->conn;
    }
}

?>