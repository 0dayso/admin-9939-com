<?php
use yii\helpers\Url;

$url = $_SERVER['REQUEST_URI'];
$uri = trim($_SERVER['REQUEST_URI'], '/');
if (stripos($uri, "?") !== false){
    $uri_arr = explode('?', $uri);
    $url = $uri_arr[0];
}
$str = str_replace([$disease['pinyin_initial'], '/'], '', $url);
//左翼
$leftarr = ['', 'jianjie', 'zz', 'by', 'yf', 'lcjc', 'jb', 'zl', 'yshl', 'bfz', 'jzzn'];
$left_wing = in_array($str, $leftarr) ? $str : 'hidden';
//疾病导航
$disknowledge = ['jianjie', 'zz', 'by', 'yf', 'lcjc', 'jb', 'zl', 'yshl', 'bfz', 'jzzn'];
$navstr = in_array($str, $disknowledge) ? 'jianjie' : $str;
$navstr = (strpos($navstr, 'article_list') !== false) ? 'article_list' : $navstr;

//$navstr = ($navstr != 'article_list.shtml') ? $navstr . '/' : $navstr;
$navarr = ['jianjie', 'zixun', 'yy', 'ys', 'yaopin', 'article_list'];
$position = in_array($navstr, $navarr) ? $navstr : '';
?>

<!--左侧右侧-->
<?php
if ($left_wing != 'hidden') {
    ?>
    <div class="absbar">
        <ul>
            <?php
            $arr = [
                0 => ['jianjie', '简&nbsp;介'],
                1 => ['zz', '症&nbsp;状'],
                2 => ['by', '病&nbsp;因'],
                3 => ['yf', '预&nbsp;防'],
                4 => ['lcjc', '检&nbsp;查'],
                5 => ['jb', '鉴&nbsp;别'],
                6 => ['zl', '治&nbsp;疗'],
                7 => ['yshl', '护&nbsp;理'],
                8 => ['bfz', '并发症'],
                //9 => ['zc', '自&nbsp;测'],
                10 => ['tuji', '图&nbsp;集'],
            ];

            foreach ($arr as $k => $v) {
                $cust = (isset($left_wing) && $left_wing == $v['0']) ? 'cust' : '';
                ?>
                <li><a href="<?php echo Url::toRoute('/' . $disease['pinyin_initial'] . '/' . $v['0']) . '/'; ?>" target="_self" class="<?php echo $cust; ?>"><?php echo $v['1']; ?></a></li>

                <?php
            }
            ?>
        </ul>
    </div>
    <SCRIPT language=JavaScript type=text/javascript src="/js/retop.js"></SCRIPT>
    <?php
}
?>

<!--右侧联-->
<?php echo $this->render('/include/rightFloat'); ?>
<!--右侧联-->

<div class="content bocon">

    <!--面包屑-->
    <div class="art_s"> 您所在的位置：
        <a href="http://www.9939.com/" target="_blank">久久健康网</a>>
        <a href="<?php echo Url::home(true); ?>"  target="_blank">疾病百科</a>>
        <a href="<?php echo Url::to('/jbzz/'); ?>">疾病症状</a>>
        <a><b><?php echo $disease['name']; ?></b></a>
    </div>
    <h1 class="dicoc"><?php echo $disease['name']; ?>
        <span>
            <?php
            if (isset($disease['alias']) && !empty($disease['alias'])) {
                ?>
                （<?php echo $disease['alias']; ?>）
                <?php
            }
            ?>
        </span>
        <a>疾病</a>
    </h1>
    <!--面包屑-->

    <div class="diack" id="float">
        <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/'); ?>" class="<?php echo ($position == '') ? 'indexahover' : ''; ?>">疾病首页</a>
        <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/jianjie/'); ?>" class="pro_01 <?php echo ($position == 'jianjie') ? ' pro_01c indexahover' : ''; ?>"><span></span>疾病知识</a>
        <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/zixun/'); ?>" target="_blank" class="pro_02 <?php echo ($position == 'zixun') ? ' pro_02c indexahover' : ''; ?>"><span></span>在线问诊</a>
        <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/yy/'); ?>" target="_blank" class="pro_03 <?php echo ($position == 'yy') ? ' pro_03c indexahover' : ''; ?>"><span></span>找医院</a>
        <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/ys/'); ?>" target="_blank" class="pro_06 <?php echo ($position == 'ys') ? ' pro_06c indexahover' : ''; ?>"><span></span>找医生</a>
        <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/yaopin/'); ?>" target="_blank" class="pro_04 <?php echo ($position == 'yaopin') ? ' pro_04c indexahover' : ''; ?>"><span></span>找药品</a>
        <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/article_list.shtml'); ?>" target="_blank" class="pro_05 <?php echo ($position == 'article_list') ? ' pro_05c indexahover' : ''; ?>"><span></span>文章解读</a>
    </div>
</div>