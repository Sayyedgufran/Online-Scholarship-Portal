<?php
// =============================================
// UPDATE SLIDER PROCESSING FILE
// Admin slider content aur images update karne ke liye
// =============================================

session_start();
require '../includes/db_connection.php';

// Check if user is admin and logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form data collect karo
    $slide_id = $_POST['slide_id'];
    $heading = $_POST['heading'];
    $description = $_POST['description'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];

    // Image upload handling
    $image_url = null;
    
    if (isset($_FILES['slide_image']) && $_FILES['slide_image']['error'] == 0) {
        $upload_dir = '../assets/images/';
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        $file_name = $_FILES['slide_image']['name'];
        $file_tmp = $_FILES['slide_image']['tmp_name'];
        $file_size = $_FILES['slide_image']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Validation
        if (!in_array($file_ext, $allowed_types)) {
            echo "<script>alert('❌ Only JPG, PNG & GIF images are allowed!'); window.history.back();</script>";
            exit();
        }
        
        if ($file_size > $max_size) {
            echo "<script>alert('❌ Image size must be less than 2MB!'); window.history.back();</script>";
            exit();
        }
        
        // New file name: slide1_uploaded.jpg, slide2_uploaded.jpg, etc.
        $new_file_name = 'slide' . $slide_id . '_uploaded.' . $file_ext;
        
        // Upload file
        if (move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
            $image_url = $new_file_name;
        } else {
            echo "<script>alert('❌ Error uploading image!'); window.history.back();</script>";
            exit();
        }
    }
    
    // Database me update karo
    if ($image_url) {
        // Agar new image upload hui hai to image_url bhi update karo
        $stmt = $pdo->prepare("UPDATE slider_content SET heading = ?, description = ?, button_text = ?, button_link = ?, image_url = ? WHERE id = ?");
        $result = $stmt->execute([$heading, $description, $button_text, $button_link, $image_url, $slide_id]);
    } else {
        // Agar image nahi upload hui to sirf content update karo
        $stmt = $pdo->prepare("UPDATE slider_content SET heading = ?, description = ?, button_text = ?, button_link = ? WHERE id = ?");
        $result = $stmt->execute([$heading, $description, $button_text, $button_link, $slide_id]);
    }
    
    // Execute query and check success
    if ($result) {
        echo "<script>alert('✅ Slider updated successfully!'); window.location.href='../admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('❌ Error updating slider!'); window.history.back();</script>";
    }
} else {
    // If direct access, redirect to admin dashboard
    header("Location: ../admin_dashboard.php");
    exit();
}
?>