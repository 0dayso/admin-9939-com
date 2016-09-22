<?php 
    use yii\helpers\Url;
?>
<h2>推荐专家</h2>
<ul class="recom">
    <?php
    if (isset($doctors) && !empty($doctors)) {
        foreach ($doctors as $k => $v) {
            ?>
            <li>
                <h3><?php echo $v['truename'] ? : $v['nickname']; ?><span><?php //echo $v['zhicheng']; ?></span></h3>
                <p><?php echo $v['doc_keshi']; ?></p>
                <p>擅长：<?php echo $v['best_dis'] ? : '暂无'; ?></p>
                <a class="inq_01" href="<?php echo Url::to('@wapask/ask/doctor/' . $v['uid'], true) ?>">咨询</a>
            </li>
            <?php
        }
    }
    ?>
</ul>
<?php
if (isset($diseasePinYin_initial) && !empty($diseasePinYin_initial)) {
    ?>
    <a href="<?php echo Url::to('/' . $pinyin_initial . '/zixun/', true) ?>" class="fimor">点击查看更多<span>></span></a>
    <?php
}
?>

