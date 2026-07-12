<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Booking | Pakistan Tours</title>
    <style>
        /* ── Reset ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eaf4ea;
            min-height: 100vh;
            padding: 40px 16px 60px;
            color: #1a2e1a;
        }

        /* ── Header ── */
        .page-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .page-header h1 {
            font-size: 2rem;
            color: #1b5e20;
            font-weight: 700;
        }
        .page-header p {
            color: #4a6a4a;
            margin-top: 6px;
            font-size: 0.97rem;
        }

        /* ── Navbar ── */
        .navbar {
            background: #1b5e20;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px;
            max-width: 700px;
            margin: 0 auto 30px;
        }
        .navbar span { color: #fff; font-weight: 600; font-size: 1rem; }
        .navbar a {
            color: #a5d6a7;
            text-decoration: none;
            font-size: 0.92rem;
            margin-left: 16px;
            transition: color 0.2s;
        }
        .navbar a:hover { color: #fff; }

        /* ── Form Card ── */
        .form-card {
            max-width: 540px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 36px 38px;
            box-shadow: 0 6px 28px rgba(27,94,32,0.13), 0 2px 8px rgba(0,0,0,0.06);
        }

        .form-card h2 {
            font-size: 1.3rem;
            color: #1b5e20;
            margin-bottom: 22px;
            padding-bottom: 12px;
            border-bottom: 2px solid #c8e6c9;
        }

        /* ── Form Groups ── */
        .form-group { margin-bottom: 18px; }

        label {
            display: block;
            font-weight: bold;
            font-size: 0.88rem;
            color: #2a4a2a;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid #c8ddc8;
            border-radius: 7px;
            font-family: inherit;
            font-size: 0.95rem;
            color: #1a2e1a;
            background: #f8fbf8;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        input:focus, select:focus {
            border-color: #2e7d32;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(46,125,50,0.12);
        }

        /* ── Radio Group ── */
        .radio-group { display: flex; gap: 22px; flex-wrap: wrap; margin-top: 4px; }
        .radio-group label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-weight: 500;
            text-transform: none;
            font-size: 0.95rem;
            cursor: pointer;
        }
        input[type="radio"] { accent-color: #2e7d32; width: 16px; height: 16px; cursor: pointer; }

        /* ── Buttons ── */
        .btn-row { display: flex; gap: 12px; margin-top: 26px; }

        input[type="submit"] {
            flex: 1;
            width: 100%;
            background: #2e7d32;
            color: #ffffff;
            border: none;
            padding: 13px 0;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 7px;
            cursor: pointer;
            letter-spacing: 0.03em;
            transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 4px 12px rgba(46,125,50,0.25);
        }
        input[type="submit"]:hover {
            background: #1b5e20;
            box-shadow: 0 6px 18px rgba(27,94,32,0.30);
            transform: translateY(-1px);
        }

        input[type="reset"] {
            flex: 0 0 auto;
            background: transparent;
            color: #5a7a5a;
            border: 1.5px solid #c8ddc8;
            padding: 13px 22px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 7px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }
        input[type="reset"]:hover {
            background: #f0f7f0;
            color: #2e7d32;
            border-color: #2e7d32;
        }

        /* ── Table Section ── */
        .table-section {
            max-width: 540px;
            margin: 40px auto 0;
        }
        .table-section h2 {
            font-size: 1.25rem;
            color: #1b5e20;
            margin-bottom: 14px;
            text-align: center;
            font-weight: 700;
        }
        .destinations-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(34,80,34,0.10);
            font-size: 0.91rem;
        }
        .destinations-table th {
            background: #2e7d32;
            color: #fff;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #256427;
        }
        .destinations-table td {
            padding: 10px 15px;
            border: 1px solid #ddeedd;
            color: #2a3a2a;
        }
        .destinations-table tr:nth-child(even) td { background: #f5faf5; }
        .destinations-table tr:hover td { background: #eaf5ea; }
        .price { font-weight: 700; color: #2e7d32; }

        /* ── Footer ── */
        .footer {
            text-align: center;
            margin-top: 36px;
            font-size: 0.82rem;
            color: #7a9a7a;
        }
    </style>
</head>
<body>

<div class="navbar">
    <span>&#9992; Pakistan Tours</span>
    <div>
        <a href="trip.php">Home</a>
        <a href="login.php">My Bookings</a>
    </div>
</div>

<div class="page-header">
    <h1>&#9992; Trip Booking Form</h1>
    <p>Plan your perfect journey across Pakistan</p>
</div>

<!-- Booking Form -->
<div class="form-card">
    <h2>&#128205; Book Your Trip</h2>

    <form action="booking.php" method="POST">

        <div class="form-group">
            <label for="traveller_name">Traveller Name</label>
            <input type="text" id="traveller_name" name="traveller_name"
                   placeholder="Enter your full name">
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email"
                   placeholder="you@example.com">
        </div>

        <div class="form-group">
            <label for="destination">Destination</label>
            <select id="destination" name="destination">
                <option value="" disabled selected>Select a destination</option>
                <option value="lahore">Lahore</option>
                <option value="karachi">Karachi</option>
                <option value="islamabad">Islamabad</option>
                <option value="murree">Murree</option>
                <option value="swat">Swat</option>
            </select>
        </div>

        <div class="form-group">
            <label for="departure_date">Departure Date</label>
            <input type="date" id="departure_date" name="departure_date">
        </div>

        <div class="form-group">
            <label for="num_travellers">Number of Travellers</label>
            <input type="number" id="num_travellers" name="num_travellers"
                   min="1" max="20" placeholder="e.g. 2">
        </div>

        <div class="form-group">
            <label>Trip Type</label>
            <div class="radio-group">
                <label><input type="radio" name="trip_type" value="Family"> Family</label>
                <label><input type="radio" name="trip_type" value="Friends"> Friends</label>
                <label><input type="radio" name="trip_type" value="Solo"> Solo</label>
            </div>
        </div>

        <div class="btn-row">
            <input type="submit" value="Book Now">
            <input type="reset" value="Reset">
        </div>

    </form>
</div>

<!-- Popular Destinations Table -->
<div class="table-section">
    <h2>&#127758; Popular Destinations</h2>
    <table class="destinations-table">
        <thead>
            <tr>
                <th>Destination</th>
                <th>Best Time to Visit</th>
                <th>Price Per Person (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Lahore</td>
                <td>October – February</td>
                <td class="price">Rs. 5,000</td>
            </tr>
            <tr>
                <td>Karachi</td>
                <td>November – March</td>
                <td class="price">Rs. 8,000</td>
            </tr>
            <tr>
                <td>Islamabad</td>
                <td>March – May</td>
                <td class="price">Rs. 6,000</td>
            </tr>
            <tr>
                <td>Murree</td>
                <td>June – September</td>
                <td class="price">Rs. 7,000</td>
            </tr>
            <tr>
                <td>Swat</td>
                <td>April – October</td>
                <td class="price">Rs. 9,000</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="footer">
    <p>&copy; 2025 Pakistan Tours &mdash; MidTerm Project | Roll No: 232201040 | Fatima</p>
</div>

</body>
</html>
