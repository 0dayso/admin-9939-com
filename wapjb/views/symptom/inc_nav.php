<?php

use yii\helpers\Url;

$_url = trim($_SERVER['REQUEST_URI'], '/');
$url = str_replace('zhengzhuang/', '', $_url);
$pos1 = stripos($url, '?') ? stripos($url, '?') : 0;
$pos2 = stripos($url, '#') ? stripos($url, '#') : 0;
$pos = (min($pos1, $pos2) == 0) ? max($pos1, $pos2) : min($pos1, $pos2);
$new_url = ($pos == 0) ? $url : substr($url, 0, $pos);
$arr_url = explode('/', $new_url);
$nav_str = (count($arr_url) > 1) ? $arr_url['1'] : '';
$zzzs = ['jianjie', 'zzqy', 'cyjc', 'jdzd', 'yshl'];
$nav_str = in_array($nav_str, $zzzs) ? 'zzzs' : $nav_str;
?>
<article class="fana sypak clearfix">
    <!-- class="cup" -->
    <a href="<?php echo Url::to('/zhengzhuang/' . $pinyin_initial . '/'); ?>" <?php echo ($nav_str == '') ? 'class="cup"' : ''; ?>>综合</a>
    <a href="<?php echo Url::to('/zhengzhuang/' . $pinyin_initial . '/jianjie/'); ?>" <?php echo ($nav_str == 'zzzs') ? 'class="cup"' : ''; ?>>症状知识</a>
    <a href="<?php echo Url::to('/zhengzhuang/' . $pinyin_initial . '/zixun/'); ?>" <?php echo ($nav_str == 'zixun') ? 'class="cup"' : ''; ?>>在线问诊</a>
    <a href="<?php echo Url::to('/zhengzhuang/' . $pinyin_initial . '/yiyao/'); ?>" <?php echo ($nav_str == 'yiyao') ? 'class="cup"' : ''; ?>>找药品</a>
    <a href="<?php echo Url::to('/zhengzhuang/' . $pinyin_initial . '/article_list.shtml'); ?>" <?php echo ($nav_str == 'article_list.shtml') ? 'class="cup"' : ''; ?>>文章解读</a>
</article>