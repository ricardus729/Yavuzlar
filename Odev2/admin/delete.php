<?php 

session_start();

if(!isset($_SESSION["admin"]))
    exit('Yetkisiz giriş.');


    
include("../util.php");

if(isset($_GET["id"]) && intval($_GET["id"])){

    $id = intval($_GET["id"]); 



    $statement = $db->prepare('DELETE FROM sorular WHERE id = :id');
    $statement->bindValue(":id", $id);
    $statement->execute(); // yo


    echo "Soru silindi.";

}


?>
