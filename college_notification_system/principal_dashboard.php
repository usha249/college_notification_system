<?php
include 'config/db.php';
include 'includes/header.php';
$user = $_SESSION['user'] ?? null;
if(!$user){ header('Location: login.php'); exit; }
?>
<div class="card p-4">
<h2>Principal Dashboard</h2>
<p>Welcome, <?=htmlspecialchars($user['name'])?> (<?=htmlspecialchars($user['role'])?>)</p>
<p>This is the role-based dashboard with stats, inbox, outbox, and attachments.</p>
</div>
<?php include 'includes/footer.php'; ?>
