<?php
include 'config/db.php'; include 'includes/header.php';
if(!isset($_SESSION['user'])){ header('Location: login.php'); exit; }
$user = $_SESSION['user'];
$role = $user['role']; $college = $user['college_type'] ?? 'All'; $branch = $user['branch'] ?? 'All'; $year = $user['year'] ?? 'All';

$stmt = $conn->prepare("SELECT n.*, u.name sender_name FROM notifications n LEFT JOIN users u ON u.id = n.sender_id WHERE (n.receiver_role = 'All' OR n.receiver_role = ?) AND (n.receiver_college = 'All' OR n.receiver_college = ?) AND (n.receiver_branch = 'All' OR n.receiver_branch = ?) AND (n.receiver_year = 'All' OR n.receiver_year = ?) ORDER BY n.created_at DESC");
$stmt->bind_param('ssss',$role,$college,$branch,$year);
$stmt->execute(); $res = $stmt->get_result();
?>
<div class="card p-4">
  <h3>Inbox</h3>
  <?php while($r = $res->fetch_assoc()): ?>
    <div class="border p-3 mb-3">
      <div class="d-flex justify-content-between">
        <div>
          <h5><?=htmlspecialchars($r['title'])?> <span class="badge bg-secondary badge-cat"><?=htmlspecialchars($r['category'])?></span></h5>
          <small>From: <?=htmlspecialchars($r['sender_name']?:'System')?> | <?=htmlspecialchars($r['created_at'])?></small>
        </div>
        <div>
          <?php if($r['attachment']): ?>
            <a class="btn btn-sm btn-outline-primary" href="/college_notification_system/download.php?f=<?=urlencode($r['attachment'])?>"><i class="fa fa-download"></i> Attachment</a>
          <?php endif; ?>
        </div>
      </div>
      <p class="mt-2"><?=nl2br(htmlspecialchars($r['message']))?></p>
    </div>
  <?php endwhile; ?>
</div>
<?php include 'includes/footer.php'; ?>