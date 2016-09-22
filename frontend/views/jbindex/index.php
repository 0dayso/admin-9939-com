<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;
?>

<?php
////主导航上方
//echo $this->render("inc_nav_top");

//引入导航
echo $this->render("inc_main_nav");

//引入右侧漂浮
echo $this->render("/include/rightFloat");
?>
<!--导航下 第一屏 开始-->
<?php echo $this->render("inc_mid_searchCategory",[
        'data' => $model['inc_mid_searchCategory']
    ]);
?>
<!--导航下 第一屏 结束-->

<!--///////////////////////////////广告1 开始///////////////////////////////-->
<div class="balay clearfix">
<?php
echo $this->render('ad/index_ads_01');
?>
</div>
<!--///////////////////////////////广告1 结束///////////////////////////////-->

<!--第二屏 按人群查疾病 开始-->
<?php
echo $this->render('inc_mid_people',[
        'data' => $model['inc_mid_people']
    ]);
?>
<!--第二屏 按人群查疾病 结束-->




<!--///////////////////////////////广告2 开始///////////////////////////////-->
<div class="balay clearfix">
<?php
echo $this->render('ad/index_ads_02');
?>
</div>
<!--///////////////////////////////广告2 结束///////////////////////////////-->




<!--第三屏 按科室查疾病 开始-->
<?php echo $this->render("inc_mid_department",[
        'data' => $model['inc_mid_department']
    ]);
?>
<!--第三屏 按科室查疾病 结束-->




<!--///////////////////////////////广告3 开始///////////////////////////////-->
<div class="balay clearfix">
<?php
echo $this->render('ad/index_ads_03');
?>
</div>
<!--///////////////////////////////广告3 结束///////////////////////////////-->




<!--第四屏 按部位查疾病 结束-->
<?php
echo $this->render("inc_mid_part",[
        'data' => $model['inc_mid_part']
    ]);
?>
<!--第四屏 按部位查疾病 结束-->





<!--///////////////////////////////广告4 开始///////////////////////////////-->
<div class="balay clearfix">
<?php
echo $this->render('ad/index_ads_04');
?>
</div>
<!--///////////////////////////////广告4 结束///////////////////////////////-->





<!--第五屏 疾病问答 开始-->
<?php echo $this->render("inc_mid_ask",[
        'data' => $model['inc_mid_ask']
    ]);?>
<!--第五屏 疾病问答 结束-->




<!--///////////////////////////////广告5 开始///////////////////////////////-->
<div class="balay clearfix">
<?php
echo $this->render('ad/index_ads_05');
?>
</div>
<!--///////////////////////////////广告5 结束///////////////////////////////-->




<!--第六屏 疾病资讯 开始-->
<?php echo $this->render("inc_mid_news",[
        'data' => $model['inc_mid_news']
    ]);?>
<!--第六屏 疾病资讯 结束-->

<!--底部热词 开始-->
<?php echo $this->render("inc_foot_hotwords",[
        'data' => $model['inc_foot_hotwords']
    ]);?>
<!--底部热词 结束-->

<!--底部友情链接 开始-->
<?php echo $this->render("inc_foot_links",[
        'data' => $model['inc_foot_links']
    ]);?>
<!--底部友情链接 结束-->