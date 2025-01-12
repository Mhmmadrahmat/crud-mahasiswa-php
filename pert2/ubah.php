<?php 

session_start();

if(!isset($_SESSION["login"])){
    header("location: login.php");
    exit;
}

require_once 'functions.php';

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_sekolah");

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data di URL
$id = htmlspecialchars($_GET["id"]); // Sanitasi input

// Validasi ID harus berupa angka positif
if (!filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
    die("ID tidak valid.");
}

// Menggunakan prepared statement untuk menghindari SQL Injection
$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Cek jika data ditemukan
if ($result->num_rows > 0) {
    $mhs = $result->fetch_assoc();
} else {
    die("Data tidak ditemukan.");
}

// Tutup prepared statement
$stmt->close();

// Proses jika form di-submit
if (isset($_POST["submit"])) {

    // Pastikan semua data disanitasi sebelum diproses
    $_POST = array_map('htmlspecialchars', $_POST);
    
    if (ubah($_POST) > 0) {
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'index.php';
              </script>";
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Ubah Data Mahasiswa</title>
</head>
<body>
    <h1>Ubah Data Mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $mhs['id']; ?>">
    <input type="hidden" name="gambarLama" value="<?= $mhs['gambar']; ?>">

    <ul>
        <li>
            <label for="nama">Nama :</label>
            <input type="text" name="nama" id="nama" required 
            value="<?= htmlspecialchars($mhs['nama'] ?? ''); ?>">
        </li>
        <li>
            <label for="nrp">NRP :</label>
            <input type="text" name="nrp" id="nrp" required 
            value="<?= htmlspecialchars($mhs['nrp'] ?? ''); ?>">
        </li>
        <li>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required 
            value="<?= htmlspecialchars($mhs['email'] ?? ''); ?>">
        </li>
        <li>
            <label for="jurusan">Jurusan :</label>
            <input type="text" name="jurusan" id="jurusan" required 
            value="<?= htmlspecialchars($mhs['jurusan'] ?? ''); ?>">
        </li>
        <li>
            <label for="gambar">Gambar :</label><br>
            <img src="../img/th (2).jpg?= $mhs['gambar']; ?>" width="60" ><br>
            <input type="file" name="gambar" id="gambar">
        </li>
        <li>
            <button type="submit" name="submit">Ubah Data</button>
        </li>
    </ul>
</form>

</body>
</html>

