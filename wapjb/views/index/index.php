<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = "查疾病_疾病大全_最齐全的疾病百科_久久健康网";
$this->params['keywords'] = "疾病查询,疾病大全,疾病百科,疾病库";
$this->params['description'] = "久久健康网-疾病查询，提供最专业、全面的疾病数据库，是最详尽的疾病大全查询工具，包括疾病病因 、症状、检查、鉴别、预防及治疗等疾病百科知识，查询疾病方便、快捷，深受网民喜爱！";
?>
<nav>
    <a href="/chaxun/renqun/"><span></span><p>按人群查</p></a><a href="/jbzz/buwei/"><span></span><p>按部位查</p></a><a href="/jbzz/keshi/"><span></span><p>按科室查</p></a><a href="<?php echo Url::to('/zicha/jbzc/') ?>"><span></span><p>症状自查</p></a>
</nav>

<!--搜索 start-->
<?php
echo $this->render('/include/search');
?>
<!--搜索 end-->

<!--当季多发疾病 start -->
<?php echo $this->render('seasonal_disease', ['seasonal_disease' => $seasonal_disease]); ?>
<!--当季多发疾病 end -->
<div class="thre"></div>

<!-- 常见人群疾病 start -->
<?php echo $this->render('common_disease_population', ['common_disease_population' => $common_disease_population]); ?>
<!-- 常见人群疾病 end -->
<div class="thre"></div>

<!--科室分类 start-->
<?php echo $this->render('department_classification', ['department_classification' => $department_classification, 'midDepartmentMap' => $midDepartmentMap]); ?>
<!--科室分类 end-->
<div class="thre"></div>

<!-- 最新疾病回答 start -->
<?php echo $this->render('latest_disease_answer', ['latest_disease_answer' => $latest_disease_answer]); ?>
<!-- 最新疾病回答 end -->
<div class="thre"></div>

<!-- 最新疾病文章 start -->
<?php echo $this->render('latest_disease_article', ['latest_disease_article' => $latest_disease_article]); ?>
<!-- 最新疾病文章 end -->
<div class="thre"></div>

<!-- 疾病热词 start -->
<?php echo $this->render('disease_hot_words', ['disease_hot_words' => $disease_hot_words]); ?>
<!-- 疾病热词 end -->
<div class="thre"></div>

<!-- 疾病专区 start -->
<?php echo $this->render('disease_zone', ['diseaseZone' => $diseaseZone]); ?>
<!-- 疾病专区 end -->
<div class="thre"></div>

<!--首页热图推荐上方广告-->
<h2>相关热搜</h2>
<div class="apal">
    <?php echo $this->render('ads/index_first_ads'); ?>
</div>
<div class="thre"></div>