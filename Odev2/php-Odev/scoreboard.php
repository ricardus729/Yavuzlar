<?php 

session_start();


include "./util.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Scoreboard</title>
</head>
<body>


<div class="container" style="zoom:1.5;">
<table>
  <tr>
    <th>Sıralama</th>
    <th>Kullanıcı</th>
    <th>Puan</th>
  </tr>
<?php

$statement = $db->prepare('SELECT u.id, u.username, SUM(sl.puan) AS toplam
FROM users u
JOIN sorulog sl ON u.username = sl.user
GROUP BY u.id, u.username
ORDER BY toplam DESC
LIMIT 10;');
$result = $statement->execute();


while($arr = $result->fetchArray(SQLITE3_ASSOC)){

 echo '<tr>';
 echo '<td>'.  $arr["id"] .'</td>';
 echo '<td>'.  $arr["username"] .'</td>';
 echo '<td>'.  $arr["toplam"] .'</td>';
 echo '</tr>';

}

?>

</table>
</div>


</body>
</html>