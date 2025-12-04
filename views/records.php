<?php
// Page settings for header
$pageTitle = 'Patient Records';
$cssFile   = '../assets/records.css';

include '../includes/header.php';

// ---- Database connection (same settings as Forms.php) ----
$host    = '127.0.0.1';
$db      = 'patients';   // your database name
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

// ---- Search by name (optional) ----
$search = trim($_GET['q'] ?? '');

$sql = "SELECT id, name, age, gender, phone, symptoms, payment, payment_method, created_at
        FROM patients
        WHERE 1";
$params = [];

if ($search !== '') {
    $sql .= " AND name LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();
?>

<div class="records-container">
    <h2>Patient Records</h2>

    <!-- Search + Export -->
    <div class="records-toolbar">
        <form method="get" class="search-form">
            <input
                type="text"
                name="q"
                placeholder="Search by name..."
                value="<?php echo htmlspecialchars($search); ?>"
            >
            <button type="submit">Search</button>
            <a href="records.php" class="btn-reset">Clear</a>
        </form>

        <a href="../handlers/export_csv.php" class="btn export-btn">Export CSV</a>
    </div>

    <div class="table-wrapper">
        <?php if (count($rows) === 0): ?>
            <p class="empty-state">No records found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Symptoms / Reason</th>
                        <th>Payment (₱)</th>
                        <th>Method</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['age']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['symptoms']); ?></td>
                            <td><?php echo htmlspecialchars($row['payment']); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td class="actions-cell">
                                <a href="edit_patient.php?id=<?php echo $row['id']; ?>" class="link-edit">Edit</a>
                                <a href="../handlers/delete_patient.php?id=<?php echo $row['id']; ?>"
                                   class="link-delete"
                                   onclick="return confirm('Delete this record?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="records-actions">
        <a href="forms.php" class="btn">Back to Form</a>
        <a href="../index.html" class="btn btn-secondary">Home</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
