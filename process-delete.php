<?php
// process-delete.php — DELETE: remove one booking, then back to the list.
// Only answers a POST (the Delete button on bookings.php), never a plain link.
ini_set('display_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/includes/db.php';
if (isset($_POST['id'])) {
 $stmt = $pdo->prepare('DELETE FROM bookings WHERE id = :id');
 $stmt->execute([':id' => (int) $_POST['id']]);
}
header('Location: bookings.php?deleted=1');
exit;
