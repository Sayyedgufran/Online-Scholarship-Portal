<?php
session_start();
require '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
        header("Location: ../login.php");
        exit();
    }

    $student_id = $_SESSION['user_id'];
    $scholarship_id = $_POST['scholarship_id'];
    $message = $_POST['message'];

    // Check if already applied
    $check_stmt = $pdo->prepare("SELECT id FROM applications WHERE student_id = ? AND scholarship_id = ?");
    $check_stmt->execute([$student_id, $scholarship_id]);
    
    if ($check_stmt->fetch()) {
        echo "<script>alert('You have already applied for this scholarship!'); window.history.back();</script>";
        exit();
    }

    // File upload handling
    $document_path = '';
    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        $upload_dir = '../assets/documents/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = time() . '_' . $_FILES['document']['name'];
        $document_path = 'documents/' . $file_name;
        
        move_uploaded_file($_FILES['document']['tmp_name'], $upload_dir . $file_name);
    }

    // Insert application
    $stmt = $pdo->prepare("INSERT INTO applications (student_id, scholarship_id, document_path, message) VALUES (?, ?, ?, ?)");
    
    if ($stmt->execute([$student_id, $scholarship_id, $document_path, $message])) {
        echo "<script>alert('Application submitted successfully!'); window.location.href='../student_dashboard.php';</script>";
    } else {
        echo "<script>alert('Application failed!'); window.history.back();</script>";
    }
}
?>