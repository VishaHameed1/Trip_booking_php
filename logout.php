<?php
// ── logout.php ── Session Destruction & Redirect ──
session_start();
session_unset();
session_destroy();
header('Location: login.php?msg=bye');
exit;
?>
