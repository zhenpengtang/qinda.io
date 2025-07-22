<?php
$pageTitle = '首页';
require_once 'header.php';
require_once 'db.php'; // db.php 中已经定义了 $pdo 和 $config，无需再手动连接数据库

// 获取访问次数最多的10条记录
$stmt = $pdo->query("SELECT chinese, pinyin, count, last_visited FROM link ORDER BY count DESC LIMIT 10");
$topLinks = $stmt->fetchAll();

// 获取最近访问的10条记录
$stmt2 = $pdo->query("SELECT chinese, pinyin, count, last_visited FROM link ORDER BY last_visited DESC LIMIT 10");
$recentLinks = $stmt2->fetchAll();
?>

<h2>📈 最常访问</h2>
<ul class="list-group mb-4">
  <?php foreach ($topLinks as $row): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <div>
        <strong><?= htmlspecialchars($row['chinese']) ?></strong><br>
        <small><a href="jump.php?name=<?= urlencode($row['chinese']) ?>" target="_blank">
          https://yw.ip2.one/<?= htmlspecialchars($row['pinyin']) ?>
        </a></small><br>
        <small class="text-muted">最近访问：<?= htmlspecialchars($row['last_visited']) ?></small>
      </div>
      <span class="badge bg-primary rounded-pill"><?= $row['count'] ?> 次</span>
    </li>
  <?php endforeach; ?>
</ul>

<h2>🕒 最近访问</h2>
<ul class="list-group">
  <?php foreach ($recentLinks as $row): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <div>
        <strong><?= htmlspecialchars($row['chinese']) ?></strong><br>
        <small><a href="jump.php?name=<?= urlencode($row['chinese']) ?>" target="_blank">
          https://yw.ip2.one/<?= htmlspecialchars($row['pinyin']) ?>
        </a></small><br>
        <small class="text-muted">最近访问：<?= htmlspecialchars($row['last_visited']) ?></small>
      </div>
      <span class="badge bg-secondary rounded-pill"><?= $row['count'] ?> 次</span>
    </li>
  <?php endforeach; ?>
</ul>

<?php require_once 'footer.php'; ?>
