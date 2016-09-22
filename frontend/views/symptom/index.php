<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$info = $model['info'];
$symptom = $model['symptomContent']['content'];
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
  <div class="art_l">
    	<div class="widsp">
            <a href="<?=Url::to(["/zhengzhuang/{$pinyin_initial}/tuji/"])?>/"><img src="<?php echo $model['thumb']['src']?>" alt="<?php echo $symptomName;?>" title="<?php echo $symptomName;?>"></a>
            <b><?php echo $info['name'];?></b>
            <p>
                <?php
                $content = Html::encode($info['description']);
                echo String::cutString($content, 70, '...');
                ?>
                <a href="<?=Url::to(["/zhengzhuang/{$pinyin_initial}/jianjie/"])?>/" title="<?php echo $symptomName;?>详细">[详细]</a>
            </p>
            <div class="moim"><a href="<?=Url::to(["/zhengzhuang/{$pinyin_initial}/tuji/"])?>/">更多图集</a></div>
            <ul class="cuse">
                <?php
                $cause = String::pregReplaceHtml($symptom['cause']);
                $cause = Html::encode($cause);
                $cause = String::cutString($cause, 30,  '...');
                
                $prevent = String::pregReplaceHtml($model['prevent']['content']['relieve']);
                $prevent = Html::encode($prevent);
                $prevent = String::cutString($prevent, 30,  '...');
                ?>
                <li>
                    <a href="<?=Url::to(["/zhengzhuang/{$pinyin_initial}/zzqy/"])?>/" class="detain" title="<?php echo $symptomName.'起因详情';?>">详情>></a>
                    <span><a href="<?=Url::to(["/zhengzhuang/{$pinyin_initial}/zzqy/"])?>/" title="<?php echo $symptomName.'起因';?>">[起因]</a></span>
                    <a href="<?=Url::to(["/zhengzhuang/{$pinyin_initial}/zzqy/"])?>/" title="<?php echo $cause;?>"><?php echo $cause;?>？</a>
                </li>
                
                <li>
                    <a href="<?=Url::to(["/zhengzhuang/{$pinyin_initial}/yufang/"])?>/" class="detain">详情>></a>
                    <span><a href="<?=Url::to(["/zhengzhuang/{$pinyin_initial}/yufang/"])?>/" title="<?php echo $symptomName.'预防';?>">[预防]</a></span>
                    <a href="<?=Url::to(["/zhengzhuang/{$pinyin_initial}/yufang/"])?>/" title="<?php echo $prevent;?>"><?php echo $prevent;?></a>
                </li>
            </ul>
        </div>
      
    	<div class="tost nickn reart"><h2><span><?php echo $info['name'];?></span>的可能疾病</h2></div>
        
        <ul class="tilc"><li class="with_01">可能疾病</li><li class="with_02">伴随症状</li><li class="with_03">就诊科室</li></ul>
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
<!--                <div class="sesin fl">...</div>-->
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
<!--                <div class="sesin fl">...</div>-->
            </li>
        <?php
                }
        }
        ?>
        </ul>
        <p class="wartip" style="margin:5px 0 20px 20px;">（温馨提示：以上资料仅供参考，具体情况请向医生详细咨询）</p>
        
        <div class="sefin"><p>以上疾病都不是您要找的? 试试<b>症状自查</b>工具</p>
            <form action="/zicha/jbzc_zz/" method="post" class="fmache">
                <input type="text" placeholder="请输入您的症状，如：头痛、腹泻..." class="ach_01">
                <input type="submit" value="开始自查" class="ach_02">
            </form>
        </div>
        
        <ul class="direl">
            <?php
            $titArr = ['病因','检查','预防','食疗'];
            $urlArr = ['zzqy','jiancha','yufang','shiliao'];
            $filedArr = ['cause','examine','diagnose','goodfood'];
            $i = 0;
            foreach($filedArr as $k=>$v){
                $content = String::pregReplaceHtml($symptom[$v]);
                $content = Html::encode($content)==''?'暂无内容<br>':Html::encode($content);
            ?>
            <li>
                <h3><?php echo $titArr[$i]?></h3>
                <p>
                    <?php
                    echo String::cutString($content, 50,  '...');
                    ?>
                    <a href="<?php echo Url::to([ '/zhengzhuang/'.$pinyin_initial.'/'.$urlArr[$i] ]);?>/">[详情]</a>
                </p>
            </li>
            <?php
                $i = $i+1;
            }
            ?>
        </ul>
      
    <div class="tost nickn reart">
        <h2><a href="http://ask.9939.com/classid/0" class="amor">更多>></a><span><?php echo $symptomName;?></span>的相关问答</h2>
        <ul class="hoque">
            <?php
            foreach ($model['questions'] as $k => $v) {
                $answer = array_key_exists('answer', $v) ? (empty($v['answer']['content']) ? $v['answer']['suggest'] : $v['answer']['content']) : '暂无回复';
                $askTitle = $v['ask']['title'];
                $answerContent = String::cutString($answer, 50, '...');
                $askUrl = 'http://ask.9939.com/id/' . $v['ask']['id'];
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
            <li>
                <dl class="onla newan">
                    <dt>在线提问<span>(百万医生免费为您做疾病解答)</span></dt>
                    <dd>
                        <form id="quick" name="quiz" method="post" action="http://ask.9939.com/Asking/index/" target="_blank" class="quiz" autocomplete="off">
                            <textarea id="quick_content" name="content" onfocus="javascript:if($('#quick_content').html()=='把您的问题描述一下') $('#quick_content').html('');" placeholder="请输入您的问题标题(5/30)" rows="2"></textarea>
                            <a href="javascript:void(0)" title="立即提问" onclick="return quick_ask()"><img src="/images/reas.png"></a>
                        </form>
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
        <script>
        function quick_ask(){
            if($("#quick_content").val()=="") {
                    alert("请输入内容");
                    $("#quick_content").focus();
                    return false;
            } else if($("#quick_content").val()=="输入您的问题") {
                    alert("请输入内容");
                    $("#quick_content").focus();
                    return false;
            } else if($("#quick_content").val().length<10 || $("#quick_content").val().length>500) {
                    alert("内容字数要在：10-500 之间");
                    $("#quick_content").focus();
                    return false;
            }
            $("#quick").submit();
        }
        </script>
        <div class="adpal apla">
            <?php echo $this->render('/ads/symptom/left_middle');?>
        </div>
       
       <div class="tost nickn reart eypa tocun">
           <h2 class="unkno">
<!--               <div class="clmor">
                   <a href="">全国</a><a href="">广东</a><a href="">北京</a><a href="">上海</a><a class="mopla">更多地区</a>|<a href="">更多>></a>
               </div>-->
               <span><?php echo $symptomName;?></span>医生
               <b>还不清楚什么病，马上问专家！</b>
           </h2>
    		
            
            <div class="palce">
                <div class="provin">
                    <div class="hodor">
                        <p><img src="/images/choe.gif"><b>热门：</b><a>北京</a><a>上海</a><a>广州</a><a>杭州</a></p>
                        <dl>
                            <dt>请选择省份：</dt>
                            <dd><a>北京</a><a>上海</a><a>广东</a><a>江苏</a><a>湖南</a><a>山西</a></dd>
                            <dd><a>山东</a><a>湖北</a><a>浙江</a><a>天津</a><a>陕西</a><a>安徽</a></dd>
                            <dd><a>河南</a><a>四川</a><a>青海</a><a>辽宁</a><a>内蒙古</a><a>江西</a></dd>
                            <dd><a>黑龙江</a><a>河北</a><a>云南</a><a>吉林</a><a>贵州</a><a>广西</a></dd>
                            <dd><a>重庆</a><a>宁夏</a><a>甘肃</a><a>福建</a><a>海南</a><a>新疆</a></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
    <ul class="exnam">
        <?php
        $leftQuankeDoctors = $model['leftQuankeDoctors'];
        if(count($leftQuankeDoctors) > 0){
            foreach($leftQuankeDoctors as $k=>$v){
            
        ?>
        <li>
            <div class="nawht">
                <a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>"><img src="<?php echo Url::to('@community/upload/pic/' . $v['pic']); ?>" alt="<?php echo $v['truename']; ?>" title="<?php echo $v['truename']; ?>"></a>
                <h3><?php echo $v['truename']; ?></h3>
                <p><?php echo $v['doc_keshi']; ?></p>
                <p><a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>">免费问诊</a>问诊量：<span><?php echo $v['totalanswer']; ?></span></p>
            </div>
            <?php
            if (!empty($v['best_dis'])) {
                echo '<p><span>擅长：</span>' . $v['best_dis'] . '</p>';
                echo '<div class="triag"></div>';
            }else{
                echo '<p><span>擅长：</span>暂无</p>';
                echo '<div class="triag"></div>';
            }
            ?>
            
        </li>
        
        <?php
            }
        }
        ?>
        
    </ul>
       
    <div class="tost nickn reart"><h2><span><?php echo $symptomName;?></span>的相关文章</h2>
        <ul class="artcl">
            <?php
        if(isset($model['articles'])){
            foreach($model['articles'] as $k=>$v){
                $articleTitle = $v['title'];
                $articleShortTitle = String::cutString($articleTitle, 30,  '...');
                $date_path = date('Y/md',$v['inputtime']);
                $article_path = sprintf("%s/%s/%d.shtml",'article',$date_path,$v['id']);
                $articleUrl =  sprintf('%s/%s', Yii::getAlias('@jb_domain'), $article_path);
            ?>
            <li><a href="<?=$articleUrl?>" title="<?=$articleTitle?>"><?=$articleShortTitle?></a></li>
            <?php
            }
        }
            ?>
        </ul>
    </div>
    
    
<!--    <div class="tost nickn reart"><h2><a href="" class="amor">更多>></a><span><?php echo $symptomName;?></span>对症药品</h2></div>
    <ul class="uemed">
        <li>
            <a href=""><img src="/images/mein.jpg" alt="" title=""></a><h3>
                <a href="">陈李济咳喘陈李济咳喘顺丸顺丸</a>
            </h3>
            <p>[功能主治] 辛凉解表，清热解毒。感引热引起的发热、咳嗽嗽、清热解毒。[生产厂商] 江西海尔思药业有限公司</p>
        </li>
        <li>
            <a href=""><img src="/images/mein.jpg" alt="" title=""></a>
            <h3><a href="">陈李济咳喘顺丸</a></h3>
            <p>[功能主治] 辛凉解表，清热解毒。感引热引起的发热、咳嗽嗽、清热解毒。[生产厂商] 江西海尔思药业有限公司</p>
        </li>
        <li>
            <a href=""><img src="/images/mein.jpg" alt="" title=""></a>
            <h3><a href="">陈李济咳喘顺丸</a></h3>
            <p>[功能主治] 辛凉解表，清热解毒。感引热引起的发热、咳嗽嗽、清热解毒。[生产厂商] 江西海尔思药业有限公司</p>
        </li>
        <li>
            <a href=""><img src="/images/mein.jpg" alt="" title=""></a>
            <h3><a href="">陈李济咳喘顺丸</a></h3>
            <p>[功能主治] 辛凉解表，清热解毒。感引热引起的发热、咳嗽嗽、清热解毒。[生产厂商] 江西海尔思药业有限公司</p>
        </li>
    </ul>-->
    
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
    <div class="build one">
        <h4 class="gre-arrow">温馨提示</h4>
        <div class="third-doc btline mT18">
            <p class="spcli">就诊科室：
                <?php
            if(isset($model['medicalDepartment'])){
                $medicalDepartment = $model['medicalDepartment'];
                foreach($medicalDepartment['name'] as $k=>$v){
                ?>
                <a href="<?=Url::to("@jb_domain/jbzz/".$medicalDepartment['pinyin'][$k])."/";?>" target="_blank"><?=$v?></a>
                <?php
                }
            }
                ?>
            </p>
            <!--
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
            -->
        </div>
    </div>
    
    <div class="build one">
        <h4 class="gre-arrow">相关症状</h4>
        <div class="one-block btline mT18">
            <ul class="one-label clearfix">
                <?php
                foreach($model['relSymptom'] as $v){
                    $relSymptomName = $v['name'];
                    $symptomUrl = Url::to("@jb_domain"."/zhengzhuang/{$v['pinyin_initial']}/");
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
<!--右边栏 结束-->

</div>
    
<div class="conet">
    <?php
    $model['currLetter'] = strtoupper($pinyin_initial{0});//拼音简写的第一个字母
    $model['randWords'] = $model['randWords'];
    echo $this->render('/include/foot_zimu',[
        'model'=>$model
    ]);
    ?>
</div>