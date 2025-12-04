<?php
// 🔍 Show errors on screen (for debugging only - remove on production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB config (adjust if needed)
$host = '127.0.0.1';
$db   = 'patients';
$user = 'root';
$pass = ''; // empty if your phpMyAdmin/root has no password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Connect
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // ❌ DB connection error
    die("DB connect error: " . $e->getMessage());
}

// Only allow POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request method. This script only accepts POST.");
}

// Collect + sanitize (basic)
$name           = trim($_POST['name'] ?? '');
$age            = trim($_POST['age'] ?? '');
$gender         = trim($_POST['gender'] ?? '');
$phone          = trim($_POST['phone'] ?? '');
$symptoms       = trim($_POST['symptoms'] ?? '');
$payment        = trim($_POST['payment'] ?? '0');
$payment_method = trim($_POST['payment_method'] ?? '');

// Basic server-side validation
$errors = [];
if ($name === '') $errors[] = "Name is required.";
if ($age === '' || !is_numeric($age) || intval($age) < 0) $errors[] = "Valid age is required.";
if ($gender === '') $errors[] = "Gender is required.";
if ($phone === '') $errors[] = "Phone number is required.";
if ($symptoms === '') $errors[] = "Symptoms / reason for visit is required.";
if ($payment === '' || !is_numeric($payment) || floatval($payment) < 0) $errors[] = "Valid payment amount is required.";
if ($payment_method === '') $errors[] = "Payment method is required.";

if (!empty($errors)) {
    // ❌ Show validation errors directly for now
    echo "<h3>Validation errors:</h3><ul>";
    foreach ($errors as $err) {
        echo "<li>" . htmlspecialchars($err) . "</li>";
    }
    echo "</ul>";
    echo '<p><a href="../views/forms.php">Go back to form</a></p>';
    exit;
}

// Prepare the INSERT statement
$sql = "INSERT INTO patients
        (name, age, gender, phone, symptoms, payment, payment_method, created_at)
        VALUES
        (:name, :age, :gender, :phone, :symptoms, :payment, :payment_method, NOW())";

try {
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':name'           => $name,
        ':age'            => intval($age),
        ':gender'         => $gender,
        ':phone'          => $phone,
        ':symptoms'       => $symptoms,
        ':payment'        => number_format((float)$payment, 2, '.', ''),
        ':payment_method' => $payment_method,
    ]);

    // ✅ Success
    header("Location: ../views/forms.php?success=1");
    exit;

} catch (PDOException $e) {
    // ❌ Insert error (likely table/column issue)
    die("DB insert error: " . $e->getMessage());
}
?>
