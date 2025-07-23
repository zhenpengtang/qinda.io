<?php
$pageTitle = '最近访问';
require_once 'header.php';
require_once 'db.php';

$stmt = $pdo->query("SELECT chinese, pinyin, count, last_visited FROM link ORDER BY last_visited DESC LIMIT 10");
$recentLinks = $stmt->fetchAll();
?>

<h2>🕒 最近访问</h2>
<ul class="list-group">
  <?php foreach ($recentLinks as $row): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <div>
        <strong><?= htmlspecialchars($row['chinese']) ?></strong><br>
        <small><a href="jump.php?name=<?= urlencode($row['chinese']) ?>" target="_blank">
          https://topic.ip2.one/<?= htmlspecialchars($row['pinyin']) ?>
        </a></small><br>
        <small class="text-muted">最近访问：<?= htmlspecialchars($row['last_visited']) ?></small>
      </div>
      <span class="badge bg-secondary rounded-pill"><?= $row['count'] ?> 次</span>
    </li>
  <?php endforeach; ?>
</ul>

<?php require_once 'footer.php'; ?>
