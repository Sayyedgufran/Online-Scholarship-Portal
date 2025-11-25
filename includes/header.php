<?php 
// ERROR DISPLAY OFF for users
// Agar debugging chahiye to 0 ko 1 kar sakte ho
ini_set('display_errors', 0);
error_reporting(0);

// SESSION START - ONLY IF NOT STARTED
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Scholarship Portal</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/navbar.css">
</head>
<body>

<nav class="navbar navbar-custom navbar-expand-lg">
  <div class="container-fluid">

    <!-- LOGO -->
    <a class="navbar-brand" href="index.php">
      <img src="assets/images/logo.PNG" alt="Scholarship Portal" height="50" style="width: 280px;">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="view_scholarships.php">Scholarships</a></li>

        <!-- If user logged in -->
        <?php if(isset($_SESSION['user_id']) && isset($_SESSION['role'])): ?>

            <?php if($_SESSION['role'] === 'student'): ?>
              <li class="nav-item"><a class="nav-link" href="student_dashboard.php">Dashboard</a></li>

            <?php elseif($_SESSION['role'] === 'provider'): ?>
              <li class="nav-item"><a class="nav-link" href="provider_dashboard.php">Dashboard</a></li>

            <?php elseif($_SESSION['role'] === 'admin'): ?>
              <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>

            <?php endif; ?>

            <li class="nav-item">
              <a class="nav-link" href="backend/logout.php">
                Logout (<?php echo htmlspecialchars($_SESSION['name']); ?>)
              </a>
            </li>

        <!-- If NOT logged in -->
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
