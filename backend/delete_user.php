<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

require '../includes/db_connection.php';

$id = $_GET['id'];
$type = $_GET['type'];

if ($type == 'student') {
    $pdo->prepare("DELETE FROM students WHERE id=?")->execute([$id]);
} elseif ($type == 'provider') {
    $pdo->prepare("DELETE FROM providers WHERE id=?")->execute([$id]);
}

header("Location: ../admin_manage_users.php?success=User deleted successfully");
exit();
