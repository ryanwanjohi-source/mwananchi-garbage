<?php
// book.php — SAVE, part 1: the booking form.
// The area list comes from the areas table, so the form and the database
// can never disagree. If process-book.php sent the form back with errors,
// they sit in the session for this one load: each message is printed
// beside its own field, and the typed values are filled back in.
session_start();
$page_title = 'Book a collection';
require __DIR__ . '/includes/db.php';
$areas = $pdo->query('SELECT id, name FROM areas ORDER BY id')->fetchAll();
$services = ['Household collection', 'Business collection', 'Recycling',
 'Skip hire', 'One-off cleanup'];
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
include 'includes/header.php';
?>

<main>
<?php if (isset($_GET['booked']) && $_GET['booked'] === '1'): ?>
<?php
$stmt = $pdo->query(
 'SELECT b.*, a.name AS area FROM bookings b
 JOIN areas a ON a.id = b.area_id ORDER BY b.id DESC LIMIT 1'
);
$booking = $stmt->fetch();
?>
<?php if ($booking): ?>
<p>Thank you, <?= htmlspecialchars($booking['fullname']) ?>.</p>
<p>We have your <?= htmlspecialchars($booking['service']) ?> booking for <?= htmlspecialchars($booking['area']) ?>.</p>
<p>We will call you on <?= htmlspecialchars($booking['phone']) ?> the same working day to confirm the day and the price.</p>
<p><a href="bookings.php">See all bookings</a></p>
<?php endif; ?>
<?php endif; ?>
<p>New customer, extra pickup or skip hire — fill in this form and we will call you back the same working day to confirm the day and the price before anything is booked.</p>
<form id="book-form" action="process-book.php" method="POST">
<label for="fullname">Full name</label>
<input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($old['fullname'] ?? '') ?>" required>
<?php if (isset($errors['fullname'])): ?>
<p class="field-error"><?= htmlspecialchars($errors['fullname']) ?></p>
<?php endif; ?>
<label for="phone">Phone number</label>
<input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>" required>
<?php if (isset($errors['phone'])): ?>
<p class="field-error"><?= htmlspecialchars($errors['phone']) ?></p>
<?php endif; ?>
<label for="area">Area</label>
<select id="area" name="area">
<?php foreach ($areas as $area): ?>
<option value="<?= (int) $area['id'] ?>"<?= (int) ($old['area'] ?? 0) === (int) $area['id'] ? ' selected' : '' ?>><?= htmlspecialchars($area['name']) ?></option>
<?php endforeach; ?>
</select>
<?php if (isset($errors['area'])): ?>
<p class="field-error"><?= htmlspecialchars($errors['area']) ?></p>
<?php endif; ?>
<label for="service">Service</label>
<select id="service" name="service">
<?php foreach ($services as $service): ?>
<option<?= ($old['service'] ?? '') === $service ? ' selected' : '' ?>><?= htmlspecialchars($service) ?></option>
<?php endforeach; ?>
</select>
<?php if (isset($errors['service'])): ?>
<p class="field-error"><?= htmlspecialchars($errors['service']) ?></p>
<?php endif; ?>
<label for="notes">Anything we should know?</label>
<textarea id="notes" name="notes" rows="4"><?= htmlspecialchars($old['notes'] ?? '') ?></textarea>
<button type="submit">Book a collection</button>
<p id="form-message" aria-live="polite"></p>
</form>
</main>

<aside>
<h2>Collection notices</h2>
<ul>
<li>Put your bin out by 7 a.m. on your collection day — the truck does not come back for late bins.</li>
<li>Public holidays: collections move to the next day.</li>
<li>Need an extra pickup? <a href="book.php">Book one here</a>.</li>
</ul>
</aside>

<footer>
<p>Mwananchi Garbage · Nairobi · Collections Monday to Saturday</p>
</footer>

<?php include 'includes/footer.php'; ?>
