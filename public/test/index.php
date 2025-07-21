<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <title>搜索+扫码</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body>
<div class="container mt-5">
  <form id="searchForm" method="GET" action="search.php">
    <div class="input-group">
      <input type="text" id="query" name="query" class="form-control" placeholder="请输入关键词..." required>
      <button class="btn btn-primary" type="submit">搜索主题</button>
      <button class="btn btn-success" type="button" onclick="startScan()">扫码</button>
    </div>
  </form>

  <div id="scanner" class="mt-3" style="width:100%; max-width:400px; display: none;"></div>
</div>

<script>
  function startScan() {
    const scanner = document.getElementById('scanner');
    scanner.style.display = 'block';

    const html5QrCode = new Html5Qrcode("scanner");
    html5QrCode.start(
      { facingMode: "environment" },
      {
        fps: 10,
        qrbox: 250
      },
      qrCodeMessage => {
        document.getElementById("query").value = qrCodeMessage;
        html5QrCode.stop();
        scanner.style.display = 'none';
        document.getElementById("searchForm").submit();
      },
      errorMessage => {}
    ).catch(err => {
      alert("摄像头无法启动: " + err);
    });
  }
</script>
</body>
</html>
