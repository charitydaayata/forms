<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: records.php');
    exit;
}

$id = (int) $_GET['id'];


$pageTitle = 'Edit Patient';
$cssFile   = '../assets/forms.css';  

include '../includes/header.php';


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
    die("DB connect error: " . $e->getMessage());
}


$sql = "SELECT * FROM patients WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$patient = $stmt->fetch();

if (!$patient) {
    echo "<p style='color:white; text-align:center; margin-top:100px;'>Record not found.</p>";
    include '../includes/footer.php';
    exit;
}
?>

<div class="form-container">
    <h2>Edit Patient</h2>

    <form action="../handlers/update_patient.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($patient['id']); ?>">

        <div class="form-grid">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    value="<?php echo htmlspecialchars($patient['name']); ?>"
                >
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input
                    type="number"
                    id="age"
                    name="age"
                    min="0"
                    required
                    value="<?php echo htmlspecialchars($patient['age']); ?>"
                >
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">-- select --</option>
                    <option <?php if ($patient['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                    <option <?php if ($patient['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    required
                    value="<?php echo htmlspecialchars($patient['phone']); ?>"
                >
            </div>

            <div class="form-group full-width">
                <label for="symptoms">Symptoms / Reason for Visit</label>
                <textarea id="symptoms" name="symptoms" rows="3" required><?php
                    echo htmlspecialchars($patient['symptoms']);
                ?></textarea>
            </div>

            <div class="form-group">
                <label for="payment">Payment Amount (₱)</label>
                <input
                    type="number"
                    id="payment"
                    name="payment"
                    min="0"
                    required
                    value="<?php echo htmlspecialchars($patient['payment']); ?>"
                >
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="">-- select --</option>
                    <option <?php if ($patient['payment_method'] === 'Cash') echo 'selected'; ?>>Cash</option>
                    <option <?php if ($patient['payment_method'] === 'GCash') echo 'selected'; ?>>GCash</option>
                </select>
            </div>

            <div class="form-actions full-width">
                <button type="submit" class="btn-submit">Save Changes</button>
                <a href="records.php" class="btn-clear" style="text-align:center; padding-top:11px; text-decoration:none;">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
