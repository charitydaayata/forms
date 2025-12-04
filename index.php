<!DOCTYPE html>
<html>
<head>
    <title>Clinic Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php if (isset($_GET['success'])): ?>
    <script>
        <?php if ($_GET['success'] == 1): ?>
            alert("Form submitted successfully!");
        <?php else: ?>
            alert("Error saving data. Please try again.");
        <?php endif; ?>
      
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('success');
            window.history.replaceState({}, document.title, url.toString());
        }
    </script>
<?php endif; ?>

<div class="form-container">
    <h2>Patient Information Form</h2>

    <form action="process.php" method="post">

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required>

        <label for="age">Age</label>
        <input type="number" id="age" name="age" min="0" required>

        <label for="gender">Gender</label>
        <select id="gender" name="gender" required>
            <option value="">-- select --</option>
            <option>Male</option>
            <option>Female</option>
        </select>

        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" required>

        <label for="symptoms">Symptoms / Reason for Visit</label>
        <textarea id="symptoms" name="symptoms" rows="4" required></textarea>

        <label for="payment">Payment Amount (₱)</label>
        <input type="number" id="payment" name="payment" min="0" required>

        <label for="payment_method">Payment Method</label>
        <select id="payment_method" name="payment_method" required>
            <option value="">-- select --</option>
            <option>Cash</option>
            <option>GCash</option>
            <!-- <option>Credit Card</option> -->
        </select>

        <button type="submit">Submit Form</button>
    </form>
</div>

</body>
</html>
