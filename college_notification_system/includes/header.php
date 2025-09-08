<?php
if (session_status() == PHP_SESSION_NONE) session_start();
$user = $_SESSION['user'] ?? null;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>College Notification System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body{background:#f4f6fb;}
    .sidebar{min-height:100vh;background:linear-gradient(180deg,#0b3d91,#174ea6);color:white;padding:20px;}
    .sidebar a{color:rgba(255,255,255,0.95);display:block;margin:8px 0;text-decoration:none;}
    .sidebar a:hover{color:#ffd54f;}
    .content{padding:24px;}
    .card-hero{background:white;border-radius:14px;padding:20px;box-shadow:0 6px 20px rgba(20,40,80,0.08);}
    .badge-cat{font-size:0.8rem;padding:6px 8px;border-radius:8px;}
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-2 sidebar">
      <h4 class="mb-3"><i class="fa fa-university"></i> KRUCET</h4>
      <a href="/college_notification_system/index.php"><i class="fa fa-home"></i> Home</a>
      <?php if($user): ?>
        <a href="/college_notification_system/view_notifications.php"><i class="fa fa-bell"></i> Inbox</a>
        <?php if($user['role'] !== 'Student'): ?>
        <a href="/college_notification_system/send_notification.php"><i class="fa fa-paper-plane"></i> Send Notification</a>
        <?php endif; ?>
        <a href="/college_notification_system/outbox.php"><i class="fa fa-paperclip"></i> Outbox</a>
        <a href="/college_notification_system/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
      <?php else: ?>
        <a href="/college_notification_system/login.php"><i class="fa fa-sign-in-alt"></i> Login</a>
        <a href="/college_notification_system/register.php"><i class="fa fa-user-plus"></i> Register</a>
      <?php endif; ?>
      <hr style="border-color: rgba(255,255,255,0.08)">
      <small>Build: Final (with attachments)</small>
    </div>
    <div class="col-10 content">
