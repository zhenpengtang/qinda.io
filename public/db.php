<?php
// db.php
$host = '172.93.189.170';
$db   = 'qinda_ip2_one';     // ← 改成你的数据库名
$user = 'qinda_ip2_one';           // ← 改成你的用户名
$pass = 'LFBGjLtsLPEyFN8C';       // ← 改成你的密码
$charset = 'utf8mb4';


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options); // ← 关键：这里会定义 $pdo
} catch (\PDOException $e) {
  exit('数据库连接失败: ' . $e->getMessage());
}
