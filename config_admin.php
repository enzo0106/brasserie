<?php
$host = "sql211.infinityfree.com";
$dbname = "if0_38342553_db_bts";
$username = "if0_38342553";  
$password = "K8d7yr5JtUF";      

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>
