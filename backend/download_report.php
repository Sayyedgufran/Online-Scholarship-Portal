<?php
require '../includes/db_connection.php';

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=system_report.xls");

$students = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$providers = $pdo->query("SELECT COUNT(*) FROM providers")->fetchColumn();
$scholarships = $pdo->query("SELECT COUNT(*) FROM scholarships")->fetchColumn();
$applications = $pdo->query("SELECT COUNT(*) FROM applications")->fetchColumn();

$approved = $pdo->query("SELECT COUNT(*) FROM applications WHERE status='approved'")->fetchColumn();
$rejected = $pdo->query("SELECT COUNT(*) FROM applications WHERE status='rejected'")->fetchColumn();
$pending = $pdo->query("SELECT COUNT(*) FROM applications WHERE status='pending'")->fetchColumn();

echo "
<h2>System Report</h2>
<table border='1'>
<tr><th>Category</th><th>Total</th></tr>
<tr><td>Students</td><td>$students</td></tr>
<tr><td>Providers</td><td>$providers</td></tr>
<tr><td>Scholarships</td><td>$scholarships</td></tr>
<tr><td>Total Applications</td><td>$applications</td></tr>
<tr><td>Approved</td><td>$approved</td></tr>
<tr><td>Rejected</td><td>$rejected</td></tr>
<tr><td>Pending</td><td>$pending</td></tr>
</table>
";
