<?php
require 'connec.php'; // on affiche la base de données existante (il faut connecter la base de données)
$pdo = new \PDO(DSN, USER, PASSWORD);
$statement = $pdo->query("SELECT * FROM friend");
$friends = $statement->fetchAll(PDO:: FETCH_ASSOC);
var_dump($friends);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Redirect page</title>
</head>
<body>
    <h1>Friends list</h1>

</body>
</html>
