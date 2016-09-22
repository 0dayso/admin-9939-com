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
            <a><b><?php echo $info['name'];?></b></a>
        </div>
        <h1 class="sypmt"><b><?php echo $symptomName;?></b><span>症状</span></h1>
        <?php echo $this->render('inc_nav',['pinyin_initial'=>$pinyin_initial]);?>
    </div>
    <div class="art_wra" style="margin:0 auto;">
        
<div class="art_l" id="D1pic1">
    	<div class="fadoc">名医推荐
            
        </div>
    <ul class="fadol fcon">
        <?php
        if(isset($model['leftDoctor'])){
        $doctor = $model['leftDoctor'];
        if ($doctor && !empty($doctor)) {
            foreach ($doctor as $k => $v) {
                $truename = $v['nickname'] ? : $v['nickname'];
                ?>
                <li>
                    <div class="exdoc fl">
                        <a href="<?php echo Url::to('@community/user/?uid=' . $v['uid']); ?>">
                            <img src="<?php echo Url::to('@community/upload/pic/' . $v['pic']); ?>" alt="<?php echo $truename; ?>" title="<?php echo $truename; ?>">
                        </a>
                        <p><a href="<?php echo Url::to('@community/user/?uid=' . $v['uid']); ?>">向TA咨询</a></p></div>
                    <div class="docun fl">
                        <p class="inst_01"><a href="<?php echo Url::to('@community/user/?uid=' . $v['uid']); ?>"><?php echo $truename; ?></a></p>
                        <p class="inst_02"><?php echo $v['zhicheng']; ?></p>
                        <?php if (!empty($v['best_dis'])) { ?>
                            <p class="inst_04">
                                <span class="sp_01">擅长：</span>
                                <span class="sp_02"><?php echo $v['best_dis'] ?></span>
                            </p>
                        <?php } ?>
                    </div>
                </li>
                <?php
            }
        }
        }
        ?>
    </ul>
      
    
    <div class="tost nickn reart"><h2><a href="http://ask.9939.com/" class="amor">更多&gt;&gt;</a><span><?php echo $symptomName;?></span>热门咨询</h2>
            <ul class="hoque">
            <?php
            foreach($model['questions'] as $k=>$v){
                $answer = array_key_exists('answer', $v) ? $v['answer']['content'] : '暂无回复';
                $askTitle = $v['ask']['title'];
//                $askContentTmp = String::pregReplaceHtml($v['ask']['content']);
                $answerContent = String::cutString($answer, 50, '...');
                $askUrl = 'http://ask.9939.com/id/'.$v['ask']['id'];
            ?>
            <li>
                <dl>
                    <dt><a href="<?=$askUrl?>"><?=$askTitle?></a></dt>
                    <dd><?=$answerContent?><a href="<?=$askUrl?>">[详情]</a></dd>
                </dl>
            </li>
            
            <?php
            }
            ?>
            </ul>
        </div>
<!--    <div class="tost nickn reart eypa"><h2><span><?php //echo $symptomName;?></span>推荐专家</h2>
        	<ul class="exnur expco einfo">
            	<li><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
                <li><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
                <li style="margin-right: 0px;"><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
                <li><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
                <li><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
                <li style="margin-right: 0px;"><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
            </ul>
        </div>-->
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
        
        

<!--右边栏 开始-->
<div class="rw298 rdisea">
    <!--右上广告 开始-->
    <div class="clumn mTop">
        <?php echo $this->render('/ads/common/ads_tr'); ?>
    </div>
    <!--右上广告 结束-->
    <!--<div class="build one">
        <h4 class="gre-arrow">温馨提示</h4>
        <div class="third-doc btline mT18">
            <p class="spcli">就诊科室：
            </p>
            
            <h3 class="morfit"><a href="" onmouseover="divTag('n1Tab11', 'indexahover', '', 1, 0)" name="n1Tab11" id="n1Tab11" class="indexahover">宜吃食物</a><a  href="" onmouseover="divTag('n1Tab11', 'indexahover', '', 2, 0)" name="n1Tab11" id="n1Tab11" style="border-right:none;">忌吃食物</a></h3>
            <div class="cnea" name="n1Tab11Content" id="n1Tab11Content" >
                <div class="zj_div3">
                    <div class="zj_fgimg1" id="anleft7"></div>  
                    <div class="zj_fgun">
                        <ul class="footscrool" id="li_wrap7">
                            <li>
                                <img src="/images/corn.jpg" width="150" height="120" />
                                <p><b>宜吃理由：</b>1、多食用含丰富纤维素和维生素的水果、蔬菜； 2、饮食要多样化，杂食五谷粗粮； 3、宜食易于消化而质地较软的食物。</p>
                                <a href="">小米小米小小</a>
                            </li>
                            <li>
                                <img src="/images/a_lad.jpg" width="150" height="120" />

                                <p><b>宜吃理由：</b>1、1多食用含丰富纤维素和维生素的水果、蔬菜； 2、饮食要多样化，杂食五谷粗粮； 3、宜食易于消化而质地较软的食物。</p>
                                <a href="">小米小米小米小米小</a>
                            </li>
                        </ul>
                    </div>
                    <div class="zj_fgimg2" id="anright7"></div> 
                </div>
            </div>
            <div class="cnea" name="n1Tab11Content" id="n1Tab11Content" style="display:none;">
                <div class="zj_div3">
                    <div class="zj_fgimg1" id="anleft1"></div>  
                    <div class="zj_fgun">
                        <ul class="footscrool" id="li_wrap1">
                            <li>
                                <img src="/images/corn.jpg" width="150" height="120" />
                                <p><b>忌吃理由：</b>1、3多食用含丰富纤维素和维生素的水果、蔬菜； 2、饮食要多样化，杂食五谷粗粮； 3、宜食易于消化而质地较软的食物。</p>
                                <a href="">小米小米小小</a>
                            </li>
                            <li>
                                <img src="/images/a_lad.jpg" width="150" height="120" />

                                <p><b>吃理由：</b>1、14多食用含丰富纤维素和维生素的水果、蔬菜； 2、饮食要多样化，杂食五谷粗粮； 3、宜食易于消化而质地较软的食物。</p>
                                <a href="">小米小米小米小米小</a>
                            </li>
                        </ul>
                    </div>
                    <div class="zj_fgimg2" id="anright1"></div> 
                </div>
            </div>
            
        </div>
    </div>-->
    
    <div class="build one">
        <h4 class="gre-arrow">相关症状</h4>
        <div class="one-block btline mT18">
            <ul class="one-label  label-disea clearfix">
                <?php
                foreach($model['relSymptom'] as $v){
                    $relSymptomName = $v['name'];
                    $symptomUrl = Url::to(["/zhengzhuang/{$v['pinyin_initial']}/"]);
                ?>
                <li><a href="<?=$symptomUrl?>/" title="<?=$relSymptomName?>"><?=$relSymptomName?></a></li>
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
<!--右边栏 结束-->

</div>
    
    