<?php 

session_start();

if(!isset($_SESSION["username"]))
    exit('Yetkisiz giriş.');

include "./util.php";


if(test_input("id") && test_input("answer")){
$id = intval($_GET["id"]);
$answer = $_GET["answer"];

             $statement = $db->prepare('SELECT * FROM sorular WHERE id = :id');

             $statement->bindValue(":id", $id);
             $result = $statement->execute();

             
             if($arr = $result->fetchArray(SQLITE3_ASSOC)){
                
               
                $puan = $arr["puan"];
                if($arr["dogru"] == "$answer"){
                    $puan = $arr["puan"];
                }else{
                    $puan = 0;
                }

                $statement3 = $db->prepare('SELECT * FROM sorulog WHERE soru = :soruid AND user = :username');
                $statement3->bindValue(":soruid", $id);
                $statement3->bindValue(":username", $_SESSION["username"]);
                $result3 = $statement3->execute();

                
                if($arr2 = $result3->fetchArray(SQLITE3_ASSOC)){
                    
                }else{
                $statement = $db->prepare('INSERT INTO sorulog (id, user, soru, puan) VALUES (NULL, :user, :soru, :puan)');
                $statement->bindValue(":user", $_SESSION["username"]);
                $statement->bindValue(":soru", $arr["id"]);
                $statement->bindValue(":puan", $puan);
                $statement->execute(); 
                
                }

             }else{
                header('location:./scoreboard.php');
             }
        



}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task2 - Quest App</title>    
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div id="soruContainer" class="container">

    <?php 

    $statement = $db->prepare('SELECT s.* FROM sorular s LEFT JOIN sorulog sl ON s.id = sl.soru AND sl.user = "'.$_SESSION["username"].'" WHERE sl.soru IS NULL ORDER BY RANDOM() LIMIT 1');
    $result = $statement->execute();

    if($arr = $result->fetchArray(SQLITE3_ASSOC)){

        echo'<h2>'.$arr["soru"].'</h2>';
        echo'<form style="width:100%;" action="" method="get">';
            echo'<input hidden name="id" value="'.$arr["id"].'"></input>';
            echo'<input hidden name="answer" value="a"></input>';
            echo'<button type="submit">A: '.$arr["a"].'</button>';
        echo'</form>';
        echo'<form style="width:100%;" action="" method="get">';
            echo'<input hidden name="id" value="'.$arr["id"].'"></input>';
            echo'<input hidden name="answer" value="b"></input>';
            echo'<button type="submit">B: '.$arr["b"].'</button>';
        echo'</form>';
        echo'<form style="width:100%;" action="" method="get">';
            echo'<input hidden name="id" value="'.$arr["id"].'"></input>';
            echo'<input hidden name="answer" value="c"></input>';
            echo'<button type="submit">C: '.$arr["c"].'</button>';
        echo'</form>';
        echo'<form style="width:100%;" action="" method="get">';
            echo'<input hidden name="id" value="'.$arr["id"].'"></input>';
            echo'<input hidden name="answer" value="d"></input>';
            echo'<button type="submit">D: '.$arr["d"].'</button>';
        echo'</form>';
        echo'<form style="width:30%;" action="" method="get">';
            echo'<input hidden name="id" value="'.$arr["id"].'"></input>';
            echo'<input hidden name="answer" value="0"></input>';
            echo'<button type="submit">Soruyu Geç >>></button>';
        echo'</form>';
      
    }else{

        header('location:./scoreboard.php');
    }
    ?>
</div>



</body>

<script src="assets/scripts.js"></script>

</html>