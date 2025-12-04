<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Clinic Form';
}
if (!isset($cssFile)) {
    $cssFile = '../assets/forms.css';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="<?php echo htmlspecialchars($cssFile); ?>">

    <!-- Global Header CSS -->
    <link rel="stylesheet" href="../assets/header.css">
</head>
<body>

<!-- VISIBLE HEADER BAR -->
<header class="site-header">
    <div class="header-inner">
        <h1>Clinic System</h1>
        <nav>
            <a href="../index.html">Home</a>
            <a href="forms.php">Form</a>
            <a href="records.php">Records</a>
        </nav>
    </div>
</header>
