<?php
require_once 'db.php';

$keyword = $_GET['query'] ?? '';
$results = [];

if (!empty($keyword)) {
    $stmt = $pdo->prepare("SELECT * FROM link WHERE chinese LIKE ? ORDER BY count DESC");
    $stmt->execute(["%$keyword%"]);
    $results = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>搜索中文短链</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="card p-4 shadow-sm">
        <h2 class="mb-4">🔍 搜索中文短链</h2>
        <form method="get" class="mb-3">
            <div class="input-group">
                <input type="text" name="query" value="<?= htmlspecialchars($keyword) ?>" class="form-control" placeholder="请输入中文关键字">
                <button class="btn btn-primary" type="submit">搜索</button>
            </div>
        </form>

        <?php if ($keyword): ?>
            <h5 class="mt-3">🔗 搜索结果：</h5>
            <?php if (empty($results)): ?>
                <div class="text-muted">未找到与 "<strong><?= htmlspecialchars($keyword) ?></strong>" 相关的短链。</div>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($results as $row): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="jump.php?name=<?= urlencode($row['chinese']) ?>" target="_blank">
                                <?= htmlspecialchars($row['chinese']) ?>
                                <small class="text-muted">(<?= htmlspecialchars($row['pinyin']) ?>)</small>
                            </a>
                            <span class="badge bg-secondary rounded-pill"><?= $row['count'] ?> 次访问</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
