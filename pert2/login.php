<?php 


session_start();

//cek cookie
if(isset($COOKIE['login'])){
    if($_COOKIE['login' =='true']){
        $_SESSION['login'] = true;
    }
}

//session
if(isset($_SESSION["login"])){
    header("location: index.php");
    exit;
}

require 'functions.php';


if(isset($_POST["login"])){

   $username = mysqli_real_escape_string($conn, $_POST["username"]);
   $password = $_POST["password"];


    $result = mysqli_query($conn, "SELECT * FROM user WHERE
    username = '$username'");

if(mysqli_num_rows($result) === 1){


    //cek password
    $row = mysqli_fetch_assoc($result);
   if (password_verify($password, $row["password"])){
// set session 
$_SESSION["login"] = true;


//cek remember me
if(isset($_POST["remember"])){
    //buat cookie

    setcookie('id', $row['id'], time() + 160);
    setcookie('key', hash('sha256', $row['username']),time() + 160);
}


    header("location: index.php");
    exit;
   }
}

$error = true;

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <style>
    /* Reset margin dan padding untuk elemen-elemen dasar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Mengatur gaya tubuh dan latar belakang */
/* body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
} */

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    height:100vh ;
    align-items: center;
}

/* Membuat container form agar lebih rapi */
form {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

/* Gaya untuk judul halaman */
h1 {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    font-size: 24px;
}

/* Mengatur daftar list yang digunakan untuk form */
ul {
    list-style-type: none;
}

/* Mengatur setiap item dalam form */
li {
    margin-bottom: 20px;
}

/* Gaya untuk label input */
label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

/* Gaya untuk input teks */
input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

/* Gaya untuk checkbox */
input[type="checkbox"] {
    margin-right: 10px;
}

/* Gaya untuk tombol login */
button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

/* Menambahkan sedikit gaya pada input focus */
input:focus, button:focus {
    outline: none;
    border-color: #4CAF50;
}

/* Memberikan ruang ekstra di bawah form */
form ul li:last-child {
    margin-bottom: 0;
}


    </style>
    

</head>
<body>
    
    <?php if(isset($error))  : ?>
        <p style="color:brown" font-style: italic;>username password salah</p>
        <?php endif; ?>
        
    <div class="card">
        <h1>Halaman Login</h1>

        <?php if (isset($error)) : ?>
            <p>Username atau password salah</p>
        <?php endif; ?>

        <form action="" method="post">
            <ul>
                <li>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username">
                </li>
                <li>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                </li>
                <li>
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me:</label>
                </li>
                <li>
                    <button type="submit" name="login">Login</button>
                </li>
            </ul>
        </form>
    </div>
    
</body>
</html>