<?php
// bookings.php — VIEW + SEARCH + DELETE.
// View: every booking in the table, newest first, with its area name
// joined in from the areas table.
// Search: ?q= asks the database again, matching name, phone, area or
// service (a prepared statement). The "filter as you type" box under it
// is JavaScript (js/main.js) narrowing the rows already on screen.
// Delete: each row has a small form that posts to process-delete.php.
$page_title = 'Bookings';
require __DIR__ . '/includes/db.php';
$q = trim($_GET['q'] ?? '');
if ($q === '') {
 $stmt = $pdo->query(
 'SELECT b.*, a.name AS area FROM bookings b
 JOIN areas a ON a.id = b.area_id ORDER BY b.id DESC'
 );
 $bookings = $stmt->fetchAll();
} else {
 $stmt = $pdo->prepare(
 'SELECT b.*, a.name AS area FROM bookings b
 JOIN areas a ON a.id = b.area_id
 WHERE b.fullname LIKE :q OR b.phone LIKE :q OR a.name LIKE :q OR b.service LIKE :q
 ORDER BY b.id DESC'
 );
 $stmt->execute([':q' => '%' . $q . '%']);
 $bookings = $stmt->fetchAll();
}
include 'includes/header.php';
?>
<main>
<?php if (isset($_GET['updated'])): ?>
<p>Booking saved.</p>
<?php elseif (isset($_GET['deleted'])): ?>
<p>Booking deleted.</p>
<?php endif; ?>
<p>Every booking the team has taken, newest first. Search by name, phone, area or service.</p>
<form method="GET" action="bookings.php">
<label for="q">Search bookings</label>
<input type="search" id="q" name="q" value="<?= htmlspecialchars($q) ?>">
<button type="submit">Search</button>
<?php if ($q !== ''): ?>
<a href="bookings.php">Show all</a>
<?php endif; ?>
</form>
<p><?= count($bookings) ?> booking(s)<?= $q !== '' ? ' matching "' . htmlspecialchars($q) . '"' : '' ?>.</p>
<?php if (!empty($bookings)): ?>
<p>
<label for="booking-filter">Filter this list as you type</label>
<input type="search" id="booking-filter">
</p>
<div class="table-scroll">
<table id="bookings-table">
<thead>
<tr><th>#</th><th>Name</th><th>Phone</th><th>Area</th><th>Service</th><th>Notes</th><th>Booked</th><th></th></tr>
</thead>
<tbody>
<?php foreach ($bookings as $b): ?>
<tr>
<td><?= (int) $b['id'] ?></td>
<td><?= htmlspecialchars($b['fullname']) ?></td>
<td><?= htmlspecialchars($b['phone']) ?></td>
<td><?= htmlspecialchars($b['area']) ?></td>
<td><?= htmlspecialchars($b['service']) ?></td>
<td><?= htmlspecialchars($b['notes']) ?></td>
<td><?= htmlspecialchars($b['created_at']) ?></td>
<td>
<a href="edit.php?id=<?= (int) $b['id'] ?>">Edit</a>
<form class="inline-form" action="process-delete.php" method="POST">
<input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
<button type="submit" onclick="return confirm('Delete this booking?')">Delete</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php endif; ?>
<?php if (empty($bookings)): ?>
<p>No bookings yet. <a href="book.php">Book a collection</a> to add the first one.</p>
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
