<?php
include 'config/db.php'; include 'includes/header.php';
if(!isset($_SESSION['user'])){ header('Location: login.php'); exit; }
$user = $_SESSION['user'];
$stmt = $conn->prepare("SELECT * FROM notifications WHERE sender_id = ? ORDER BY created_at DESC");
$stmt->bind_param('i',$user['id']); $stmt->execute(); $res = $stmt->get_result();
?>
<div class="card p-4">
  <h3>Outbox</h3>
  <?php while($r = $res->fetch_assoc()): ?>
    <div class="border p-3 mb-3">
      <h5><?=htmlspecialchars($r['title'])?> &nbsp;<span class="badge bg-info"><?=htmlspecialchars($r['receiver_role'])?></span></h5>
      <small><?=htmlspecialchars($r['created_at'])?></small>
      <p><?=nl2br(htmlspecialchars($r['message']))?></p>
      <?php if($r['attachment']): ?>
        <a class="btn btn-sm btn-outline-primary" href="/iit_notification_system_final/download.php?f=<?=urlencode($r['attachment'])?>">Download Attachment</a>
      <?php endif; ?>
    </div>
  <?php endwhile; ?>
</div>
<?php include 'includes/footer.php'; ?>