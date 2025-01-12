<?php 

$conn = mysqli_connect("localhost", "root", "", "db_sekolah");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        die('Query Error: ' . mysqli_error($conn));
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}



function  tambah($data){

global $conn;
    $id = ($data["id"]);
    $nama = htmlspecialchars($data["nama"]);
    $nrp =  htmlspecialchars($data["nrp"]);
    $email=  htmlspecialchars($data["email"]);
    $jurusan =  htmlspecialchars($data["jurusan"]);
    

        $gambar = upload();
    if (!$gambar) {
        return false;
    }

    
    $query = "INSERT INTO mahasiswa
    VALUES  ('','$nama','$nrp','$email','$jurusan','$gambar') ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows(($conn));
}


function upload(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES ['gambar']['tmp_name'];


//cek apakah tidak ada gambar yg di apload
    if( $error === 4){
        echo  "<script>
        alert('pilih gambar terlebih dahulu!');
        </script>";

        return false;
    }


    //cek apakah yg di apload adalah gambar

    $ekstensiGambarValid = ['jpg', 'png' ,'jpeg'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end ($ekstensiGambar)); 
    if( !in_array($ekstensiGambar, $ekstensiGambarValid)){

        echo  "<script>
        alert(' yang anda upload bukan gambar');
        </script>";

        return false;
    }

    // Cek jika ukuran file terlalu besar (misalnya 2MB)
    if( $ukuranFile > 2000000 ) {
        echo "<script>
        alert('Ukuran gambar terlalu besar!');
        </script>";
        return false;
    }

    // Generate nama file baru untuk menghindari duplikasi
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    // Pindahkan file ke folder tujuan
    

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;


}



function hapus($id){
    global $conn;
    mysqli_query($conn,"DELETE FROM 
    mahasiswa  WHERE id = $id");

    return mysqli_affected_rows($conn);

}


function ubah($data) {
    global $conn;

    // Ambil data dari form
    $id = htmlspecialchars($data['id']);
    $nama = htmlspecialchars($data['nama']);
    $nrp = htmlspecialchars($data['nrp']);
    $email = htmlspecialchars($data['email']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $gambarLama = htmlspecialchars($data['gambarLama']);
    
    //cek 
    if($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    }else{
        $gambar = upload();
    }
    
    

    // Query update data
   $query = "UPDATE mahasiswa SET
                nama = '$nama',
                nrp = '$nrp',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'
              WHERE id = $id";


    // Eksekusi query dan cek apakah berhasil
    mysqli_query($conn, $query);

    // Return jumlah baris yang terpengaruh
    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    $keyword = htmlspecialchars($keyword);
    $query = "SELECT * FROM mahasiswa
              WHERE nama LIKE '%$keyword%' OR nrp LIKE '%$keyword%'";
    return query($query);
}



function registrasi($data) {
    global $conn;

    // Sanitasi dan ambil data
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // Cek apakah username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }

    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username sudah ada telah terdaftar');</script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>alert('Konfirmasi password tidak sesuai');</script>";
        return false;
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database
    $query = "INSERT INTO user (id, username, password) VALUES('', '$username', '$password')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }

    // Kembalikan jumlah baris yang terpengaruh
    return mysqli_affected_rows($conn);
}






?>