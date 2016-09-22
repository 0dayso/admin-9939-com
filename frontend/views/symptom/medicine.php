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
    	<div class="filtrate resetsy" id="cond">
            <div class="condition recodit clearfix"><a href="" class="chose fr cor666">重置筛选条件</a><b class="nostle cor666 fl">筛选条件：</b>
                <div class="selected fl"><span>品牌：<i>益佰</i><a href=""></a></span><span>医保：<i>非医保</i><a href=""></a></span><span>处方：<i>非处方</i><a href=""></a></span><span>类型：<i>中药</i><a href=""></a></span></div></div>
            <div class="one-floor part remed clearfix" style="z-index: 3">
                <b class="mT10 fl">药品品牌：</b><span class="mT10 cor666 fl">不限</span>
                <div class="allwords">
                    <div class="part-list  clearfix fl" id="part-list1">
                        <div class="smeo cur_on"><a href="" target="_self">益佰</a></div>
                        <div class="smeo"><a href="" target="_self">同仁堂</a></div>
                        <div class="smeo"><a href="" target="_self">同仁堂</a></div><div class="smeo"><a href="" target="_self">同仁堂</a></div>
                        <div class="smeo"><a href="" target="_self">康德平同仁堂</a></div><div class="smeo"><a href="" target="_self">同仁堂</a></div>
                        <div class="smeo"><a href="" target="_self">益佰</a></div><div class="smeo"><a href="" target="_self">同仁堂</a></div>
                        <div class="smeo"><a href="" target="_self">益佰</a></div>
                        <div class="smeo"><a href="" target="_self">益佰</a></div>
                        <div class="smeo"><a href="" target="_self">益佰</a></div><div class="smeo"><a href="" target="_self">益佰</a></div>   
                        <div class="smeo"><a href="" target="_self">益佰</a></div> <div  class="smeo"><a href="" target="_self">益佰</a></div>
                        <div class="smeo"><a href="" target="_self">康德平同仁堂</a></div> <div class="smeo"><a href="" target="_self">同仁堂</a></div>
                        <a class="point_more" href="javascript:void(0)" target="_self" title="展开/收起"></a>
                    </div>
                    <div class="clear"></div>

                </div>
            </div>
            <div class="two-floor part remed clearfix" style="z-index:2">
                <b class="mT10 fl">是否医保：</b><span class="mT10  cor666 fl">不限</span>
                <div class="allwords">
                    <div class="part-list clearfix fl" id="part-list2">
                        <div class="smeo cur_on"><a href="" target="_self">医保</a></div>
                        <div class="smeo"><a href="" target="_self">非医保</a></div>

                    </div>
                </div>
            </div>
            <div class="two-floor part remed clearfix" style="z-index:2">
                <b class="mT10 fl">是否处方：</b><span class="mT10  cor666 fl">不限</span>
                <div class="allwords">
                    <div class="part-list clearfix fl" id="part-list2">
                        <div class="smeo cur_on"><a href="" target="_self">处方</a></div>
                        <div class="smeo"><a href="" target="_self">非处方</a></div>

                    </div>
                </div>
            </div>
            <div class="two-floor part remed clearfix" style="z-index:2; border-bottom:none;">
                <b class="mT10 fl">药品类型：</b><span class="mT10  cor666 fl">不限</span>
                <div class="allwords">
                    <div class="part-list clearfix fl" id="part-list2">
                        <div class="smeo cur_on"><a href="" target="_self">中药</a></div>
                        <div class="smeo"><a href="" target="_self">西药</a></div><div  class="smeo"><a href="" target="_self">中成药</a></div>

                    </div>
                </div>
            </div>  

        </div>

        <div class="rank"><a>综合</a>共找到<span>118</span>种药品</div>
        
        <div class="drugb"><div><img src="/images/bus.jpg"><h4>暂无</h4><p>药品内容正在路上~</p></div></div>
            
<!--        <ul class="drupro">
            <li><a href="http://yiyao.9939.com/zhfl/200812/8993.shtml"><img src="/images/nvj_01.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/8993.shtml">女金丸</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">益气养血，理气活血，止痛。本品用于气血两虚、气滞血瘀所致的月经不调，症见月经提前、月经错后、月经量多、神疲乏力、行经腹痛。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">北京同仁堂股份有限公司同仁堂制药厂</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/200812/3602.shtml"><img src="/images/nvj_02.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/3602.shtml">妇女痛经丸</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">活血，调经，止痛。用于气血凝滞，小腹胀疼，经期腹痛。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">北京同仁堂科技发展股份有限公司制药厂</p></div></div></li>
            <li><a href="http://yiyao.9939.com/bjp/200812/13926.shtml"><img src="/images/nvj_03.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/bjp/200812/13926.shtml">昂立1号R优菌多颗粒（女士型）</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">调节肠道菌群、改善皮肤水份</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">上海交大昂立股份有限公司</p></div></div></li>
            <li><a href="http://yiyao.9939.com/bjp/200812/14473.shtml"><img src="/images/nvj_04.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/bjp/200812/14473.shtml">汤臣倍健牌多种维生素片（男士）</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">均衡补充男性所需的多种维生素、矿物质。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">广东汤臣倍健生物科技股份有限公司</p></div></div></li>
            <li><a href="http://yiyao.9939.com/bjp/200812/14084.shtml"><img src="/images/nvj_05.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/bjp/200812/14084.shtml">黄金搭档牌多种维生素片(男士型)</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">补充多种维生素及矿物质</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">无锡健特药业有限公司 上海黄金搭档生物科技有限公司无锡分公司</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/200812/3359.shtml"><img src="/images/nvj_06.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/3359.shtml">儿童清肺口服液</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">用于面赤身热，咳嗽，痰多，咽痛。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">北京同仁堂股份有限公司同仁堂制药厂</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/200812/9287.shtml"><img src="/images/nvj_07.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/9287.shtml">儿宝膏</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">用于小儿面黄体弱，纳呆厌食、脾虚久泻，精神不振，口干燥渴，盗汗。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">宁波四明制药有限公司</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/200812/10064.shtml"><img src="/images/nvj_08.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/10064.shtml">儿感清口服液</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">解表清热，宣肺化痰。用于小儿外感风寒、肺胃蕴热证，症见：发热恶寒，鼻塞流涕，咳嗽有痰，咽喉肿痛，口渴。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">北京同仁堂股份有限公司同仁堂制药厂</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/201009/20944.shtml"><img src="/images/nvj_09.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/201009/20944.shtml">百夜星</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">本品适用于敏感细菌引起的轻中度感染：包括下呼吸道感染：慢性支气管炎急性发作,支气管扩张伴感染, 急性支气管炎,肺炎等。腹腔胆道, 肠道，伤寒等感染，皮肤软组织感染,其它感染：如副鼻窦炎，中耳炎，眼睑炎。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">赤峰维康生化制药有限公司</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/200812/9377.shtml"><img src="/images/nvj_10.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/9377.shtml">二十六味通经散</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">止血散瘀，调经活血。用于“木布病”引起的胃肠溃疡出血、肝血增盛、胸背疼痛、月经不调、闭经以及经血逆行引起的小腹胀满疼痛，血瘀症瘕。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">西藏雄巴拉曲神水藏药厂</p></div></div></li>
        </ul>-->

<!--<div class="paget paint"><a href="">首页</a><a href=""><<</a><a href="" class="cust">1</a><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a><span>...</span><a href="">10</a><a href="">>></a><input type="text" placeholder="10"><a href="">跳转</a><a href="">尾页</a></div>-->
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
            <ul class="one-label clearfix">
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
    
    