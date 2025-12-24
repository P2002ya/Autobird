------ confirm_booking.php ------
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_SESSION['pickup'] = $_POST['pickup'];
  $_SESSION['pickup_lat'] = $_POST['pickup_lat'];
  $_SESSION['pickup_lng'] = $_POST['pickup_lng'];
  $_SESSION['destination'] = $_POST['destination'];
  $_SESSION['dest_lat'] = $_POST['dest_lat'];
  $_SESSION['dest_lng'] = $_POST['dest_lng'];
  $_SESSION['date'] = $_POST['date'];
  $_SESSION['time'] = $_POST['time'];
} else {
  echo "<script>alert('Access denied'); window.location='book1.php';</script>";
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Confirm Booking</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
<h2 class="mb-4">Confirm Your Ride</h2>
<table class="table">
  <tr><th>Pickup</th><td><?= htmlspecialchars($_SESSION['pickup']) ?></td></tr>
  <tr><th>Destination</th><td><?= htmlspecialchars($_SESSION['destination']) ?></td></tr>
  <tr><th>Date</th><td><?= htmlspecialchars($_SESSION['date']) ?></td></tr>
  <tr><th>Time</th><td><?= htmlspecialchars($_SESSION['time']) ?></td></tr>
</table>
<form action="book.php" method="POST">
  <button type="submit" class="btn btn-success">Confirm & Book</button>
  <a href="book1.php" class="btn btn-secondary">Back</a>
</form>
</body>
</html>
