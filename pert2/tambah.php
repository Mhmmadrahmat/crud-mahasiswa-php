<?php 


require 'functions.php';

$conn = mysqli_connect("localhost","root","","db_sekolah");


if( isset($_POST["submit"]) ) {



   if( tambah($_POST) > 0){
    echo "<script>
                alert('data berhasil ditambahkan!');
                document.location.href='index.php';
                </script>";
   } else {
    echo "<script>
                alert('data gagal ditambahkan!');
                document.location.href='index.php';
                </script>";
   }
 

}




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data mahasiswa</title>
    <style>
    body {
        font-family: Arial, sans-serif; 
        background-color: #f4f4f4; 
        margin: 0; 
        padding: 20px; 
    }
    h1 {
        text-align: center; 
        color: #333; 
    }
    form {
        background-color: #fff; 
        padding: 20px; 
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
        max-width: 600px; /* Mengatur lebar maksimum form */
        margin: 20px auto; /* Memusatkan form dengan margin otomatis */
    }
    ul {
        list-style-type: none; /* Menghapus bullet dari list */
        padding: 0; /* Menghapus padding default */
    }
    li {
        margin-bottom: 15px; /* Menambahkan jarak antar elemen list */
    }
    label {
        display: block; /* Mengubah label menjadi block agar lebih mudah diatur */
        margin-bottom: 5px; /* Menambahkan jarak di bawah label */
        font-weight: bold; /* Membuat teks label menjadi tebal */
    }
    input[type="text"],
    input[type="file"] {
        width: 100%; /* Mengatur lebar input menjadi 100% dari elemen induk */
        padding: 10px; /* Menambahkan padding di dalam input */
        border: 1px solid #ccc; /* Mengatur border input */
        border-radius: 4px; /* Membuat sudut input melengkung */
        box-sizing: border-box; /* Mengatur box-sizing agar padding tidak menambah lebar */
    }
    button {
        background-color: #5cb85c; /* Warna latar belakang tombol */
        color: white; /* Warna teks tombol */
        padding: 10px 15px; /* Menambahkan padding pada tombol */
        border: none; /* Menghapus border default tombol */
        border-radius: 4px; /* Membuat sudut tombol melengkung */
        cursor: pointer; /* Mengubah kursor menjadi pointer saat hover */
        font-size: 16px; /* Mengatur ukuran font tombol */
    }
    button:hover {
        background-color: #4cae4c; /* Mengubah warna tombol saat hover */
    }
</style>
</head>
<body>
    <h1>Tambah data mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
    <ul>
        <li>
            <label for="nama">Nama :</label>
            <input type="text" name="nama" id="nama">
        </li>
        <li>
            <label for="nrp">NRP :</label>
            <input type="text" name="nrp" id="nrp">
        </li>
        <li>
            <label for="email">Email :</label>
            <input type="text" name="email" id="email">
        </li>
        <li>
            <label for="jurusan">Jurusan :</label>
            <input type="text" name="jurusan" id="jurusan">
        </li>
        <li>
            <label for="gambar">Gambar:</label>
            <input type="file" name="gambar" id="gambar">
        </li>
        <li>
            <button type="submit" name="submit">Tambah Data</button>
        </li>
    </ul>
</form>


</body>
</html>