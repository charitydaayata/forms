<?php


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../views/records.php');
    exit;
}

$id = (int) $_GET['id'];


$host    = '127.0.0.1';
$db      = 'patients';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // On error, just go back
    header('Location: ../views/records.php');
    exit;
}

$sql = "DELETE FROM patients WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);

header('Location: ../views/records.php');
exit;
