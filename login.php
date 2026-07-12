<?php
// ── login.php ── Traveller Login with Session Management ──
session_start();

// If already logged in, redirect to mybookings
if (isset($_SESSION['name'])) {
    header('Location: mybookings.php');
    exit;
}

// Hardcoded accounts
$accounts = [
    ['username' => 'traveler1', 'password' => 'trip123', 'name' => 'Bilal Ahmed'],
    ['username' => 'traveler2', 'password' => 'tour456', 'name' => 'Ayesha Malik'],
];

$error   = '';
$msg     = $_GET['msg'] ?? '';

// Process login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $found    = false;

    foreach ($accounts as $account) {
        if ($account['username'] === $username && $account['password'] === $password) {
            $found = true;
            $_SESSION['name'] = $account['name'];
            session_regenerate_id(true);
            header('Location: mybookings.php');
            exit;
        }
    }

    if (!$found) {
        $error = 'Incorrect username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pakistan Tours</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eaf4ea;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
            color: #1a2e1a;
        }

        .page-header { text-align: center; margin-bottom: 28px; }
        .page-header h1 { font-size: 2rem; color: #1b5e20; font-weight: 700; }
        .page-header p { color: #4a6a4a; margin-top: 6px; font-size: 0.95rem; }

        /* Banners */
        .banner-success {
            max-width: 420px;
            width: 100%;
            background: #e8f5e9;
            border: 1.5px solid #66bb6a;
            color: #2e7d32;
            border-radius: 8px;
            padding: 12px 18px;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 18px;
            text-align: center;
        }
        .banner-error {
            max-width: 420px;
            width: 100%;
            background: #ffebee;
            border: 1.5px solid #ef9a9a;
            color: #c62828;
            border-radius: 8px;
            padding: 12px 18px;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 18px;
            text-align: center;
        }

        /* Login Card */
        .login-card {
            max-width: 420px;
            width: 100%;
            background: #fff;
            border-radius: 14px;
            padding: 36px 38px;
            box-shadow: 0 8px 32px rgba(27,94,32,0.13), 0 2px 8px rgba(0,0,0,0.06);
        }
        .login-card h2 {
            font-size: 1.25rem;
            color: #1b5e20;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid #c8e6c9;
        }

        .form-group { margin-bottom: 18px; }
        label {
            display: block;
            font-weight: bold;
            font-size: 0.88rem;
            color: #2a4a2a;
            margin-bottom: 6px;
        }
        input[type="text"], input[type="password"] {
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
        input:focus {
            border-color: #2e7d32;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(46,125,50,0.12);
        }

        input[type="submit"] {
            width: 100%;
            background: #2e7d32;
            color: #fff;
            border: none;
            padding: 13px 0;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 7px;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s, transform 0.1s;
            box-shadow: 0 4px 12px rgba(46,125,50,0.25);
        }
        input[type="submit"]:hover {
            background: #1b5e20;
            transform: translateY(-1px);
        }

        .hint {
            margin-top: 20px;
            padding: 12px 14px;
            background: #f5faf5;
            border-radius: 7px;
            font-size: 0.83rem;
            color: #4a6a4a;
            border: 1px solid #c8e6c9;
        }
        .hint strong { color: #2e7d32; }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #2e7d32;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 600;
        }
        .back-link:hover { text-decoration: underline; }

        .footer { text-align: center; margin-top: 30px; font-size: 0.82rem; color: #7a9a7a; }
    </style>
</head>
<body>

<div class="page-header">
    <h1>&#9992; Pakistan Tours</h1>
    <p>Traveller Login Portal</p>
</div>

<!-- Logged out success banner -->
<?php if ($msg === 'bye'): ?>
    <div class="banner-success">&#10003; Logged out successfully. See you again!</div>
<?php endif; ?>

<!-- Error banner -->
<?php if ($error !== ''): ?>
    <div class="banner-error">&#10006; <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<!-- Login Form -->
<div class="login-card">
    <h2>&#128273; Traveller Login</h2>

    <form action="login.php" method="POST">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   placeholder="Enter username" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   placeholder="Enter password" required>
        </div>

        <input type="submit" value="Login &#8594;">
    </form>

    <!-- Demo credentials hint -->
    <div class="hint">
        <strong>Demo Accounts:</strong><br>
        traveler1 / trip123 (Bilal Ahmed)<br>
        traveler2 / tour456 (Ayesha Malik)
    </div>

    <a href="trip.php" class="back-link">&#8592; Back to Booking Form</a>
</div>

<div class="footer">
    <p>&copy; 2025 Pakistan Tours &mdash; MidTerm Project | Roll No: 232201040 | Fatima</p>
</div>

</body>
</html>
