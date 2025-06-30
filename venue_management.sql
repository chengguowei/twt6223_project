-- Create the database
CREATE DATABASE IF NOT EXISTS venue_management;
USE venue_management;

-- Create venues table
CREATE TABLE IF NOT EXISTS venues (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Create bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(255) NOT NULL,
    venue_id INT NOT NULL,
    booking_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    purpose TEXT NOT NULL,
    status ENUM('Confirmed', 'Waitlisted') NOT NULL DEFAULT 'Confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (venue_id) REFERENCES venues(id)
);

-- (Optional) Create waitlist table if you decide to store it
CREATE TABLE IF NOT EXISTS waitlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(255) NOT NULL,
    venue_id INT NOT NULL,
    booking_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    purpose TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (venue_id) REFERENCES venues(id)
);

-- Insert initial venues
INSERT INTO venues (id, name) VALUES
    (1, 'Main Hall'),
    (2, 'Exam Hall'),
    (3, 'Sport Hall'),
    (4, 'CLC'),
    (5, 'Library Room');
