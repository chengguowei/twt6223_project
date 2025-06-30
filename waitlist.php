<?php
include 'config.php';

$sql = "SELECT * FROM waitlist ORDER BY booking_date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table>
    <thead>
      <tr>
        <th>Email</th>
        <th>Venue</th>
        <th>Date</th>
        <th>Time Slot</th>
        <th>Purpose</th>
        <th>Added On</th>
      </tr>
    </thead>
    <tbody>";

  while ($row = $result->fetch_assoc()) {
    switch ($row['venue_id']) {
      case 1: $venue = "Main Hall"; break;
      case 2: $venue = "Exam Hall"; break;
      case 3: $venue = "Sport Hall"; break;
      case 4: $venue = "CLC"; break;
      case 5: $venue = "Library Room"; break;
      default: $venue = "Unknown"; break;
    }

    echo "<tr>
      <td>{$row['user_email']}</td>
      <td>$venue</td>
      <td>{$row['booking_date']}</td>
      <td>{$row['start_time']} - {$row['end_time']}</td>
      <td>{$row['purpose']}</td>
      <td>{$row['created_at']}</td>
    </tr>";
  }

  echo "</tbody></table>";
} else {
  echo "<p>No waitlist entries yet.</p>";
}

$conn->close();
?>
