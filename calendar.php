<?php
include 'config.php';

$sql = "SELECT * FROM bookings ORDER BY booking_date ASC";
$result = $conn->query($sql);

$bookings = [];
while($row = $result->fetch_assoc()) {
  $venue = "";
  switch ($row['venue_id']) {
    case 1: $venue = "Main Hall"; break;
    case 2: $venue = "Exam Hall"; break;
    case 3: $venue = "Sport Hall"; break;
    case 4: $venue = "CLC"; break;
    case 5: $venue = "Library Room"; break;
  }

  $bookings[] = [
    'date' => $row['booking_date'],
    'time' => $row['start_time'] . ' - ' . $row['end_time'],
    'venue' => $venue
  ];
}

header('Content-Type: application/json');
echo json_encode($bookings);

$conn->close();
?>
