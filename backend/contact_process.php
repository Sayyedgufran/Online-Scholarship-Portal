<?php
require '../includes/db_connection.php';  // DB connect

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Save to database
    $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) 
                           VALUES (?, ?, ?, ?)");
    $saved = $stmt->execute([$name, $email, $subject, $message]);

    if ($saved) {
        echo "<script>
                alert('Thank you! Your message has been submitted successfully.');
                window.location.href='../contact.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to submit message! Please try again.');
                window.location.href='../contact.php';
              </script>";
    }
}
?>
