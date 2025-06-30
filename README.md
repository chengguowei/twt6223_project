# TWT6223 Project - University Venue Management System

This is a simple web-based venue booking system for the TWT6223 project.  
It uses **HTML**, **CSS**, **JavaScript**, **PHP**, **MySQL**, and **PHPMailer**.

---

## 📌 How to run locally

### 1️⃣ **Install XAMPP**

- Download and install [XAMPP](https://www.apachefriends.org/).
- Start **Apache** and **MySQL** in the XAMPP Control Panel.

---

### 2️⃣ **Download this project as a ZIP**

- Extract the folder.

---

### 3️⃣ **Place the project folder inside `xampp/htdocs`**

---

### 4️⃣ Set up the database

1. Open your browser → go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Click **Databases** → create a new database:
3. Click the **Import** tab.
4. Click **Choose File** → select `venue_management.sql` from this project folder.
5. Click **Go** to import. ✅
 
This creates:
- `venues` table (with predefined venue names)
- `bookings` table
- `waitlist` table

---

### 5️⃣ Configure the database connection

- Open `config.php` and check:
```php
$host = "localhost";
$user = "root";
$password = "";
$database = "venue_management";
```
✅ This is the default for XAMPP (no password for root).

### 6️⃣ Configure PHPMailer for email sending

Open mail.php and update your Gmail credentials:
```php
$mail->Username = 'YOUR_GMAIL@gmail.com';
$mail->Password = 'YOUR_APP_PASSWORD';
$mail->setFrom('YOUR_GMAIL@gmail.com', 'MMU Venue Management');
```
✅ Use a Google App Password, not your normal Gmail password.

To get an App Password:
1. Turn on 2-Step Verification in your Google account.
2. Generate an App Password for “Mail”.
3. Copy the 16-character password and paste it here.

### 7️⃣ Run the project

Open your browser and go to:
http://localhost/twt6223_project/index.html

✅ Now:
    Book a venue → if there is no conflict, the booking goes to the bookings table.
    If the time slot is already booked, it will be saved to the waitlist table.
    Confirmed bookings will trigger a confirmation email.


