<?php
// 引入数据库连接（统一管理）
require_once __DIR__ . '/db.php';

// 获取最近访问的10条记录
$stmt = $pdo->query("SELECT chinese, pinyin, count, last_visited FROM link ORDER BY last_visited DESC LIMIT 10");
$recentLinks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <title>搜索 + 扫码</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body>
<div class="container mt-5">
  <form id="searchForm" method="GET" action="search.php">
    <div class="input-group">
      <input type="text" id="query" name="query" class="form-control" placeholder="请输入关键词..." required>
      <button class="btn btn-primary" type="submit">搜索</button>
      <button class="btn btn-success" type="button" onclick="startScan()">扫码</button>
    </div>
  </form>

  <div id="scanner" class="mt-3" style="width:100%; max-width:400px; display: none;"></div>

  <div class="mt-5">
    <h5>📌 最近访问的短链接：</h5>
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
          <span class="badge bg-primary rounded-pill"><?= $row['count'] ?> 次</span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<script>
  function startScan() {
    const scanner = document.getElementById('scanner');
    scanner.style.display = 'block';

    const html5QrCode = new Html5Qrcode("scanner");
    html5QrCode.start(
      { facingMode: "environment" },
      { fps: 10, qrbox: 250 },
      qrCodeMessage => {
        document.getElementById("query").value = qrCodeMessage;
        html5QrCode.stop();
        scanner.style.display = 'none';
        document.getElementById("searchForm").submit();
      },
      errorMessage => {}
    ).catch(err => {
      alert("摄像头启动失败: " + err);
    });
  }
</script>
</body>
</html>
