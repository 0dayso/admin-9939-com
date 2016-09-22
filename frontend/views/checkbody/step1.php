<?php

use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$options = $model['option'];
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
    <div class="mark clearfix"><h3></h3></div>
    <div class="personal cobox">
        <div class="w689">
            <div class="steps"><img  src="/images/ins_picm0.png"/></div>
            <ul class="meau clearfix">
                <li>填写你的个人信息，这样将使你的自查结果更加准确。</li>
                <li><b>性别：</b>
                    <div class="select  hT7 fl">
                        <?php
                        foreach($options['sex'] as $k=>$v){
                        ?>
                            <span class="<?=$k==1?'man move':'women';?> fl" data-sex="<?=$k?>"><a href="javascript:void(0);"><?=$v?></a></span>
                        <?php
                        }
                        ?>
                    </div>
                </li>
                
                <li><b>年龄：</b>
                    <div class="age  hT2 clearfix fl">
                        <p class="set" data-age='0'>一个月内</p>
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
                    <div class="profess hT2 clearfix  fl">
                        <p class="currmd" data-job='1'>工人</p>
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
                    <p class="annot cor666 fl">填写职业让您的结果更准确</p>
                </li>
                <li><a href="javascript:void(0);" target="_self" id="start"><img  src="/images/ins_check.gif"/></a></li>
                <form action="/zicha/jbzc_zz/" method="get" name="dataForm" id="dataForm" target="_self">
                    <input type="hidden" id="sex" name="sex" value="">
                    <input type="hidden" id="age" name="age" value="">
                    <input type="hidden" id="job" name="job" value="">
                </form>
            </ul>
        </div>
    </div>
</div>
<!--底部 -->

<script>
//$(function(){
    $('#start').click(function(){
        if( getCheckData() ){
           $('#dataForm').submit();
        }else{
            alert('条件不完整');
        }
    });
    
    //禁止点击性别字
    $('.select').find('a').click(function(){
        return false;
    });

    $('.select .women a').click(function () {
        $(".man").removeClass("move")
        $(".women").addClass("move")
    });  
    $('.select .man a').click(function () {
        $(".women").removeClass("move")
        $(".man").addClass("move")
    });
//});

function getCheckData(){
    var user_sex=user_age=user_job='';
    //获取性别数据
    $('.select span').each(function(){
       that = $(this);
       if(that.hasClass('move')){
           user_sex = that.attr('data-sex');
       }
    });
    
    //获取年龄
    user_age = $('.age .set').attr('data-age');
    
    //获取职业
    user_job = $('.profess p.currmd').attr('data-job');
    
    if(user_sex=='' || user_age=='' || user_job==''){
        return false;
    }else{
        $("#sex").val(user_sex);
        $("#age").val(user_age);
        $("#job").val(user_job);
        return true;
    }
}

</script>