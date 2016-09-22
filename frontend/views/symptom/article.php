<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$info = $model['info'];

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
        <a><b><?php echo $symptomName;?></b></a>
    </div>

    <h1 class="sypmt"><b><?php echo $symptomName;?></b><span>症状</span></h1>

    <?php echo $this->render('inc_nav',['pinyin_initial'=>$pinyin_initial]);?>
</div>

<div class="art_wra erupt">
    <div class="art_l">
        <div class="tost bshare reati todi spread graco"><h2><span><?php echo $symptomName;?></span>相关文章</h2>
<!--            <p>
                <?php
                $content = Html::encode($info['description']);
                echo String::cutString($content, 70, '...');
                ?>
            </p>-->
        </div>
        <!--相关资讯-->
        <div class="a_info">
            <?php
            if(isset($model['articles'])){
            ?>
            <ul class="newlis">
                <li>
                <?php
                    $i = 1;
                    foreach($model['articles'] as $v){
                        $articleTitle = $v['title'];
                        $articleShortTitle = String::cutString($articleTitle, 20, '...');
                        $articleDate = date('Y-m-d', $v['updatetime']);
    //                    $articleUrl = Url::to(["/article/{$v['id']}.shtml"]);
                        $articleUrl = \librarys\helpers\utils\Url::getdisarticleUrl($v);
                    ?>
                        <dl>
                            <dd><span><?=$articleDate?></span><a href="<?=$articleUrl?>" title="<?=$articleTitle?>"><?=$articleShortTitle?></a></dd>
                        </dl>
                    <?php
                        if($i % 5==0 ){
                            echo '</li><li>';
                        }
                        $i++;
                    }
                ?>
                </li>
                
            </ul>
            <div class="paget paint">
                <?php echo $model['paging']->view();?>
            </div>
            <?php
            }
            ?>
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
                        $relSymptomName = $v['name'];
                        $symptomUrl = Url::to("/zhengzhuang/{$v['pinyin_initial']}/");
                    ?>
                    <li><a href="<?=$symptomUrl?>" title="<?=$relSymptomName?>"><?=$relSymptomName?></a></li>
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
<script type="text/javascript" src="<?=Url::to("@jb_domain");?>/js/symptom/articlelist.js"></script>
<!--底部 开始--> 

<!--底部 开始-->

<!--1123-->
<div class="conet">
    <?php
    $model['currLetter'] = strtoupper($pinyin_initial{0});//拼音简写的第一个字母
    $model['randWords'] = $model['randWords'];
    echo $this->render('/include/foot_zimu',[
        'model'=>$model
    ]);
    ?>
</div>