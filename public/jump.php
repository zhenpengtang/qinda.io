<?php
// jump.php

if (!isset($_GET['name']) || empty($_GET['name'])) {
    exit('参数缺失');
}

$name = $_GET['name'];

require_once 'db.php';

// 查询拼音
$stmt = $pdo->prepare("SELECT pinyin, count FROM link WHERE chinese = ? LIMIT 1");
$stmt->execute([$name]);
$row = $stmt->fetch();

if (!$row) {
    exit('未找到对应记录');
}

// 更新访问次数
$update = $pdo->prepare("UPDATE link SET count = count + 1, last_visited = NOW() WHERE chinese = ?");
$update->execute([$name]);

// 跳转
$pinyin = $row['pinyin'];
header("Location: https://yw.ip2.one/{$pinyin}");
exit;
