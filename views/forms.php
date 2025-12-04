<!DOCTYPE html>
<html>
<head>
    <title>Clinic Form</title>
    <link rel="stylesheet" href="../assets/forms.css">


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

    <form action="../handlers/Forms.php" method="post">
    <div class="form-grid">

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" min="0" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="">-- select --</option>
                <option>Male</option>
                <option>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" required>
        </div>

        <div class="form-group full-width">
            <label for="symptoms">Symptoms / Reason for Visit</label>
            <textarea id="symptoms" name="symptoms" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="payment">Payment Amount (₱)</label>
            <input type="number" id="payment" name="payment" min="0" required>
        </div>

        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <select id="payment_method" name="payment_method" required>
                <option value="">-- select --</option>
                <option>Cash</option>
                <option>GCash</option>
            </select>
        </div>

       <div class="form-actions full-width center-actions">
            <button type="submit" class="btn-submit">Submit Form</button>
            <button type="reset" class="btn-clear">Clear</button>
        </div>
    </div>
</form>
</div>

</body>
</html>
