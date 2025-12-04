<?php
// DB config
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
    die("DB connect error");
}

$sql = "SELECT id, name, age, gender, phone, symptoms, payment, payment_method, created_at
        FROM patients
        ORDER BY created_at DESC";

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();


header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=patients_records.csv');

// Open output
$output = fopen('php://output', 'w');

// Optional: CSV header row
fputcsv($output, ['ID', 'Name', 'Age', 'Gender', 'Phone', 'Symptoms', 'Payment', 'Method', 'Created At']);

foreach ($rows as $row) {
    fputcsv($output, [
        $row['id'],
        $row['name'],
        $row['age'],
        $row['gender'],
        $row['phone'],
        $row['symptoms'],
        $row['payment'],
        $row['payment_method'],
        $row['created_at'],
    ]);
}

fclose($output);
exit;
