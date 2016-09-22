<?php

use yii\helpers\Url;

$url = trim($_SERVER['REQUEST_URI'], '/');
$pos1 = stripos($url, '?') ? stripos($url, '?') : 0;
$pos2 = stripos($url, '#') ? stripos($url, '#') : 0;
$pos = (min($pos1, $pos2) == 0) ? max($pos1, $pos2) : min($pos1, $pos2);
$new_url = ($pos == 0) ? $url : substr($url, 0, $pos);
$arr_url = explode('/', $new_url);
$nav_str = (count($arr_url) > 1) ? $arr_url['1'] : '';
?>
<article class="fana clearfix">
    <!-- class="cup" -->
    <a href="<?php echo Url::to('/' . $pinyin_initial . '/'); ?>" <?php echo ($nav_str == '') ? 'class="cup"' : ''; ?>>综合</a>
    <a href="<?php echo Url::to('/' . $pinyin_initial . '/zixun/'); ?>" <?php echo ($nav_str == 'zixun') ? 'class="cup"' : ''; ?>>问诊</a>
    <a href="<?php echo Url::to('/' . $pinyin_initial . '/yy/'); ?>" <?php echo ($nav_str == 'yy') ? 'class="cup"' : ''; ?>>找医院</a>
    <a href="<?php echo Url::to('/' . $pinyin_initial . '/ys/'); ?>" <?php echo ($nav_str == 'ys') ? 'class="cup"' : ''; ?>>找医生</a>
    <a href="<?php echo Url::to('/' . $pinyin_initial . '/yaopin/'); ?>" <?php echo ($nav_str == 'yaopin') ? 'class="cup"' : ''; ?>>找药品</a>
    <a href="<?php echo Url::to('/' . $pinyin_initial . '/article_list.shtml'); ?>" <?php echo ($nav_str == 'article_list.shtml') ? 'class="cup"' : ''; ?>>文章</a>
</article>