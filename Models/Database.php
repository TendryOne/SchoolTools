<?php
$dsn = 'mysql:host=localhost;dbname=projet_examen';
$user = 'root';
$pwd = '034FakerT1';

try {
    $pdo = new PDO($dsn, $user, $pwd, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo "Error :" .  $e->getmessage();
}

return $pdo;
