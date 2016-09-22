<?php

use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$options = $model['option'];
$condition = $model['condition'];
$pinyin_initial = '';
?>

<?php
//引入导航
echo $this->render("inc_main_nav");
?>
<!--ends-->
<div class="content bocon">
    <div class="art_s"> 您所在的位置：
        <a href="http://www.9939.com/" target="_blank">久久健康网</a>>
        <a href="<?=Url::to("@jb_domain")?>/" target="_blank">疾病百科</a>>
        <a href="<?=Url::to("@jb_domain/jbzz/")?>">疾病症状</a>>
        <a><b>疾病自查</b></a>
    </div>
</div>

<div class="content-one informa">
    <div class="mark"><h3></h3></div>
    <div class="personal">
        <div class="w689">
            <div class="steps "><img  src="/images/ins_picm1.png"/></div>
            <div class="two-smtoms">
                <div class="sympt-person">
                    <h4><img src="/images/ins_wrt1.png"/ ></h4>
                    <ul class="sympt_man clearfix">
                        <li><b>性别：</b>
                            <div class="sexdul  clearfix fl">
                                <p class="currt" data-sex="<?=$condition['sex']==1?'1':'0'?>"><?=$condition['sex']==1?'男':'女'?></p>
                                <ul class="onlsex" style="display:none;">
                                    <?php
                                    foreach($options['sex'] as $k=>$v){
                                    ?>
                                        <li data-sex='<?=$k?>'><?=$v?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </li>
                        <li class="mT44"><b>年龄：</b>
                            <div class="age  clearfix fl">
                                <p class="set" data-age='<?=$condition['age']?>'><?=$options['age'][$condition['age']]?></p>
                                <ul class="onhid" style="display:none;">
                                    <?php
                                    foreach($options['age'] as $k=>$v){
                                    ?>
                                        <li data-age='<?=$k?>'><?=$v?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </li>
                        <li><b>职业：</b>
                            <div class="profess clearfix  fl">
                                <p class="currmd" data-job='<?=$condition['job']?>'><?=$options['job'][$condition['job']]?></p>
                                <div class="lmos"  style="display:none;">
                                    <h5>选择您的职业<i><img  src="/images/inserr.png"/></i></h5>
                                    <ul class="clific clearfix" >
                                        <?php
                                        $i=0;
                                        foreach($options['job'] as $k=>$v){
                                        ?>
                                            <li data-job='<?=$k?>'><?=$v?></li>
                                            <?php if($i!==6){?>
                                            <span>|</span>
                                            <?php }?>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="sympt-search clearfix">
                    <h4><img src="/images/ins_wrt2.png"/ ></h4>
                    <form method="" class="smko">
                        <input id="info[title]" name="info[title]" class="demand fl"  max_char_num="30" maxlength="30" placeholder="请输入您的症状，如头疼，咳嗽...">
                        <a class="msech fl">搜索</a>
                        <div class="query-log" style="display:none;">
<!--                            <a href="www.badiu.com">呼吸困难</a>
                            <a href="">腋窝痛</a>-->
                        </div>
                    </form>
                </div>
                

                       
                
                <!--人体部位图 开始-->
                <div class="sympt-chose">
                    <h4><img src="/images/ins_wrt3.png"/ ></h4>
                    <!--男性身体部位 开始-->
                    <div class="boside mpl clearfix">
                        <div class="male-posit fl">
                            <div class="six-parts">
                                <a href="javascript:void(0);" data-partid="0" target="_self" class="head" title="头"></a>
                                <a href="javascript:void(0);" data-partid="15" target="_self" class="chest" title="胸"></a>
                                <a href="javascript:void(0);" data-partid="4" target="_self" class="abdomin" title="腹部"></a>
                                <a href="javascript:void(0);" data-partid="18" target="_self"  class="reprodu" title="男性生殖"></a>
                                <a href="javascript:void(0);" data-partid="14" target="_self" class="upper-limbs" title="上肢"></a>
                                <a href="javascript:void(0);" data-partid="11" target="_self" class="lower-limbs" title="下肢"></a>
                                <div class="mals">
                                    <a href="javascript:void(0);" data-partid="2" title="头">头</a>
                                    <a href="javascript:void(0);" data-partid="0" title="脑">脑</a>
                                    <a href="javascript:void(0);" data-partid="3" title="眼">眼</a>
                                    <a href="javascript:void(0);" data-partid="0" title="咽喉">咽喉</a>
                                    <a href="javascript:void(0);" data-partid="8" title="鼻">鼻</a>
                                    <a href="javascript:void(0);" data-partid="16" title="耳">耳</a>
                                    <a href="javascript:void(0);" data-partid="6" title="口">口</a>
                                    <a href="javascript:void(0);" data-partid="0" title="面部">面部</a>
                                </div>                    
                                <i></i>  
                            </div>
                        </div>
                        <div class="male-oppos fl">
                            <div class="seven-parts">
                                <a href="javascript:void(0);" data-partid="17" target="_self" class="neck" title="颈"></a>
                                <a href="javascript:void(0);" data-partid="1" target="_self" class="whole" title="全身"></a>
                                <a href="javascript:void(0);" data-partid="0" target="_self" class="back" title="背部"></a>
                                <a href="javascript:void(0);" data-partid="0" target="_self" class="bone" title="骨"></a>
                                <a href="javascript:void(0);" data-partid="0" target="_self" class="pelvic" title="盆腔"></a>
                                <a href="javascript:void(0);" data-partid="7" target="_self" class="waist" title="腰"></a>
                                <a href="javascript:void(0);" data-partid="0" target="_self"  class="hip" title="臀部"></a>
                                <a href="javascript:void(0);" data-partid="1" target="_self" class="wmb71" title="全身"></a>
                                <i></i>
                            </div>
                        </div>
                    </div>
                    <!--男性身体部位 结束-->
                    
                    <!--女性身体部位 开始-->
                    <div class="boside opl clearfix" style="display:none;">
                        <div class="female-posit fl">
                            <div class="msix-parts">
                                <a href="javascript:void(0);" target="_self" class="head" title="头"></a>
                                <a href="javascript:void(0);" target="_self" class="upper-limbs" title="肢"></a>
                                <a href="javascript:void(0);" target="_self" class="chest" title="胸"></a>
                                <a href="javascript:void(0);" target="_self" class="abdomin" title="腹部"></a>
                                <a href="javascript:void(0);" target="_self"  class="reprodu" title="女性生殖"></a>
                                <a href="javascript:void(0);" target="_self" class="lower-limbs" title="下肢"></a>
                                <a href="javascript:void(0);" target="_self" class="wmb72" title="全身"></a>
                                <div class="mals">
                                    <a href="javascript:void(0);" data-partid="2" title="头">头</a>
                                    <a href="javascript:void(0);" data-partid="0" title="脑">脑</a>
                                    <a href="javascript:void(0);" data-partid="3" title="眼">眼</a>
                                    <a href="javascript:void(0);" data-partid="0" title="咽喉">咽喉</a>
                                    <a href="javascript:void(0);" data-partid="8" title="鼻">鼻</a>
                                    <a href="javascript:void(0);" data-partid="16" title="耳">耳</a>
                                    <a href="javascript:void(0);" data-partid="6" title="口">口</a>
                                    <a href="javascript:void(0);" data-partid="0" title="面部">面部</a>
                                </div>
                                <i></i>
                            </div>
                        </div>
                        <div class="female-oppos fl">
                            <div class="mseven-parts">
                                <a href="javascript:void(0);" data-partid="17" target="_self" class="neck" title="颈"></a>
                                <a href="javascript:void(0);" data-partid="1" target="_self" class="whole" title="全身"></a>
                                <a href="javascript:void(0);" data-partid="0" target="_self" class="back" title="背部"></a>
                                <a href="javascript:void(0);" data-partid="0" target="_self" class="bone" title="骨"></a>
                                <a href="javascript:void(0);" data-partid="12" target="_self" class="pelvic" title="盆腔"></a>
                                <a href="javascript:void(0);" data-partid="7" target="_self" class="waist" title="腰"></a>
                                <a href="javascript:void(0);" data-partid="0" target="_self"  class="hip" title="臀部"></a>
                                <a href="javascript:void(0);" data-partid="1" target="_self" class="wmb71" title="全身"></a>
                                <i></i>
                            </div>
                        </div>
                    </div>
                    <!--女性身体部位 结束-->
                    
                    <div class="climok clearfix">
                        <a href="javascript:void(0);" class="allmot">全部症状</a>
                        <a href="javascript:void(0);" class="nanmot" target="_self">女性 <i></i></a>
                        <a href="javascript:void(0);" class="mok" target="_self" style="display:none;">男性<i></i></a>
                    </div>
                </div>
                <!--人体部位图 结束-->
            </div>
            <div id="error"></div>
        </div>
        
        
        <div class="hauman h442" id="allPart" style="display:none;">
            <div class="retur-body"><a href="javascript:void(0);" class="huko">返回人体部位图</a><span>头部症状</span></div>
            <div class="allparts clearfix">
                
                <div class="one-level fl">
                    <a  href="javascript:0;" id="down-arrow" ></a>
                    <div class="oksu">
                        <div class="smain-parts">
                            <?php
                            $i=0;
                            unset($model['allPartLevel1'][0]);
                            foreach($model['allPartLevel1'] as $k=>$v){
                                if($i==0){
                                    $class = ' class="on"';
                                }else{
                                    $class = '';
                                }
                                $partname = $v['name'];
                                $partid = $v['id'];
                            ?>
                            <li<?=$class?>><a href="javascript:void(0);" data-partid='<?=$partid?>'><?=$partname?></a></li>
                            <?php
                            $i++;
                            }
                            ?>
                        </div>
                    </div>
                    <a href="javascript:0;" id="up-arrow"></a>
                </div>
                
                <div id="allPart2" class="second-level fl">
                    <ul class="small-parts" style="display:block;">
                    </ul>
                </div>
                
                <div id="allPart3" class="third-level fl">
                    <ul class="third-parts">
                    </ul>
                </div>
                
            </div>
        </div>
        
        
        <!--关键词搜索结果开始-->
        <div class="hauman" id="searchContent" style="display: none;">
            <div class="retur-body"><a href="javascript:void(0);" class="huko">返回人体部位图</a><span>搜索结果</span></div>
            <div class="lett-tab-c f12 clearfix" id="result">
                <div class="hotwor">
                    
                </div>
                <div class="hag" style="display: none;">
                    <h4>非常抱歉，没有找到 “<span></span>”相关的症状</h4>
                    <h3>建议您：</h3>
                    <p>· 换更加常用的关键字。</p>
                    <p>· 去 “<a href="javascript:void(0);showAllSymptom();">全部症状</a>”看看。</p>
                </div>

            </div>
        </div>
        <!--关键词搜索结果结束--> 
        
        <!--查询结果开始-->
        <div class="hauman" id="queryResult" style="display: none;">
            
        </div>
        <!--查询结果结束-->
        
    </div>
</div>
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery.cookie/1.4.1/jquery.cookie.min.js"></script>
<script type="text/javascript" src="/js/checkbody/step2.js"></script>