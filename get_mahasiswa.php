<?php
// Tentukan header agar Postman tahu bahwa responsnya adalah JSON
header("Content-Type: application/json; charset=UTF-8");

// Sertakan (include) file koneksi
require_once 'database.php';

// 1. Inisialisasi dan dapatkan koneksi
$database = new Database();
$db = $database->getConnection();

// Periksa koneksi
if (!$db) {
    // Jika koneksi gagal, kirimkan respons error
    http_response_code(500);
    echo json_encode(["message" => "Gagal terhubung ke database."]);
    exit();
}

try {
    // 2. Tentukan Query SQL
    $query = "SELECT nim, nama, program_studi, angkatan, tanggal_lahir, email, status FROM mahasiswa ORDER BY nim ASC";
    
    // Siapkan statement
    $stmt = $db->prepare($query);
    
    // Eksekusi query
    $stmt->execute();
    
    $num = $stmt->rowCount();

    // 3. Ambil dan Format Data
    if($num > 0) {
        $mahasiswa_arr = [];
        
        // Loop untuk mengambil semua baris data
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Ekstrak baris data
            extract($row);
            
            $mahasiswa_item = [
                "nim" => $nim,
                "nama" => $nama,
                "program_studi" => $program_studi,
                "angkatan" => $angkatan,
                "tanggal_lahir" => $tanggal_lahir,
                "email" => $email,
                "status" => $status
            ];

            array_push($mahasiswa_arr, $mahasiswa_item);
        }
        
        // Set kode respons ke 200 OK
        http_response_code(200);
        
        // Tampilkan data dalam format JSON
        echo json_encode($mahasiswa_arr);

    } else {
        // Jika tidak ada data
        http_response_code(404);
        echo json_encode(["message" => "Tidak ada data mahasiswa yang ditemukan."]);
    }

} catch (PDOException $e) {
    // Tangani error query
    http_response_code(500);
    echo json_encode(["message" => "Terjadi kesalahan saat menjalankan query: " . $e->getMessage()]);
}

?>