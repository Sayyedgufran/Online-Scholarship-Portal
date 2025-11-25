<?php
session_start();
require '../includes/db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'provider') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $amount = $_POST["amount"];
    $deadline = $_POST["deadline"];
    $provider_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO scholarships (title, description, amount, deadline, provider_id) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$title, $description, $amount, $deadline, $provider_id])) {
        echo "<script>alert('Scholarship created successfully!'); window.location.href='../provider_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to create scholarship.'); window.history.back();</script>";
    }
}
?>