<?php
// process-edit.php — UPDATE, part 2: check the form on the server, then
// write the changed booking back with a PDO prepared UPDATE. On a failed
// check the errors go in the session and edit.php shows each message
// beside its field.
session_start();
require __DIR__ . '/includes/db.php';

$services = ['Household collection', 'Business collection', 'Recycling',
 'Skip hire', 'One-off cleanup'];

if (isset($_POST['id'])) {
 $id = (int) $_POST['id'];
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
 header('Location: edit.php?id=' . $id);
 exit;
 }

 $stmt = $pdo->prepare(
 'UPDATE bookings SET fullname = :fullname, phone = :phone,
 area_id = :area_id, service = :service, notes = :notes WHERE id = :id'
 );
 $stmt->execute([
 ':fullname' => $fullname,
 ':phone' => $phone,
 ':area_id' => $area_id,
 ':service' => $service,
 ':notes' => $notes,
 ':id' => $id,
 ]);
 header('Location: bookings.php?updated=1');
 exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit booking — Mwananchi Garbage</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<main>
<p>No booking to change. <a href="bookings.php">Back to bookings</a></p>
</main>
</body>
</html>
