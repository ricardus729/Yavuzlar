<?php 

session_start();

if(!isset($_SESSION["admin"]))
    exit('Yetkisiz giriş.');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task2 - Quest App</title>    
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    
<div class="container">

    <h1>A D M I N</h1>
    <button onclick="location.href='./add.php';" value="" >Soru Ekle</button>
    <button onclick="location.href='./list.php';" value="">Soru Listesi</button>


</div>



</body>

<script src="../assets/scripts.js"></script>

</html>