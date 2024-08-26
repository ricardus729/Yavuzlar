<?php 

session_start();

if(!isset($_SESSION["admin"]))
    exit('Yetkisiz giriş.');

    include("../util.php");

    if(test_input("soru") && test_input("a") && test_input("b") && test_input("c") && test_input("d") && test_input("zorluk") && test_input("dogru") && test_input("id")){
        $soru0 = $_POST["soru"];
        $a = $_POST["a"];
        $b = $_POST["b"];
        $c = $_POST["c"];
        $d = $_POST["d"];
        $zorluk = intval($_POST["zorluk"]);
        $dogru = $_POST["dogru"];

        $puan = $zorluk * 5;

        
        //echo $db;
        $statement = $db->prepare('UPDATE sorular SET soru = :soru, a = :a,  b = :b, c = :c, d = :d, zorluk = :zorluk, puan = :puan, dogru = :dogru WHERE id = :id;');
        $statement->bindValue(":id", $_GET["id"]);
        $statement->bindValue(":soru", $soru0);
        $statement->bindValue(":a", $a);
        $statement->bindValue(":b", $b);
        $statement->bindValue(":c", $c);
        $statement->bindValue(":d", $d);
        $statement->bindValue(":zorluk", $zorluk, SQLITE3_INTEGER);
        $statement->bindValue(":puan", $puan, SQLITE3_INTEGER);
        $statement->bindValue(":dogru", $dogru);
        $statement->execute(); 

        exit("Soru düzenlendi.");

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
<?php 
    $statement2 = $db->prepare('SELECT * FROM "sorular" WHERE id = :id');
    $statement2->bindValue(":id", $_GET["id"]);
    $result2 = $statement2->execute();


    if($arr2 = $result2->fetchArray(SQLITE3_ASSOC)){
     echo'
         <h1>SORU DÜZENLE</h1>
    <form id="form" action="" method="post">
        <label>Soru:</label>
        <input class="input" type="text" value="'.$arr2["soru"].'" name="soru">
        <label>A Şıkkı:</label>
        <input class="input" type="text" value="'.$arr2["a"].'" name="a">
        <label>B Şıkkı:</label>
        <input class="input" type="text" value="'.$arr2["b"].'" name="b">
        <label>C Şıkkı:</label>
        <input class="input" type="text" value="'.$arr2["c"].'" name="c">
        <label>D Şıkkı:</label>
        <input class="input" type="text" value="'.$arr2["d"].'" name="d">
        <label>Zorluk</label>
        <select class="input" value="'.$arr2["zorluk"].'" name="zorluk">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <label>Doğru Cevap</label>
        <select class="input" value="';
        
        if($arr2["dogru"] == "a")
            echo "1";
        if($arr2["dogru"] == "b")
            echo "2";
        if($arr2["dogru"] == "c")
            echo "3";
        if($arr2["dogru"] == "d")
            echo "4";
        
        
        echo'" name="dogru">
            <option value="a"'; if($arr2["dogru"] == "a")echo'selected';  echo'>A</option>
            <option value="b"'; if($arr2["dogru"] == "b")echo'selected';  echo'>B</option>
            <option value="c"'; if($arr2["dogru"] == "c")echo'selected';  echo'>C</option>
            <option value="d"'; if($arr2["dogru"] == "d")echo'selected';  echo'>D</option>
        </select>
        <input type="hidden" name="action" value="edit">
        <input class="input" type="submit" value="Soru Düzenle">
      </form>

</div>
     

     ';

    }


?>




</body>

<script src="../assets/scripts.js"></script>

</html>