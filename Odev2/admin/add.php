<?php 

session_start();

if(!isset($_SESSION["admin"]))
    exit('Yetkisiz giriş.');

    include("../util.php");

    if(test_input("soru") && test_input("a") && test_input("b") && test_input("c") && test_input("d") && test_input("zorluk") && test_input("dogru")){
        $soru0 = $_POST["soru"];
        $a = $_POST["a"];
        $b = $_POST["b"];
        $c = $_POST["c"];
        $d = $_POST["d"];
        $zorluk = intval($_POST["zorluk"]);
        $dogru = $_POST["dogru"];

        $puan = $zorluk * 5;


        //echo $db;
        $statement = $db->prepare('INSERT INTO "sorular" ("id", "soru", "a", "b", "c", "d", "zorluk", "puan", "dogru") VALUES (NULL, :soru,  :a,  :b,  :c,  :d,  :zorluk,  :puan,  :dogru)');
        $statement->bindValue(":soru", $soru0);
        $statement->bindValue(":a", $a);
        $statement->bindValue(":b", $b);
        $statement->bindValue(":c", $c);
        $statement->bindValue(":d", $d);
        $statement->bindValue(":zorluk", $zorluk, SQLITE3_INTEGER);
        $statement->bindValue(":puan", $puan, SQLITE3_INTEGER);
        $statement->bindValue(":dogru", $dogru);
        $statement->execute(); 

        exit("Soru oluşturuldu.");

    }




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

    <h1>SORU EKLE</h1>
    <form id="form" action="" method="post">
        <label>Soru:</label>
        <input class="input" type="text" name="soru">
        <label>A Şıkkı:</label>
        <input class="input" type="text" name="a">
        <label>B Şıkkı:</label>
        <input class="input" type="text" name="b">
        <label>C Şıkkı:</label>
        <input class="input" type="text" name="c">
        <label>D Şıkkı:</label>
        <input class="input" type="text" name="d">
        <label>Zorluk</label>
        <select class="input" name="zorluk">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <label>Doğru Cevap</label>
        <select class="input" name="dogru">
            <option value="a">A</option>
            <option value="b">B</option>
            <option value="c">C</option>
            <option value="d">D</option>
        </select>
        <input type="hidden" name="action" value="add">
        <input class="input" type="submit" value="Soru Ekle">
      </form>

</div>



</body>

<script src="../assets/scripts.js"></script>

</html>