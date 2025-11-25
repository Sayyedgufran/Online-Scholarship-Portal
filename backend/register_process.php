<?php
require '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];
    $institute = $_POST['institute'];
    
    // ✅ SIMPLE PASSWORD - NO HASHING
    $password = $_POST['password'];

    // Check if email already exists
    if ($role == 'student') {
        $table = 'students';
        $check_stmt = $pdo->prepare("SELECT id FROM $table WHERE email = ?");
    } else {
        $table = 'providers';
        $check_stmt = $pdo->prepare("SELECT id FROM $table WHERE email = ?");
    }

    $check_stmt->execute([$email]);
    if ($check_stmt->fetch()) {
        echo "<script>alert('Email already registered!'); window.history.back();</script>";
        exit();
    }

    // Insert new user WITH SIMPLE PASSWORD
    if ($role == 'student') {
        $stmt = $pdo->prepare("INSERT INTO students (fullname, email, mobile, institute, password) VALUES (?, ?, ?, ?, ?)");
    } else {
        $stmt = $pdo->prepare("INSERT INTO providers (fullname, email, mobile, organization, password) VALUES (?, ?, ?, ?, ?)");
    }

    if ($stmt->execute([$fullname, $email, $mobile, $institute, $password])) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='../login.php';</script>";
    } else {
        echo "<script>alert('Registration failed!'); window.history.back();</script>";
    }
}
?>