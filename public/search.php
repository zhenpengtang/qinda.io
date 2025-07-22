<?php
$pageTitle = '搜索结果';
require_once 'header.php';
require_once 'db.php';

$keyword = $_GET['q'] ?? '';
$results = [];

if ($keyword) {
    $stmt = $pdo->prepare("SELECT chinese, pinyin, count, last_visited FROM link WHERE chinese LIKE :keyword OR pinyin LIKE :keyword");
    $stmt->execute(['keyword' => '%' . $keyword . '%']);
    $results = $stmt->fetchAll();
}
?>

<div class="container">
  <h2>🔍 搜索结果：<?= htmlspecialchars($keyword) ?></h2>
  
  <?php if ($results): ?>
    <ul class="list-group mb-4">
      <?php foreach ($results as $row): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong><?= htmlspecialchars($row['chinese']) ?></strong><br>
            <small><a href="jump.php?name=<?= urlencode($row['chinese']) ?>" target="_blank">
              https://yw.ip2.one/<?= htmlspecialchars($row['pinyin']) ?>
            </a></small><br>
            <small class="text-muted">最近访问：<?= htmlspecialchars($row['last_visited']) ?></small>
          </div>
          <span class="badge bg-info rounded-pill"><?= $row['count'] ?> 次</span>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-muted">没有找到匹配的记录。</p>
  <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>
