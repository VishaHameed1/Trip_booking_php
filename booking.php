<?php
// ── booking.php ── Form processing, validation & price calculation ──

// Redirect if accessed directly without POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: trip.php');
    exit;
}

// ── 1. Receive POST data ──
$traveller_name  = $_POST['traveller_name']  ?? '';
$email           = $_POST['email']           ?? '';
$destination     = $_POST['destination']     ?? '';
$departure_date  = $_POST['departure_date']  ?? '';
$num_travellers  = $_POST['num_travellers']  ?? '';
$trip_type       = $_POST['trip_type']       ?? '';

// ── 2. Validation ──
$errors = [];

if (trim($traveller_name) === '') $errors[] = 'Traveller Name is required.';
if (trim($email) === '')          $errors[] = 'Email Address is required.';
if (trim($destination) === '')    $errors[] = 'Destination is required.';
if (trim($departure_date) === '') $errors[] = 'Departure Date is required.';
if (trim($num_travellers) === '') $errors[] = 'Number of Travellers is required.';
if (trim($trip_type) === '')      $errors[] = 'Trip Type is required.';

// ── 3. Price base array ──
$base_prices = [
    'lahore'    => 5000,
    'karachi'   => 8000,
    'islamabad' => 6000,
    'murree'    => 7000,
    'swat'      => 9000,
];

// ── 4. Sanitize (only if valid) ──
if (empty($errors)) {
    $traveller_name = ucwords(trim(htmlspecialchars($traveller_name)));
    $email          = trim(htmlspecialchars($email));
    $destination    = trim(htmlspecialchars($destination));
    $departure_date = trim(htmlspecialchars($departure_date));
    $num_travellers = (int) trim($num_travellers);
    $trip_type      = trim(htmlspecialchars($trip_type));

    // Destination display
    $destination_display = strtoupper($destination);

    // ── 5. Price Calculation ──
    $base_price    = $base_prices[$destination] ?? 0;
    $subtotal      = $base_price * $num_travellers;
    $discount      = 0;
    $discount_pct  = 0;

    if ($num_travellers >= 5) {
        $discount_pct = 10;
        $discount     = $subtotal * 0.10;
    }

    $total = $subtotal - $discount;

    // ── 6. Booking Reference ──
    $booking_ref  = 'TR' . time();
    $booked_on    = date('d M Y, h:i A');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Summary | Pakistan Tours</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eaf4ea;
            min-height: 100vh;
            padding: 40px 16px 60px;
            color: #1a2e1a;
        }

        /* Navbar */
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
        .navbar a { color: #a5d6a7; text-decoration: none; font-size: 0.92rem; margin-left: 16px; }
        .navbar a:hover { color: #fff; }

        /* Page Header */
        .page-header { text-align: center; margin-bottom: 28px; }
        .page-header h1 { font-size: 1.9rem; color: #1b5e20; font-weight: 700; }
        .page-header p { color: #4a6a4a; margin-top: 6px; font-size: 0.95rem; }

        /* Error Card */
        .error-card {
            max-width: 540px;
            margin: 0 auto;
            background: #fff0f0;
            border: 2px solid #e53935;
            border-radius: 10px;
            padding: 28px 32px;
            box-shadow: 0 4px 16px rgba(229,57,53,0.10);
        }
        .error-card h2 { color: #c62828; font-size: 1.15rem; margin-bottom: 14px; }
        .error-card ul { padding-left: 20px; }
        .error-card ul li {
            color: #c62828;
            font-size: 0.95rem;
            margin-bottom: 6px;
        }
        .go-back {
            display: inline-block;
            margin-top: 20px;
            background: #c62828;
            color: #fff;
            padding: 10px 24px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: background 0.2s;
        }
        .go-back:hover { background: #b71c1c; }

        /* Summary Card */
        .summary-card {
            max-width: 620px;
            margin: 0 auto;
            background: #fff;
            border-radius: 14px;
            padding: 36px 38px;
            box-shadow: 0 8px 32px rgba(27,94,32,0.13), 0 2px 8px rgba(0,0,0,0.06);
        }

        .success-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #e8f5e9;
            border: 1.5px solid #a5d6a7;
            border-radius: 8px;
            padding: 12px 18px;
            margin-bottom: 24px;
        }
        .success-badge span { font-size: 1.5rem; }
        .success-badge p { color: #2e7d32; font-weight: 600; font-size: 0.97rem; }

        .summary-card h2 {
            font-size: 1.25rem;
            color: #1b5e20;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 2px solid #c8e6c9;
        }

        /* Summary Table */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.93rem;
            margin-bottom: 28px;
        }
        .summary-table td {
            padding: 11px 14px;
            border: 1px solid #ddeedd;
        }
        .summary-table td:first-child {
            background: #f5faf5;
            font-weight: bold;
            color: #2a4a2a;
            width: 42%;
        }
        .summary-table td:last-child { color: #1a2e1a; }
        .summary-table .ref-row td { background: #e8f5e9; font-weight: 600; color: #1b5e20; }

        /* Price Section */
        .price-section { border-top: 2px solid #c8e6c9; padding-top: 20px; }
        .price-section h3 { font-size: 1.05rem; color: #1b5e20; margin-bottom: 14px; }

        .price-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.93rem;
        }
        .price-table td {
            padding: 10px 14px;
            border: 1px solid #ddeedd;
        }
        .price-table td:first-child {
            background: #f5faf5;
            font-weight: bold;
            color: #2a4a2a;
            width: 55%;
        }
        .price-table .discount-row td { color: #e53935; font-weight: 600; }
        .price-table .total-row td {
            background: #1b5e20 !important;
            color: #fff !important;
            font-weight: 700;
            font-size: 1.02rem;
        }
        .price-value { font-weight: 600; color: #2e7d32; }

        /* Back Button */
        .back-btn {
            display: inline-block;
            margin-top: 26px;
            background: #2e7d32;
            color: #fff;
            padding: 12px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.97rem;
            transition: background 0.2s, transform 0.1s;
            box-shadow: 0 4px 12px rgba(46,125,50,0.22);
        }
        .back-btn:hover { background: #1b5e20; transform: translateY(-1px); }

        .footer { text-align: center; margin-top: 30px; font-size: 0.82rem; color: #7a9a7a; }
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
    <h1>&#128203; Booking Summary</h1>
    <p>Review your trip details below</p>
</div>

<?php if (!empty($errors)): ?>
<!-- ── ERROR STATE ── -->
<div class="error-card">
    <h2>&#10006; Please fix the following errors:</h2>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="trip.php" class="go-back">&#8592; Go Back to Booking Form</a>
</div>

<?php else: ?>
<!-- ── SUCCESS STATE ── -->
<div class="summary-card">

    <div class="success-badge">
        <span>&#10003;</span>
        <p>Booking received successfully! Your reference: <strong><?= $booking_ref ?></strong></p>
    </div>

    <h2>&#127968; Trip Booking Details</h2>

    <table class="summary-table">
        <tr>
            <td>Traveller Name</td>
            <td><?= $traveller_name ?></td>
        </tr>
        <tr>
            <td>Email Address</td>
            <td><?= $email ?></td>
        </tr>
        <tr>
            <td>Destination</td>
            <td><?= $destination_display ?></td>
        </tr>
        <tr>
            <td>Departure Date</td>
            <td><?= date('d M Y', strtotime($departure_date)) ?></td>
        </tr>
        <tr>
            <td>Number of Travellers</td>
            <td><?= $num_travellers ?> person(s)</td>
        </tr>
        <tr>
            <td>Trip Type</td>
            <td><?= $trip_type ?></td>
        </tr>
        <tr class="ref-row">
            <td>Booking Reference</td>
            <td><?= $booking_ref ?></td>
        </tr>
        <tr class="ref-row">
            <td>Booked On</td>
            <td><?= $booked_on ?></td>
        </tr>
    </table>

    <!-- Price Calculator -->
    <div class="price-section">
        <h3>&#128176; Price Breakdown</h3>
        <table class="price-table">
            <tr>
                <td>Base Price Per Person</td>
                <td class="price-value">Rs. <?= number_format($base_price) ?></td>
            </tr>
            <tr>
                <td>Number of Travellers</td>
                <td class="price-value"><?= $num_travellers ?></td>
            </tr>
            <tr>
                <td>Subtotal</td>
                <td class="price-value">Rs. <?= number_format($subtotal) ?></td>
            </tr>
            <?php if ($discount > 0): ?>
            <tr class="discount-row">
                <td>Group Discount (<?= $discount_pct ?>% for 5+ travellers)</td>
                <td>- Rs. <?= number_format($discount) ?></td>
            </tr>
            <?php endif; ?>
            <tr class="total-row">
                <td>Total Amount Payable</td>
                <td>Rs. <?= number_format($total) ?></td>
            </tr>
        </table>

        <?php if ($discount > 0): ?>
        <p style="margin-top:12px; font-size:0.88rem; color:#388e3c;">
            &#127881; You saved <strong>Rs. <?= number_format($discount) ?></strong> with the group discount!
        </p>
        <?php endif; ?>
    </div>

    <a href="trip.php" class="back-btn">&#8592; Book Another Trip</a>
</div>
<?php endif; ?>

<div class="footer">
    <p>&copy; 2025 Pakistan Tours &mdash; MidTerm Project | Roll No: 232201040 | Fatima</p>
</div>

</body>
</html>
