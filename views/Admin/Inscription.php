<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
$pdo = require_once __DIR__ . "/../../Models/Database.php";
require __DIR__ . "/../../Controllers/Admin.php";
require __DIR__ . "/../../Models/M_Authentification.php";

$AdminModels = new Admin($pdo);
$AdminAuth = new AuthAdmin($AdminModels);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';



    $AdminAuth->InsertAdmin($username, $email, $password, $role);
}

?>



<body>
    <form action="Inscription.php" method="post">
        <input type="text" name="username" id="">
        <input type="text" name="email" id="">
        <input type="text" name="password" id="">
        <input type="text" name="role" id="">
        <button type="submit">click</button>

    </form>
</body>

</html>