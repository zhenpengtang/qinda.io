<?php
require_once __DIR__ . '/db.php';  // 使用统一的数据库连接

require 'vendor/autoload.php';
use Overtrue\Pinyin\Pinyin;

$chinese = '';
$pinyinResult = '';
$link = '';
$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chinese = trim($_POST['chinese'] ?? '');
    $pinyinResult = trim($_POST['pinyin'] ?? '');

    if (empty($chinese) || empty($pinyinResult)) {
        $error = '请输入完整内容。';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO link (chinese, pinyin, count, last_visited) VALUES (?, ?, 0, NOW())");
            $stmt->execute([$chinese, $pinyinResult]);
            $success = true;
            // 显示链接是拼音路径
            $link = "https://topic.ip2.one/" . $pinyinResult;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "❌ 拼音短链已存在，请更换中文内容或拼音。";
            } else {
                $error = "数据库错误：" . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <title>创建topic.ip2.one索引</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script>
        async function updatePinyin() {
            const chinese = document.getElementById('chinese').value;
            if (!chinese.trim()) {
                document.getElementById('pinyin').value = '';
                document.getElementById('linkPreview').textContent = '';
                return;
            }
            const response = await fetch('pinyin_api.php?text=' + encodeURIComponent(chinese));
            const pinyin = await response.text();
            if (pinyin && chinese) {
                document.getElementById('pinyin').value = pinyin;
                // 预览显示拼音路径，跳转链接传中文
                document.getElementById('linkPreview').innerHTML =
                    '<a href="jump.php?name=' + encodeURIComponent(chinese) + '" target="_blank">' +
                    'https://topic.ip2.one/' + pinyin +
                    '</a>';
            } else {
                document.getElementById('linkPreview').innerHTML = '';
            }
        }
    </script>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 480px;">
        <h2 class="mb-4 text-center">创建topic.ip2.one中文索引</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success">
                ✅ 创建成功！索引：
                <a href="jump.php?name=<?= urlencode($chinese) ?>" target="_blank"><?= htmlspecialchars($link) ?></a>
            </div>
        <?php endif; ?>

        <form method="post" oninput="updatePinyin()">
            <div class="mb-3">
                <label for="chinese" class="form-label">中文</label>
                <input type="text" id="chinese" name="chinese" class="form-control" value="<?= htmlspecialchars($chinese) ?>" required />
            </div>

            <div class="mb-3">
                <label for="pinyin" class="form-label">拼音（自动生成）</label>
                <input type="text" id="pinyin" name="pinyin" class="form-control" value="<?= htmlspecialchars($pinyinResult) ?>" readonly required />
            </div>

            <div class="mb-3">
                <label class="form-label">短链预览</label>
                <div id="linkPreview" class="text-primary fw-bold" style="word-break: break-all;">
                    <?php if ($pinyinResult): ?>
                        <a href="jump.php?name=<?= urlencode($chinese) ?>" target="_blank">
                            <?= 'https://topic.ip2.one/' . htmlspecialchars($pinyinResult) ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">提交</button>
        </form>
    </div>
</div>
</body>
</html>
