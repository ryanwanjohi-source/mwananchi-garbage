<?php
// process-book.php — SAVE, part 2: check the form on the server, then
// write one row. Every field is checked again here (the browser checks
// in js/main.js can be switched off, these cannot). If a check fails,
// the errors go in the session and the form shows each message beside
// its field. The INSERT is a PDO prepared statement.
session_start();
require __DIR__ . '/includes/db.php';

$services = ['Household collection', 'Business collection', 'Recycling',
 'Skip hire', 'One-off cleanup'];

if (isset($_POST['fullname'])) {
 $fullname = trim($_POST['fullname']);
 $phone = trim($_POST['phone']);
 $area_id = (int) ($_POST['area'] ?? 0);
 $service = trim($_POST['service']);
 $notes = trim($_POST['notes'] ?? '');

 $errors = [];
 if ($fullname === '') {
 $errors['fullname'] = 'Please enter your full name.';
 }
 if (strlen($phone) < 9) {
 $errors['phone'] = 'Please enter a valid phone number.';
 }
 $stmt = $pdo->prepare('SELECT COUNT(*) FROM areas WHERE id = :id');
 $stmt->execute([':id' => $area_id]);
 if ((int) $stmt->fetchColumn() === 0) {
 $errors['area'] = 'Please choose an area.';
 }
 if (!in_array($service, $services, true)) {
 $errors['service'] = 'Please choose a service.';
 }

 if (!empty($errors)) {
 $_SESSION['errors'] = $errors;
 $_SESSION['old'] = $_POST;
 header('Location: book.php');
 exit;
 }

 $stmt = $pdo->prepare(
 'INSERT INTO bookings (fullname, phone, area_id, service, notes)
 VALUES (:fullname, :phone, :area_id, :service, :notes)'
 );
 $stmt->execute([
 ':fullname' => $fullname,
 ':phone' => $phone,
 ':area_id' => $area_id,
 ':service' => $service,
 ':notes' => $notes,
 ]);
 header('Location: book.php?booked=1');
 exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Book a collection — Mwananchi Garbage</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<main>
<p>No booking. This page answers the booking form. Fill it in first.</p>
<p><a href="book.php">Back to the form</a></p>
</main>
</body>
</html>
