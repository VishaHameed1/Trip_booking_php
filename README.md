# MidTerm_232201040_Fatima — Setup Guide

## Project Structure
```
MidTerm_232201040_Fatima/
├── trip.php         → Booking form (Q1)
├── booking.php      → Form processing + price calculator (Q2)
├── login.php        → Traveller login with sessions (Q3-A)
├── mybookings.php   → Protected dashboard + session counter (Q3-B)
├── logout.php       → Session destroy + redirect (Q3-B)
└── README.md        → This file
```

---

## Step-by-Step Implementation on XAMPP + VS Code

### STEP 1 — Install XAMPP
1. Download XAMPP from https://www.apachefriends.org
2. Install it (default path: C:\xampp on Windows)
3. Open **XAMPP Control Panel**
4. Start **Apache** (click Start next to Apache)
5. You should see Apache turn green ✅

> **Note:** MySQL is NOT required for this project — it uses PHP sessions only.

---

### STEP 2 — Copy Project Files
1. Navigate to your XAMPP htdocs folder:
   - Windows: `C:\xampp\htdocs\`
   - Mac/Linux: `/Applications/XAMPP/htdocs/` or `/opt/lampp/htdocs/`
2. Create a new folder named: `MidTerm_232201040_Fatima`
3. Copy all `.php` files into that folder

Final path should look like:
```
C:\xampp\htdocs\MidTerm_232201040_Fatima\trip.php
C:\xampp\htdocs\MidTerm_232201040_Fatima\booking.php
C:\xampp\htdocs\MidTerm_232201040_Fatima\login.php
C:\xampp\htdocs\MidTerm_232201040_Fatima\mybookings.php
C:\xampp\htdocs\MidTerm_232201040_Fatima\logout.php
```

---

### STEP 3 — Open in VS Code (Optional but Recommended)
1. Open VS Code
2. File → Open Folder → select `MidTerm_232201040_Fatima`
3. Install extension: **PHP Intelephense** (for syntax highlighting)
4. You can edit any file directly — changes reflect immediately in browser

---

### STEP 4 — Run the Project
Open your browser and go to:
```
http://localhost/MidTerm_232201040_Fatima/trip.php
```

---

## How to Use Each Page

| Page | URL | Purpose |
|------|-----|---------|
| Booking Form | `/trip.php` | Fill & submit trip form |
| Booking Summary | `/booking.php` | Auto-redirect after form |
| Login | `/login.php` | Log in as traveller |
| My Bookings | `/mybookings.php` | Protected dashboard |
| Logout | `/logout.php` | Destroys session |

---

## Demo Login Credentials

| Username  | Password | Name         |
|-----------|----------|--------------|
| traveler1 | trip123  | Bilal Ahmed  |
| traveler2 | tour456  | Ayesha Malik |

---

## Features Implemented

### Question 1 — trip.php
- ✅ Complete HTML5 structure
- ✅ Internal `<style>` block
- ✅ All 6 form fields (name, email, destination, date, travellers, trip type)
- ✅ Book Now + Reset buttons
- ✅ `action="booking.php"` and `method="POST"`
- ✅ Popular Destinations table with green header + borders

### Question 2 — booking.php
- ✅ Receives data via `$_POST`
- ✅ Validates all required fields
- ✅ Red error message + Go Back link on failure
- ✅ `htmlspecialchars()` + `trim()` sanitization
- ✅ `ucwords()` for name, `strtoupper()` for destination
- ✅ Booking Summary table
- ✅ Base price array (Lahore:5000, Karachi:8000, etc.)
- ✅ Total = base price × travelers
- ✅ 10% group discount for 5+ travelers
- ✅ `number_format()` with Rs. prefix
- ✅ Booking reference: `TR` + timestamp
- ✅ "Booked On" using `date()`

### Question 3 — Sessions
- ✅ `login.php` — Hardcoded accounts, loop validation, `session_regenerate_id(true)`
- ✅ `mybookings.php` — `session_start()`, redirect if not logged in, welcome message
- ✅ `$_SESSION['visits']` counter incremented on each load
- ✅ Static dummy bookings table (5 rows)
- ✅ `logout.php` — `session_unset()`, `session_destroy()`, redirect with `?msg=bye`
- ✅ Green "Logged out successfully" banner on login page

---

## Troubleshooting

**Apache won't start?**
- Another program (Skype, IIS) may be using port 80
- In XAMPP Control Panel → Apache → Config → `httpd.conf` → change `Listen 80` to `Listen 8080`
- Access via `http://localhost:8080/...`

**Blank page or PHP not running?**
- Make sure Apache is started in XAMPP
- File extension must be `.php` not `.html`
- Check `C:\xampp\php\logs\php_error_log` for errors

**Session not working?**
- Sessions require cookies — make sure browser cookies are enabled
- Don't open PHP files directly from File Explorer; always use `localhost`

---

*MidTerm Project | Roll No: 232201040 | Student: Fatima | 2025*
