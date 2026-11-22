<?php
// header.php — the top of every page: the head, the site name, and the nav.
// Each page sets $page_title before including this file.
$page_title = $page_title ?? 'Mwananchi Garbage';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo htmlspecialchars($page_title); ?> — Mwananchi Garbage</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@600&display=swap">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
<p><strong>Mwananchi Garbage</strong></p>
<h1><?php echo htmlspecialchars($page_title); ?></h1>
</header>
<nav>
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="about.php">About</a></li>
<li><a href="services.php">Services</a></li>
<li><a href="areas.php">Areas</a></li>
<li><a href="pricing.php">Pricing</a></li>
<li><a href="book.php">Book</a></li>
<li><a href="bookings.php">Bookings</a></li>
<li><a href="contact.php">Contact</a></li>
</ul>
</nav>
