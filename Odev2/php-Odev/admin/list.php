<?php 

session_start();

if(!isset($_SESSION["admin"]))
    exit('Yetkisiz giriş.');


    
include("../util.php");
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
    
    
<h1>Soru Listesi</h1>
<div class="container">

    
    
    <table id="soruListesiAdmin" style="padding: 15px; width:100%;">
    
    
    <?php
    echo "<tr>" .
          "<th>Soru</th>" .
          "<th>Sil</th>" .
          "<th>Düzenle</th>" .
        "</tr>";

        $statement = $db->prepare('SELECT * FROM "sorular"');
        $result = $statement->execute();


    while($arr = $result->fetchArray(SQLITE3_ASSOC)){
        
         echo '<tr>';
         echo '<td>'.  $arr["soru"] .'</td>';
         echo '<td><a href="./delete.php?id=' . $arr["id"]  . '">Sil</a></td>';
         echo '<td><a href="./edit.php?id=' . $arr["id"]  . '">Düzenle</a></td>';
         echo '</tr>';

    }
?>
    </table>
    <!-- <button onclick="location.href='./admin/add.html';" value="" >Soru Ekle</button> -->


</div>



</body>

<script src="../assets/scripts.js"></script>

</html>