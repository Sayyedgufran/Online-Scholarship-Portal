<?php
session_start();
require '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    // SPECIAL CASE: ADMIN with simple password
    if ($role == 'admin' && $email == 'admin' && $password == 'admin123') {
        $_SESSION['user_id'] = 1;
        $_SESSION['role'] = 'admin';
        $_SESSION['email'] = 'admin';
        $_SESSION['name'] = 'Administrator';
        
        header("Location: ../admin_dashboard.php");
        exit();
    }
    
    // For students and providers - SIMPLE PASSWORD CHECK (NO HASHING)
    if ($role == 'admin') {
        $table = 'admins';
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE username = ? AND password = ?");
    } else {
        $table = $role . 's';
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE email = ? AND password = ?");
    }
    
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch();
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $user['email'] ?? $user['username'];
        $_SESSION['name'] = $user['fullname'] ?? $user['username'];
        
        header("Location: ../{$role}_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid email or password!'); window.history.back();</script>";
    }
}
?>