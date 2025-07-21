<?php
require_once __DIR__ . '/vendor/autoload.php';
use Overtrue\Pinyin\Pinyin;

$text = $_GET['text'] ?? '';
$pinyin = (new Pinyin())->permalink($text, '-');
echo $pinyin;
