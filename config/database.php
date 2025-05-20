<?php
$host = 'localhost';
$dbname = 'czrsolut_antrenamenttractoare';
$username = 'czrsolut_antrenamenttractoare';
$password = 'zy.p9LX_MnzJ';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?> 