<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'config.php';
include 'mail.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $venue_id = intval($_POST["venue_id"]);
    $booking_date = $_POST["booking_date"];
    $start_time = $_POST["start_time"];
    $duration = intval($_POST["duration"]);
    $purpose = trim($_POST["booking_purpose"]);

    $start = DateTime::createFromFormat('H:i', $start_time);
    $end = clone $start;
    $end->modify("+{$duration} hours");
    $end_time = $end->format('H:i');

    // ✅ 1️⃣ Conflict check
    $stmt = $conn->prepare("
        SELECT * FROM bookings
        WHERE venue_id = ? AND booking_date = ?
        AND (
            (start_time < ? AND end_time > ?)
            OR
            (start_time < ? AND end_time > ?)
            OR
            (start_time >= ? AND end_time <= ?)
            OR
            (start_time <= ? AND end_time >= ?)
        )
    ");

    $stmt->bind_param(
        "isssssssss",
        $venue_id,
        $booking_date,
        $end_time, $start_time,
        $end_time, $start_time,
        $start_time, $end_time,
        $start_time, $end_time
    );

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ✅ 2️⃣ Conflict → add to waitlist instead
        $stmt->close();

        $stmt = $conn->prepare("
            INSERT INTO waitlist (user_email, venue_id, booking_date, start_time, end_time, purpose)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sissss", $email, $venue_id, $booking_date, $start_time, $end_time, $purpose);

        if ($stmt->execute()) {
            echo "Booking conflict: added to waitlist successfully.<br>";
        } else {
            echo "Failed to add to waitlist: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();

    // ✅ 3️⃣ No conflict → confirmed booking
    $stmt = $conn->prepare("
        INSERT INTO bookings (user_email, venue_id, booking_date, start_time, end_time, purpose, status)
        VALUES (?, ?, ?, ?, ?, ?, 'Confirmed')
    ");
    $stmt->bind_param("sissss", $email, $venue_id, $booking_date, $start_time, $end_time, $purpose);

    if ($stmt->execute()) {
        // venue name for mail
        switch ($venue_id) {
            case 1: $venue = "Main Hall"; break;
            case 2: $venue = "Exam Hall"; break;
            case 3: $venue = "Sport Hall"; break;
            case 4: $venue = "CLC"; break;
            case 5: $venue = "Library Room"; break;
            default: $venue = "Unknown"; break;
        }

        echo "Booking successful.<br>";

        $sent = sendConfirmationEmail($email, $venue, $booking_date, $start_time, $end_time);

        if ($sent) {
            echo "Confirmation email sent successfully.<br>";
        } else {
            echo "Booking saved, but email failed.<br>";
        }

    } else {
        echo "Booking failed: " . $stmt->error;
    }

    echo "<a href='index.html'>Back</a>";

    $stmt->close();
    $conn->close();

} else {
    echo "Invalid request.";
}
