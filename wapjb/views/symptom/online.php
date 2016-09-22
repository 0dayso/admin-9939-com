<?php

use yii\helpers\Url;

$this->params['name'] = $info['name'];
?>

<?php echo $this->render('inc_nav', ['pinyin_initial' => $info['pinyin_initial']]); ?>

<ul class="expert blood doname">
    <?php
    if (isset($doctor) && !empty($doctor)) {
        foreach ($doctor as $k => $v) {
            $truename = $v['nickname'] ? : $v['nickname'];
            ?>
            <li>
                <a href="<?php echo Url::to('@community/user/?uid=' . $v['uid']); ?>"><img src="<?php echo Url::to('@community/upload/pic/' . $v['pic']); ?>" alt="<?php echo $truename; ?>"></a>
                <div>
                    <h3><a href="<?php echo Url::to('@community/user/?uid=' . $v['uid']); ?>"><?php echo $truename; ?></a><span style="display: none;"><b>问</b><b>挂</b><b>加</b><b>图</b></a></span></h3>
                    <p><?php echo $v['zhicheng']; ?>&nbsp;</p>
                    <p>擅长：<?php echo!empty($v['best_dis']) ? $v['best_dis'] : '暂无'; ?></p>
                </div>
                <em></em>
            </li>
            <?php
        }
    }
    ?>
</ul>
<div class="thre"></div>

<!--相关问答 start -->
<ul class="askan direc">
<?php echo $this->render('inc_related_ask', ['asks' => $asks]); ?>
</ul>
<a href="javascript:;" class="fimor load_ask">点击查看更多<span>&gt;</span></a>
<input type="hidden" name="keywords" id="keywords" value="<?php echo $info['name']; ?>">
<!--相关问答 end -->
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
    <a href="<?php echo Url::to('/zhengzhuang/zixun/');?>"><p><img src="/images/disc.png"></p><p>病急不再乱投医，<span>马上开始自查></span></p></a>
</article>
<div class="thre"></div>

<article class="exname">
    <div class="expin">
        <a href="<?php echo Url::to('@wapask/ask/goAskDoctor')?>"><img src="/images/logre.png" alt=""></a>
        <p>专家与您一对一答疑</p><p><span>免费提问</span>及时解答</p>
    </div>
    <div class="eimg">
        <img src="/images/rexp_01.jpg" alt=""><img src="/images/rexp_02.jpg" alt=""><img src="/images/rexp_03.jpg" alt=""><img src="/images/rexp_04.jpg" alt=""><img src="/images/rexp_05.jpg" alt="">
    </div>
</article>
<div class="thre"></div>
<script type="text/javascript" src="<?php echo Url::to('/js/symptom/load_more.js'); ?>"></script>
