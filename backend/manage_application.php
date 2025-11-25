<?php
session_start();
require '../includes/db_connection.php';

// Check provider access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'provider') {
    header("Location: ../login.php");
    exit();
}

// Validate required parameters
if (!isset($_GET['action']) || !isset($_GET['id'])) {
    header("Location: ../provider_dashboard.php?error=Invalid+request");
    exit();
}

$action = $_GET['action'];  // approve OR reject
$application_id = $_GET['id'];

// Validate action (security)
if ($action !== 'approve' && $action !== 'reject') {
    header("Location: ../provider_dashboard.php?error=Invalid+action");
    exit();
}

// 🔍 Check if the provider owns the scholarship of this application
$check = $pdo->prepare("
    SELECT a.id 
    FROM applications a
    JOIN scholarships s ON a.scholarship_id = s.id
    WHERE a.id = ? AND s.provider_id = ?
");
$check->execute([$application_id, $_SESSION['user_id']]);

if (!$check->fetch()) {
    header("Location: ../provider_dashboard.php?error=Access+Denied");
    exit();
}

// 🔥 REAL FIX: Correct ENUM values
$status = ($action === 'approve') ? 'approved' : 'rejected';

// Update application status
$update = $pdo->prepare("UPDATE applications SET status = ? WHERE id = ?");
$success = $update->execute([$status, $application_id]);

if ($success) {
    header("Location: ../provider_dashboard.php?message=Application+$status+successfully");
    exit();
} else {
    header("Location: ../provider_dashboard.php?error=Database+error");
    exit();
}
?>
