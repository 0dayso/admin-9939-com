<?php
    use yii\helpers\Url;

    $this->params['name']=$model['name'];
    $symptom['name'] = $model['name'];
    $symptom['pinyin_initial'] = $model['pinyin_initial'];
?>
<article class="fana sypak clearfix">
    <a href="/zhengzhuang/<?php echo $model['pinyin_initial']?>/">综合</a>
    <a href="/zhengzhuang/<?php echo $model['pinyin_initial']?>/jianjie/" class="cup">症状知识</a>
    <a href="/zhengzhuang/<?php echo $model['pinyin_initial']?>/zixun/">在线问诊</a>
    <a href="/zhengzhuang/<?php echo $model['pinyin_initial']?>/yiyao/">找药品</a>
    <a href="/zhengzhuang/<?php echo $model['pinyin_initial']?>/article_list.shtml">文章解读</a>
</article>
<article class="bocon compl shagin diacl">
    <h3><?php echo $model['name'];?><span>检查</span></h3>
    <p class="inde">
        <?php echo $model['content'];?>
    </p>
<a class="shic">分享</a>
</article>
<a href="javascript:void(0)" class="agmor climo">点击查看更多</a>
<a href="" class="fimor resea">返回症状<span>&gt;</span></a>
<div class="thre"></div>
<h2>症状相关</h2>
<div class="redis clearfix">
    <?php echo $this->render('inc_symptom_related',['symptom' => $model]);?>
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
<article class="dissy"><a href="<?php echo Url::to('/zicha/');?>"><p><img src="/images/disc.png"></p><p>病急不再乱投医，<span>马上开始自查></span></p></a></article>
<div class="thre"></div>
<article class="exname">
    <div class="expin"><a href="<?php echo Url::to('@wapask/ask/goAskDoctor')?>"><img src="/images/logre.png" alt=""></a><p>专家与您一对一答疑</p><p><span>免费提问</span>及时解答</p></div>
    <div class="eimg">
        <img src="/images/rexp_01.jpg" alt="" onclick="tiaozhuan();">
        <img src="/images/rexp_02.jpg" alt="" onclick="tiaozhuan();">
        <img src="/images/rexp_03.jpg" alt="" onclick="tiaozhuan();">
        <img src="/images/rexp_04.jpg" alt="" onclick="tiaozhuan();">
        <img src="/images/rexp_05.jpg" alt="" onclick="tiaozhuan();">
    </div>
</article>

<div class="thre"></div>
<?php
    echo $this->render("/include/share",['title'=>$this->title['title']]);
?>
<script>
    function tiaozhuan(){
        window.location.href="<?php echo Url::to('@wapask/ask/goAskDoctor')?>";
    }
</script>
