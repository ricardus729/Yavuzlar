<?php 


$db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/db.db', SQLITE3_OPEN_READWRITE);

function test_input($name){
    $set = false;


    if(isset($_POST[$name])){
        $set = true;

        
    }

    if(isset($_GET[$name])){
        $set = true;


    }

    return $set;
}

?>