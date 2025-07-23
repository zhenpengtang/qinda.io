<?php
// header.php
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : '短链接系统' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">topic.ip2.one索引系统</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">最近访问</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="create.php">创建主题</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="top.php">最常访问</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="d-flex justify-content-center mb-4">
    <form class="d-flex" style="width: 50%;" action="search.php" method="get">
      <input class="form-control me-2" type="search" name="q" placeholder="搜索中文或拼音" aria-label="Search">
    </form>
  </div>
  <div class="container">
