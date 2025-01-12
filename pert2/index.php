<?php 
session_start();

if(!isset($_SESSION["login"])){
    header("location: login.php");
    exit;
}

require 'functions.php';

$mahasiswa = query("SELECT * FROM mahasiswa"); //ORDER BY id DESC untuk meindahkan ke urutan pertama

if(isset($_POST["cari"])){
    $mahasiswa = cari($_POST["keyword"]);
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
    body {
        font-family: Arial, sans-serif; 
        background-color:rgb(153, 185, 211); 
        margin: 0; 
        padding: 20px; 
    }
    h1 {
        text-align: center; 
        color: #333; 
        margin-bottom: 20px; 
    }
    .logout {
        display: block; 
        text-align: right; 
        margin-bottom: 20px;
        font-size: 1em; 
        color:rgb(0, 0, 0);
        text-decoration: none; 
    }
    .logout:hover {
        text-decoration: underline; 
    }
    .for {
        /* display: block; */
        text-align: center; 
        margin-bottom: 20px; 
        font-size: 1.2em; 
        color:rgb(2, 8, 15); 
        text-decoration: none; 
    }
    .for:hover {
        text-decoration: underline; 
    }
    form {
        text-align: center; 
        margin-bottom: 20px; 
    }
    input[type="text"] {
       
        width: 20%; 
        padding: 5px; 
        border: 1px solid #ccc;
        border-radius: 4px; 
        box-sizing: border-box; 
    }
    button {    
        padding: 5px 5px; 
        font-size: 1em; 
        background-color: #5cb85c; 
        color: white;
        border: none; 
        border-radius: 4px; 
        cursor: pointer; 
    }
    button:hover {
        background-color: #4cae4c; 
    }
    table {
        width: 100%; 
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 10px; 
        text-align: left; 
        border: 1px solid #ccc; 
    }
    th {
        background-color: #f2f2f2; 
        font-weight: bold; 
    }
</style>
</head>
<body>

<a class="logout" href="loguot.php">loguot</a>

    <h1>Halaman Admin</h1>
    <a class="for" href="tambah.php">Tambah Data Mahasiswa</a>
    

    <form action="" method="post">

      <input type="text" name="keyword" size="40" autofocus
       placeholder="masukan keyword pencarian.." autocomplete="off">
      <button type="submit" name="cari">cari!</button>

    </form>


    <table border="1 " cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Aksi</th>
            <th>Gambar</th> 
            <th>NRP</th>
            <th>Nama</th>
            <th>email</th>
            <th>jurusan</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach($mahasiswa as $row) : ?>
        <tr>
            <td><?= $i; ?></td>
            <td>
                <a href="ubah.php?id=<?= $row["id"]; ?>">Ubah</a> |
                <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('Yakin?');">Hapus</a>
            </td>
           <td>
    <?php if (!empty($row["gambar"]) && file_exists("../img/" . $row["gambar"])): ?>
        <img src="../img/<?= htmlspecialchars($row["gambar"]); ?>" alt="Gambar Mahasiswa" width="100">
    <?php else: ?>
        <img src="../img/jadi.jpg" alt="Default Image" width="30 ">
    <?php endif; ?>
</td>

            <td><?= $row["nrp"]; ?></td>
            <td><?= $row["nama"]; ?></td>
            <td><?= $row["email"]; ?></td>
            <td><?= $row["jurusan"]; ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>
</body>
</html>