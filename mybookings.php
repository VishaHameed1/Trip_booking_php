<?php
// ── mybookings.php ── Session-Protected Bookings Dashboard ──
session_start();

// Redirect if not logged in
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit;
}

// Increment visit counter
if (!isset($_SESSION['visits'])) {
    $_SESSION['visits'] = 0;
}
$_SESSION['visits']++;

$name   = $_SESSION['name'];
$visits = $_SESSION['visits'];

// Dummy bookings data
$bookings = [
    ['ref' => 'TR1714000001', 'destination' => 'Lahore',    'date' => '2025-06-10', 'travelers' => 2, 'total' => 10000],
    ['ref' => 'TR1714000002', 'destination' => 'Murree',    'date' => '2025-07-15', 'travelers' => 5, 'total' => 31500],
    ['ref' => 'TR1714000003', 'destination' => 'Swat',      'date' => '2025-08-01', 'travelers' => 3, 'total' => 27000],
    ['ref' => 'TR1714000004', 'destination' => 'Islamabad', 'date' => '2025-09-20', 'travelers' => 1, 'total' => 6000],
    ['ref' => 'TR1714000005', 'destination' => 'Karachi',   'date' => '2025-10-05', 'travelers' => 6, 'total' => 43200],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings | Pakistan Tours</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eaf4ea;
            min-height: 100vh;
            padding: 0 0 60px;
            color: #1a2e1a;
        }

        /* ── Top Bar ── */
        .topbar {
            background: #1b5e20;
            padding: 14px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar .brand { color: #fff; font-size: 1.1rem; font-weight: 700; }
        .topbar .nav-links a {
            color: #a5d6a7;
            text-decoration: none;
            margin-left: 18px;
            font-size: 0.92rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        .topbar .nav-links a:hover { color: #fff; }
        .topbar .logout-btn {
            background: #c62828;
            color: #fff !important;
            padding: 7px 16px;
            border-radius: 6px;
            font-weight: 700 !important;
            transition: background 0.2s !important;
        }
        .topbar .logout-btn:hover { background: #b71c1c !important; }

        .page-wrap { max-width: 800px; margin: 0 auto; padding: 36px 16px; }

        /* ── Welcome Banner ── */
        .welcome-banner {
            background: #fff;
            border-radius: 12px;
            padding: 24px 28px;
            margin-bottom: 24px;
            box-shadow: 0 4px 18px rgba(27,94,32,0.10);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .welcome-banner h2 {
            font-size: 1.3rem;
            color: #1b5e20;
            font-weight: 700;
        }
        .welcome-banner h2 span { color: #388e3c; }
        .visit-badge {
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            color: #2e7d32;
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 0.88rem;
            font-weight: 600;
        }

        /* ── Stats Row ── */
        .stats-row {
            display: flex;
            gap: 14px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        .stat-card {
            flex: 1;
            min-width: 140px;
            background: #fff;
            border-radius: 10px;
            padding: 18px 20px;
            box-shadow: 0 3px 12px rgba(27,94,32,0.08);
            text-align: center;
        }
        .stat-card .stat-num { font-size: 1.8rem; font-weight: 700; color: #2e7d32; }
        .stat-card .stat-label { font-size: 0.82rem; color: #5a7a5a; margin-top: 4px; }

        /* ── Bookings Table ── */
        .section-title {
            font-size: 1.1rem;
            color: #1b5e20;
            font-weight: 700;
            margin-bottom: 14px;
        }
        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(27,94,32,0.10);
            font-size: 0.91rem;
        }
        .bookings-table thead th {
            background: #2e7d32;
            color: #fff;
            padding: 13px 16px;
            text-align: left;
            font-size: 0.84rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: 1px solid #256427;
        }
        .bookings-table tbody td {
            padding: 11px 16px;
            border: 1px solid #ddeedd;
            color: #1a2e1a;
        }
        .bookings-table tbody tr:nth-child(even) td { background: #f5faf5; }
        .bookings-table tbody tr:hover td { background: #eaf5ea; }
        .ref-code { font-family: monospace; font-size: 0.85rem; color: #388e3c; font-weight: 600; }
        .price-col { font-weight: 700; color: #2e7d32; }
        .dest-badge {
            display: inline-block;
            background: #e8f5e9;
            color: #2e7d32;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.83rem;
            font-weight: 600;
        }

        /* ── Action Buttons ── */
        .action-row {
            margin-top: 24px;
            display: flex;
            gap: 12px;
        }
        .btn-primary {
            background: #2e7d32;
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            transition: background 0.2s;
            box-shadow: 0 4px 12px rgba(46,125,50,0.22);
        }
        .btn-primary:hover { background: #1b5e20; }
        .btn-danger {
            background: #c62828;
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            transition: background 0.2s;
        }
        .btn-danger:hover { background: #b71c1c; }

        .footer { text-align: center; margin-top: 36px; font-size: 0.82rem; color: #7a9a7a; }
    </style>
</head>
<body>

<!-- Top Navigation -->
<div class="topbar">
    <span class="brand">&#9992; Pakistan Tours</span>
    <div class="nav-links">
        <a href="trip.php">New Booking</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="page-wrap">

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <h2>&#128075; Welcome back, <span><?= htmlspecialchars($name) ?></span>!</h2>
        <div class="visit-badge">&#128065; Visited <?= $visits ?> time(s) this session</div>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-num"><?= count($bookings) ?></div>
            <div class="stat-label">Total Bookings</div>
        </div>
        <div class="stat-card">
            <div class="stat-num"><?= array_sum(array_column($bookings, 'travelers')) ?></div>
            <div class="stat-label">Total Travellers</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">Rs. <?= number_format(array_sum(array_column($bookings, 'total'))) ?></div>
            <div class="stat-label">Total Spent</div>
        </div>
        <div class="stat-card">
            <div class="stat-num"><?= $visits ?></div>
            <div class="stat-label">Session Visits</div>
        </div>
    </div>

    <!-- Bookings Table -->
    <p class="section-title">&#128203; My Trip Bookings</p>
    <table class="bookings-table">
        <thead>
            <tr>
                <th>Ref No.</th>
                <th>Destination</th>
                <th>Date</th>
                <th>Travellers</th>
                <th>Total (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $b): ?>
            <tr>
                <td class="ref-code"><?= htmlspecialchars($b['ref']) ?></td>
                <td><span class="dest-badge"><?= htmlspecialchars($b['destination']) ?></span></td>
                <td><?= date('d M Y', strtotime($b['date'])) ?></td>
                <td><?= $b['travelers'] ?></td>
                <td class="price-col">Rs. <?= number_format($b['total']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Action Buttons -->
    <div class="action-row">
        <a href="trip.php" class="btn-primary">&#43; New Booking</a>
        <a href="logout.php" class="btn-danger">&#128274; Logout</a>
    </div>

</div>

<div class="footer">
    <p>&copy; 2025 Pakistan Tours &mdash; MidTerm Project | Roll No: 232201040 | Fatima</p>
</div>

</body>
</html>
