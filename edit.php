<?php
// edit.php — UPDATE, part 1: show the booking back in the form, filled in.
// If process-edit.php sent the form back with errors, the session carries
// the messages (printed beside their fields) and the values just typed.
session_start();
$page_title = 'Edit booking';
require __DIR__ . '/includes/db.php';
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM bookings WHERE id = :id');
$stmt->execute([':id' => $id]);
$booking = $stmt->fetch();
$areas = $pdo->query('SELECT id, name FROM areas ORDER BY id')->fetchAll();
$services = ['Household collection', 'Business collection', 'Recycling',
 'Skip hire', 'One-off cleanup'];
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
// What the form shows: what was just typed if the server sent it back,
// otherwise what is stored in the database.
$shown = [
 'fullname' => $old['fullname'] ?? ($booking['fullname'] ?? ''),
 'phone' => $old['phone'] ?? ($booking['phone'] ?? ''),
 'area' => $old['area'] ?? ($booking['area_id'] ?? 0),
 'service' => $old['service'] ?? ($booking['service'] ?? ''),
 'notes' => $old['notes'] ?? ($booking['notes'] ?? ''),
];
include 'includes/header.php';
?>
<main>
<?php if (!$booking): ?>
<p>No booking with that number. <a href="bookings.php">Back to bookings</a></p>
<?php else: ?>
<p>Change what needs changing, then save.</p>
<form action="process-edit.php" method="POST">
<input type="hidden" name="id" value="<?= (int) $booking['id'] ?>">
<label for="fullname">Full name</label>
<input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($shown['fullname']) ?>" required>
<?php if (isset($errors['fullname'])): ?>
<p class="field-error"><?= htmlspecialchars($errors['fullname']) ?></p>
<?php endif; ?>
<label for="phone">Phone number</label>
<input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($shown['phone']) ?>" required>
<?php if (isset($errors['phone'])): ?>
<p class="field-error"><?= htmlspecialchars($errors['phone']) ?></p>
<?php endif; ?>
<label for="area">Area</label>
<select id="area" name="area">
<?php foreach ($areas as $area): ?>
<option value="<?= (int) $area['id'] ?>"<?= (int) $shown['area'] === (int) $area['id'] ? ' selected' : '' ?>><?= htmlspecialchars($area['name']) ?></option>
<?php endforeach; ?>
</select>
<?php if (isset($errors['area'])): ?>
<p class="field-error"><?= htmlspecialchars($errors['area']) ?></p>
<?php endif; ?>
<label for="service">Service</label>
<select id="service" name="service">
<?php foreach ($services as $service): ?>
<option<?= $shown['service'] === $service ? ' selected' : '' ?>><?= htmlspecialchars($service) ?></option>
<?php endforeach; ?>
</select>
<?php if (isset($errors['service'])): ?>
<p class="field-error"><?= htmlspecialchars($errors['service']) ?></p>
<?php endif; ?>
<label for="notes">Anything we should know?</label>
<textarea id="notes" name="notes" rows="4"><?= htmlspecialchars($shown['notes']) ?></textarea>
<button type="submit">Save changes</button>
</form>
<p><a href="bookings.php">Back to bookings without saving</a></p>
<?php endif; ?>
</main>
<aside>
<h2>Collection notices</h2>
<ul>
<li>Put your bin out by 7 a.m. on your collection day — the truck does not come back for late bins.</li>
<li>Public holidays: collections move to the next day.</li>
</ul>
</aside>
<footer>
<p>Mwananchi Garbage · Nairobi · Collections Monday to Saturday</p>
</footer>
<?php include 'includes/footer.php'; ?>
