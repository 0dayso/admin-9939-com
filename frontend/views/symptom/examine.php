<?php
use yii\helpers\Url;
use librarys\helpers\utils\String;

$info = $model['info'];
$content = $model['content'];

$pinyin_initial = $info['pinyin_initial'];
$symptomName = $info['name'];
?>

<?php
//引入导航
echo $this->render("inc_main_nav");

//引入左侧浮动
echo $this->render("inc_menu", ['pinyin_initial' => $pinyin_initial]);

//引入右侧漂浮
echo $this->render("/include/rightFloat");
?>
<!--ends-->
<div class="content bocon">
    <div class="art_s"> 您所在的位置：
        <a href="http://www.9939.com/" target="_blank">久久健康网</a>>
        <a href="<?=Url::to("@jb_domain")?>/" target="_blank">疾病百科</a>>
        <a href="<?=Url::to("@jb_domain/jbzz/")?>">疾病症状</a>>
        <a><b><?php echo $symptomName; ?></b></a>
    </div>

    <h1 class="sypmt"><b><?php echo $symptomName; ?></b><span>症状</span></h1>

    <?php echo $this->render('inc_nav', ['pinyin_initial' => $pinyin_initial]); ?>
</div>


<div class="art_wra" style="margin:0 auto;">
    <div class="art_l">
        <div class="tost nickn bshare prevp spread graco"><h2><span><?php echo $symptomName; ?></span>检查</h2>
            <p>
                <?php echo str_replace(PHP_EOL,"</p><p style='text-indent:2em'>",$content); ?>
            </p>
            <?php echo $this->render('/include/share', ['title' => $this->title['title']]); ?>  
        </div>

        <div class="tost nickn reart"><h2><span><?=$symptomName?></span>的可能疾病</h2></div>
        <ul class="tilc">
            <li class="with_01">可能疾病</li><li class="with_02">伴随症状</li><li class="with_03">就诊科室</li>
        </ul>
        <ul class="dissy">
            <?php 
        if(isset($model['disease']['relDisease'])){
            $relDisease = $model['disease']['relDisease'];
            $allSymptom = $model['disease']['relSymptom'];
            ?>
            <?php foreach($relDisease as $key=>$v){?>
            <?php
            $diseaseName = $v['name'];
            $diseasePinyin = $v['pinyin_initial'];
            $relSymptom = $allSymptom[$diseasePinyin];
            ?>
            <li class="with_01"><a href="<?=Url::to("@jb_domain/{$diseasePinyin}/")?>" title="<?php echo $diseaseName;?>"><?php echo $diseaseName;?></a></li>
            <li class="with_02">
                <div class="fisin fl">
                <?php
                $diseaseSymptomCustom = $model['diseaseSymptomCustom'][$diseasePinyin];
                foreach ($diseaseSymptomCustom as $k=>$vv){
                        $title = $relSymptom[$k]['name'];
                        $pinyin_initial = $relSymptom[$k]['pinyin_initial'];
                ?>
                <a href="<?=Url::to("/zhengzhuang/{$pinyin_initial}/")?>" title="<?php echo $title;?>"><?php echo $vv;?></a>
                <?php
                }
                ?>
                </div>
            </li>
            <li class="with_03">
                <div class="fisin fl">
                <?php
                $depart = $model['diseaseDepartmentCustom'][$key];
                $treatmentDepartArr = explode(' ', $v['treat_department']);
                foreach($depart as $kk=>$v){
                    $name = $treatmentDepartArr[$kk];
                    $url = isset($model['departPinyin'][$name]) ? Url::to("@jb_domain/jbzz/".$model['departPinyin'][$name]."/") : Url::to("@jb_domain/jbzz/");
                ?>
                <a href="<?=$url?>" title="<?php echo $name?>"><?php echo $v?></a>
                <?php
                }
                ?>
                </div>
            </li>
            <?php
                }
        }
            ?>
        </ul>
        <p class="wartip newma">（温馨提示：以上资料仅供参考，具体情况请向医生详细咨询）</p>

        <!--热门疾病-->
        
        <!--左侧猜你感兴趣 开始-->
        <div class="rela_a a_labe">
            <div class="a_rea a_hop a_mar">
                <h2><b>猜你感兴趣</b></h2>
                <div class="aplces">
                    <?php echo $this->render('/ads/common/ads_interest'); ?>
                </div>
            </div>
        </div>
        <!--左侧猜你感兴趣 结束-->
    </div>

    <div class="rw298 rdisea">
        <!--右上广告 开始-->
        <div class="clumn mTop">
            <?php echo $this->render('/ads/common/ads_tr'); ?>
        </div>
        <!--右上广告 结束-->
        <div class="build one">
            <h4 class="gre-arrow">相关症状</h4>
            <div class="one-block btline mT18">
                <ul class="one-label clearfix">
                <?php
                foreach($model['relSymptom'] as $v){
                    $symptomName = $v['name'];
                    $symptomUrl = Url::to(["/zhengzhuang/{$v['pinyin_initial']}/"]);
                ?>
                <li><a href="<?=$symptomUrl?>/" title="<?=$symptomName?>"><?=$symptomName?></a></li>
                <?php
                }
                ?>
                </ul>
            </div>
        </div>
        
        <!-- 右侧专家咨询 start -->
        <?php
        if(isset($model['doctorInfos'])){
            echo $this->render('inc_right_doctor', [
                'doctorInfos' => $model['doctorInfos'],
            ]);
        }
        ?>
        <!-- 右侧专家咨询 end-->
        
        <!--右侧热搜标签 开始-->
        <?php
        echo $this->render('inc_right_hotsearch_tag',[
            'model'=>[
                'pinyin_initial' => $info['pinyin_initial'],
                'symptomName' => $symptomName
            ]
        ]);
        ?>
        <!--右侧热搜标签 结束-->
        
        <!--右侧热门专题 开始-->
        <?php
        //右侧热门专题
        echo $this->render('inc_right_zt');
        ?>
        <!--右侧热门专题 结束-->
        
        <!--右侧精彩推荐 开始-->
        <div>
            <div class="build five">
                <h4 class="gre-arrow">精彩推荐</h4>
                <div class="clumn mT18">
                    <?php echo $this->render('/ads/common/ads_br'); ?>
                </div>
            </div>
        </div>
        <!--右侧精彩推荐 结束-->
        
        <div class="clear"></div>
    </div>

</div>