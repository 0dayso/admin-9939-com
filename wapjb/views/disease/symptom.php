<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;

$diseaseName = $disease['name'];
$this->title = "${diseaseName}的症状_${diseaseName}的早期症状_${diseaseName}的症状表现_疾病百科_久久健康网";
$this->params['keywords'] = "${diseaseName}的症状,${diseaseName}的早期症状,${diseaseName}的症状表现,${diseaseName}的表现";
$this->params['description'] = "久久健康网-疾病百科频道提供专业、全面的${diseaseName}的症状、${diseaseName}的早期症状、${diseaseName}的症状表现、${diseaseName}的表现等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
$this->params['name'] = $disease['name'];
?>

<?php echo $this->render('inc_nav', ['pinyin_initial' => $disease['pinyin_initial']]); ?>
<article class="bocon compl shagin diacl usymt">
    <h3><?php echo $disease['name']; ?><span>典型症状</span></h3>
    <h4>典型症状</h4>
    <div class="hosi">
        <?php
        if (isset($disease['tsymptom'])) {
            foreach ($disease['tsymptom'] as $symptom) {
                ?>
                <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/" title="<?php echo $symptom['name']; ?>"><?php echo $symptom['name']; ?></a>
                <?php
            }
        }
        ?>
    </div>
    <h4>症状内容</h4>
    <p class="inde"><?php echo str_replace(PHP_EOL, "</p><p style='text-indent:2em'>", $disease['symptom']); ?></p>
    <a class="shic">分享</a>
</article>
<!--分享-->
<?php echo $this->render('/include/share',['title'=>$this->title]); ?>
<a href="javascript:void(0)" class="agmor climo">点击查看更多</a>
<a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/'); ?>" class="fimor resea">返回疾病<span>&gt;</span></a>
<div class="thre"></div>

<h2>疾病相关</h2>
<div class="redis clearfix">
    <?php echo $this->render('inc_disease_related', ['name' => $disease['name'], 'pinyin_initial' => $disease['pinyin_initial']]); ?>    
</div>

<div class="apal insad txco">
    <?php echo $this->render('ads/common_disease_ads_1'); ?>
</div>
<div class="apal insad">
    <?php echo $this->render('ads/common_disease_ads_2'); ?>
</div>
<div class="thre"></div>

<?php
if (isset($relArticles) && !empty($relArticle)) {
    ?>
    <h2 class="syart"><?php echo $disease['name']; ?><span>症状文章</span></h2>
    <article class="male loswei cand">
        <section class="sechoi">
            <ul class="rade">
                <?php
                foreach ($relArticle as $k => $v) {
                    ?>
                    <li><a href="<?php echo Url::to('/article/' . $v['id'] . '.shtml', true); ?>"><?php echo $v['title']; ?></a></li>
                    <?php
                }
                ?>
            </ul>
            <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/', true) ?>" class="fimor">点击查看更多<span>&gt;</span></a>
        </section>
    </article>
    <div class="thre"></div>
<?php } ?>

<!-- 免费提问-->
<?php echo $this->render('inc_free_ask', ['pinyin_initial' => $disease['pinyin_initial']]); ?>

<div class="thre"></div>

