<?php
include 'config.php';

$sql = "SELECT * FROM bookings ORDER BY booking_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table>
    <tr>
      <th>Date</th>
      <th>Venue</th>
      <th>Time Slot</th>
      <th>Booked Time</th>
    </tr>";
  while($row = $result->fetch_assoc()) {
    // Map venue_id to name
    switch ($row['venue_id']) {
      case 1: $venue = "Main Hall"; break;
      case 2: $venue = "Exam Hall"; break;
      case 3: $venue = "Sport Hall"; break;
      case 4: $venue = "CLC"; break;
      case 5: $venue = "Library Room"; break;
      default: $venue = "Unknown"; break;
    }
    $timeSlot = $row['start_time'] . " - " . $row['end_time'];
    echo "<tr>
      <td>{$row['booking_date']}</td>
      <td>{$venue}</td>
      <td>{$timeSlot}</td>
      <td>{$row['created_at']}</td>
    </tr>";
  }
  echo "</table>";
} else {
  echo "<p>No bookings found.</p>";
}

$conn->close();
?>
