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
<div class="content-one bocon">
    <div class="art_s"> 您所在的位置：
        <a href="http://www.9939.com/" target="_blank">久久健康网</a>>
        <a href="<?=Url::to("@jb_domain")?>/" target="_blank">疾病百科</a>>
        <a href="<?=Url::to("@jb_domain/jbzz/")?>">疾病症状</a>>
        <a><b>疾病自查</b></a>
    </div>
</div>

<div class="content-one informa">
    <div class="mark clearfix">
        <h3 class="fl"></h3>
        <span class="refres fr"><i>重新自查</i></span>
    </div>
    <div class="personal">
        <div class="w689">
            <div class="steps "><img  src="/images/ins_picm2.png"/></div>
            <div class="two-smtoms">
                <div class="sympt-person">
                    <h4><img src="/images/ins_wrt1.png"/ ></h4>
                    <ul class="sympt_man pTsm clearfix">
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
                                <ul class="onhid " style="display:none;">
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
            </div>
        </div>
        <div class="clear"></div>
        <div class="meptoms clearfix">
            <div class="w220 fl">
                <div class="addhmo">
                    <span>已添加症状<a href="javascript:;" class="adchos" target="_self" id="reSelect">重选</a></span>
                    <dl class="addtoms" id="selectSymptom">
                        <dd data-symptomid='<?=$model['selectSymptom']['id']?>'><?=$model['selectSymptom']['name']?></dd>
                    </dl>
                </div>
                <div class="addhmo addrelat">
                    <span>相关症状</span>
                    <dl class="addtoms relatom" id="relSymptom">
                        <?php
                            foreach ($model['relSymptom'] as $v){
                        ?>
                        <dd onclick="addSymptom('relSymptom_<?=$v['rel_symptomid']?>')" id="relSymptom_<?=$v['rel_symptomid']?>"><a href="javascript:void(0);" data-symptomid='<?=$v['rel_symptomid']?>' target="_self"><?=$v['name']?></a><i></i></dd>
                        <?php
                            }
                        ?>
                    </dl>
                </div>
            </div>
            <div class="w974 fl">
                <h4>症状自查结果</h4>
                <ul class="inspect clearix" id="acroll">
                    <?php
                    foreach($model['relDisease'] as $v){
                    ?>
                    <li>
                        <div class="spetit">
                            <h5><a href="/<?=$v['pinyin_initial']?>/" data-id="<?=$v['id']?>"><?=$v['name']?></a><span>疾病</span></h5>
                            <span class="compre">
                                [<a href="/<?=$v['pinyin_initial']?>/by/">病因</a>] 
                                [<a href="/<?=$v['pinyin_initial']?>/zz/">症状</a>] 
                                [<a href="/<?=$v['pinyin_initial']?>/lcjc/">检查</a>] 
                                [<a href="/<?=$v['pinyin_initial']?>/zl/">治疗</a>]
                            </span>
                        </div>
                        <p class="detatxt"><?=String::cutString($v['description'], 130, '...')?>[<a href="/<?=$v['pinyin_initial']?>/jianjie/">查看详情</a>]</p>
                        <div class="possib"><b>可能性：</b><span class="mres"><i class="lbar"></i></span></div>
                    </li>
                    <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/checkbody/step3.js"></script>