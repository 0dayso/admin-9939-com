<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;

$this->title = $disease['name'] . '相关解答_' . $disease['name'] . '相关文章_疾病百科_久久健康网';
$this->params['keywords'] = $disease['name'] . '相关解答,' . $disease['name'] . '相关文章';
$this->params['description'] = '久久健康网-疾病百科频道提供专业、全面的' . $disease['name'] . '相关解答、' . $disease['name'] . '相关文章等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
$this->params['name'] = $disease['name'];
?>

<?php echo $this->render('inc_nav', ['pinyin_initial' => $disease['pinyin_initial']]); ?>

<article class="resp">
    <?php
    $arrtype = [
        '0' => '全部文章',
        '1' => '症状',
        '2' => '病因',
        '3' => '检查',
        '4' => '鉴别',
        '5' => '治疗',
        '6' => '护理',
        '7' => '预防',
        '8' => '并发症',
    ];
    foreach ($arrtype as $k => $v) {
        $indexahover = ($type == $k) ? 'cumn' : '';
        ?>
        <a href="/<?php echo $disease['pinyin_initial']; ?>/article_list<?php echo $k ? '_t' . $k : ''; ?>.shtml" class="<?php echo $indexahover; ?>"><?php echo $v; ?></a>
        <?php
    }
    ?>
    <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/') ?>">返回疾病<span>></span></a>
</article>

<article class="raatu dream">
    <?php echo $this->render('inc_article_list', ['article' => $article]); ?>
</article>
<input type="hidden" name="diseaseid" id="diseaseid" value="<?php echo $disease['id']; ?>">
<input type="hidden" name="type" id="type" value="<?php echo $type ? : 0; ?>">
<input type="hidden" name="total" id="total" value="<?php echo $total; ?>">
<?php
if (isset($article) && !empty($article) && $total > 10) {
    ?>
    <p href="javascript:;" class="agmor article_load">点击查看更多</p>
    <?php
} else {
    ?>
    <p href="javascript:;" class="agmor">显示没有可加载内容</p>
    <?php
}
?>

<a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/') ?>" class="fimor resea">返回疾病<span>&gt;</span></a>
<div class="thre"></div>

<h2>疾病相关</h2>
<div class="redis clearfix">
    <?php echo $this->render('inc_disease_related', ['name' => $disease['name'], 'pinyin_initial' => $disease['pinyin_initial']]); ?>
</div>

<div class="apal insad" style="margin-top:-.2rem;">
    <?php echo $this->render('ads/common_disease_ads_1'); ?>
</div>
<div class="apal insad">
    <?php echo $this->render('ads/common_disease_ads_2'); ?>
</div>

<div class="thre"></div>
<article class="dissy"><a href="<?php echo Url::to('/zicha/', true) ?>"><p><img src="/images/disc.png"></p><p>病急不再乱投医，<span>马上开始自查></span></p></a></article>
<div class="thre"></div>

<!-- 免费提问-->
<?php echo $this->render('inc_free_ask', ['pinyin_initial' => $disease['pinyin_initial']]); ?>

<div class="thre"></div>
<script type="text/javascript" src="<?php echo Url::to('/js/disease/load_more.js') ?>"></script>

