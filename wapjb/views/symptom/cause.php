<?php

use yii\helpers\Url;
$this->params['name'] = $info['name'];
?>

<?php echo $this->render('inc_nav', ['pinyin_initial' => $info['pinyin_initial']]); ?>

<article class="bocon compl shagin diacl">
    <h3><?php echo $info['name'];?><span>病因</span></h3>
    <p class="inde"><?php echo str_replace(PHP_EOL, "</p><p style='text-indent:2em'>", $content); ?></p>
    <a class="shic">分享</a>
</article>
<a href="javascript:void(0)" class="agmor climo">点击查看更多</a>
<a href="<?php echo Url::to('/zhengzhuang/' . $info['pinyin_initial'] . '/'); ?>" class="fimor resea">返回症状<span>&gt;</span></a>
<?php echo $this->render('/include/share', ['title' => $this->title['title']]); ?>
<div class="thre"></div>

<h2>症状相关</h2>
<div class="redis clearfix">
    <?php echo $this->render('inc_symptom_related', ['symptom' => $info]); ?>
</div>

<div class="apal insad" style="margin-top:-.2rem;">
    <?php
        echo $this->render('ads_symptom_disease_below');
    ?>
</div>
<div class="apal insad">
    <?php
        echo $this->render('ads_symptom_hot_search');
    ?>
</div>
<div class="thre"></div>

<article class="dissy">
    <a href="<?php echo Url::to('/zicha/'); ?>"><p><img src="/images/disc.png"></p><p>病急不再乱投医，<span>马上开始自查></span></p></a>
</article>
<div class="thre"></div>

<article class="exname">
    <div class="expin">
        <a href="<?php echo Url::to('@wapask/ask/goAskDoctor'); ?>"><img src="/images/logre.png" alt=""></a><p>专家与您一对一答疑</p><p><span>免费提问</span>及时解答</p>
    </div>
    <div class="eimg">
        <img src="/images/rexp_01.jpg" alt=""><img src="/images/rexp_02.jpg" alt=""><img src="/images/rexp_03.jpg" alt=""><img src="/images/rexp_04.jpg" alt=""><img src="/images/rexp_05.jpg" alt="">
    </div>
</article>
<div class="thre"></div>

