<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/records.php');
    exit;
}

$id             = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$name           = trim($_POST['name'] ?? '');
$age            = trim($_POST['age'] ?? '');
$gender         = trim($_POST['gender'] ?? '');
$phone          = trim($_POST['phone'] ?? '');
$symptoms       = trim($_POST['symptoms'] ?? '');
$payment        = trim($_POST['payment'] ?? '0');
$payment_method = trim($_POST['payment_method'] ?? '');

// Basic validation
if ($id <= 0 || $name === '' || $age === '' || $gender === '' || $phone === '' ||
    $symptoms === '' || $payment === '' || $payment_method === '') {
    header('Location: ../views/records.php');
    exit;
}

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
    header('Location: ../views/records.php');
    exit;
}

$sql = "UPDATE patients
        SET name = :name,
            age = :age,
            gender = :gender,
            phone = :phone,
            symptoms = :symptoms,
            payment = :payment,
            payment_method = :payment_method
        WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':name'           => $name,
    ':age'            => (int) $age,
    ':gender'         => $gender,
    ':phone'          => $phone,
    ':symptoms'       => $symptoms,
    ':payment'        => number_format((float)$payment, 2, '.', ''),
    ':payment_method' => $payment_method,
    ':id'             => $id,
]);

header('Location: ../views/records.php');
exit;
