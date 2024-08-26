<?php
session_start();

include("util.php");

// login.
if(test_input("uname") && test_input("pwd")){
    $name =  htmlspecialchars($_POST["uname"], ENT_QUOTES | ENT_SUBSTITUTE);
    $pwd =  md5(htmlspecialchars($_POST["pwd"], ENT_QUOTES | ENT_SUBSTITUTE));
        

    $statement = $db->prepare('SELECT * FROM "users" WHERE "username" = ?');
    $statement->bindValue(1, $name);
    $result = $statement->execute();

    if($arr = $result->fetchArray(SQLITE3_ASSOC)){

        if($arr["pwd"] == $pwd){
            $_SESSION["username"] = $arr["username"];

            if($arr["role"] == 1){
                $_SESSION["admin"] = true;
            }

        }
            


    }else{

    $statement = $db->prepare('INSERT INTO "users" ("id", "username", "pwd", "role", "puan") VALUES (NULL, :user, :pwd, 0, 0)');
    $statement->bindValue(":user", $name);
    $statement->bindValue(":pwd", $pwd);
    $statement->execute(); // you can reuse the statement with different values

    echo "Hesap oluşturuldu.";
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


<div class="container">
    <h1>Y A V U Z L A R</h1>
<?php if(isset($_SESSION["username"])): ?>
    <?php if(isset($_SESSION["admin"])): ?>
        <button onclick="location.href='./admin/index.php';" value="" >Yönetim Paneli</button>
    <?php endif; ?>
    <button onclick="location.href='./sorular.php';" value="">Sorular</button>
    <button onclick="location.href='./scoreboard.php';" value="">Scoreboard</button>
<?php endif; ?>

<?php if(!isset($_SESSION["username"])): ?>

    <form method="post" action=""> 

    <b>Username</b>
    <input type="text" placeholder="Kullanıcı Adı" name="uname" required>

    <b>Password</b>
    <input type="password" placeholder="Sifre" name="pwd" required>

    <button type="submit">Login</button>


    </form>
    
<?php endif; ?>
</div>



</body>

<script src="assets/scripts.js"></script>

</html>