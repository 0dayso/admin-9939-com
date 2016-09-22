<?php

use yii\helpers\Url;
?>
<?php
$this->title = "疾病症状综合查询_疾病百科_久久健康网";
?>
<article class="head"><a href=""></a><span>疾病百科</span><a href="/jbzz/" class="setn"></a><a class="clna"></a></article>
<?php
echo $this->render("/include/navigation");
echo $this->render("/include/search");
?>
<h2>常见疾病</h2>

<article class="clsa regul dsia">
    <?php
    foreach ($commonDisease as $k2 => $disease) {
        ?>
        <a href="/<?php echo $disease['pinyin_initial']; ?>/"><?php echo $disease['name']; ?></a>
        <?php
    }
    ?>
</article>

<div class="thre"></div>
<h2><a href="/chaxun/renqun/">更多<span>></span></a>按人群查找</h2>
<article class="clsa regul dsia">
    <a href="/chaxun/renqun/2/" >男性</a>
    <a href="/chaxun/renqun/3/" >女性</a>
    <a href="/chaxun/renqun/4/" >儿童</a>
    <a href="/chaxun/renqun/5/" >老人</a>
    <a href="/chaxun/renqun/6/" >孕妇</a>
    <a href="/chaxun/renqun/7/" >职业病</a>
</article>

<div class="thre"></div>

<h2><a href="/jbzz/buwei/">更多<span>></span></a>按部位查找</h2>

<article class="clsa regul dsia">
    <?php
    foreach ($partlevel1 as $k => $part) {
        ?>
        <a href="/jbzz/<?php echo $part['pinyin']; ?>/"><?php echo $part['name']; ?></a>
        <?php
    }
    ?>
</article>

<div class="thre"></div>

<h2><a href="/jbzz/keshi/">更多<span>></span></a>按科室查找</h2>

<article class="clsa regul dsia">
    <?php
    foreach ($DepartmentLevel1 as $k1 => $depart) {
        ?>
        <a href="/jbzz/<?php echo $depart['pinyin'] ?>/"><?php echo $depart['name'] ?></a>
        <?php
    }
    ?>
</article>

<div class="thre"></div>
<h2>相关热搜</h2>
<div class="apal">
    <?php
    echo $this->render('wap_ads_seek_hot_search');
    ?>
</div>

<div class="thre"></div>
    <?php
    echo $this->render('/include/hot_pic');
    ?>
<!--底部广告位 -->
<div class="adv">
    <?php
        echo $this->render('/include/ads_below_hotpic');
    ?>
</div>
<div class="thre"></div>
<?php
echo $this->render('/include/health_assistant');
?>