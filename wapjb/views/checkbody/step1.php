<?php

use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$options = $model['option'];
$pinyin_initial = '';
?>

<section class="sympt">
    <div class="old yeaid">
        <a>-</a><span></span>
    </div>
    <div class="old teac">
        <a>-</a><span></span>
    </div>
</section>

<article class="prso">
    <div class="btns clearfix">
        <?php
        foreach($options['sex'] as $k=>$v){
        ?>
            <span class="<?=$k==1?'sp_01 sp_01c':'sp_02';?>" data-sex="<?=$k?>" data-val="<?=$v?>"></span>
        <?php
        }
        ?>
    </div>
    <div class="mal" title="男性">
        <div class="m_head" title="头部" data-partid="21"></div>
        <div class="m_upli" title="上肢" data-partid="36"></div>
        <div class="m_brea" title="胸部" data-partid="17"></div>
        <div class="m_tumm" title="腰部" data-partid="27"></div>
        <div class="m_repro" title="生殖" data-partid="6"></div>
        <div class="m_lolim" title="下肢" data-partid="56"></div>
    </div>

    <div class="mal_02 disn" title="男性">
        <div class="m_neck" title="颈部" data-partid="41"></div>
        <div class="m_back" title="背部" data-partid="53"></div>
        <div class="m_bone" title="骨头" data-partid="13"></div>
        <div class="m_waist" title="腰部" data-partid="27"></div>
        <div class="m_hip" title="臀部" data-partid="15"></div>
        <div class="m_body" title="全身" data-partid="4"></div>
    </div>

    <div class="fem_01 disn" title="女性">
        <div class="f_head" title="头部" data-partid="21"></div>
        <div class="f_breas" title="胸部" data-partid="17"></div>
        <div class="f_upli" title="上肢" data-partid="36"></div>
        <div class="f_repro" title="生殖" data-partid="2"></div>
        <div class="f_brea" title="腰部" data-partid="27"></div>
        <div class="f_lolim" title="下肢" data-partid="56"></div>
    </div>

    <div class="fem_02 disn" title="女性">
        <div class="f_neck" title="颈部" data-partid="41"></div>
        <div class="f_bone" title="骨头" data-partid="13"></div>
        <div class="f_back" title="背部" data-partid="53"></div>
        <div class="f_waist" title="腰部" data-partid="27"></div>
        <div class="f_penq" title="盆腔" data-partid="2"></div>
        <div class="f_hip" title="臀部" data-partid="15"></div>
        <div class="f_body" title="全身" data-partid="4"></div>
    </div>
    <a class="fronb">背面</a>
</article>

<article class="arimg">
    <a href="/zicha/" class="persi">人体图</a>
    <a data-url="/zicha/jbzc_zz/">症状列表</a>
</article>
<div class="oubra disn"></div>

<div class="agint age disn">
    <div class="iscanc">
        <a class="acali">取消</a>
        <a class="confo">确定</a>
    </div>
    <div class="plav">
        <?php
        foreach($options['age'] as $k=>$v){
        ?>
            <a data-age="<?=$k?>"><?=$v?></a>
        <?php
        }
        ?>
    </div>
</div>

<div class="agint work disn">
    <div class="iscanc">
        <a class="acali">取消</a>
        <a class="confo">确定</a>
    </div>
    <div class="plav">
        <?php
        foreach($options['job'] as $k=>$v){
        ?>
            <a data-job="<?=$k?>"><?=$v?></a>
        <?php
        }
        ?>
    </div>
</div>
<script>
$(".mal div,.mal_02 div,.fem_01 div,.fem_02 div,.arimg a").click(function(){
    jumpUrl($(this));
});
    
//获取年龄
$(".age .confo").click(function(){
    var user_age='';
    var user_age_val='';
    if($('.age .defs').length > 0){
        user_age = $('.age .defs').attr('data-age');
        user_age_val = $('.age .defs').html();
    }else{
        user_age = $('.age .plav a').eq(0).attr('data-age');
        user_age_val = $('.age .plav a').eq(0).html();
    }
    $(".sympt .yeaid").html('<a data-age="'+user_age+'">'+user_age_val+'</a><span></span>');
});

//获取职业
$(".work .confo").click(function(){
    var user_job='';
    var user_job_val = '';
    if($('.work .defs').length > 0){
        user_job = $('.work .defs').attr('data-job');
        user_job_val = $('.work .defs').html();
    }else{
        user_job = $('.work .plav a').eq(0).attr('data-job');
        user_job_val = $('.work .plav a').eq(0).html();
    }
    $(".sympt .teac").html('<a data-job="'+user_job+'">'+user_job_val+'</a><span></span>');
});

/**
 * 
 * @param {type} ele 当前操作对象
 * @returns {Boolean}
 */
function jumpUrl(ele){
    var user_sex='';
    var user_age='';
    var user_job='';
    var user_sex_val='';
    //获取性别
    user_sex = $(".btns .sp_01c").attr('data-sex');
    user_sex = user_sex == undefined ? 0 : user_sex;
//    console.log(user_sex);
//    return false;
    user_sex_val = $(".btns .sp_01c").attr('data-val');
    //获取年龄
    user_age = $(".sympt .yeaid a").attr('data-age');
    //获取职业
    user_job = $('.sympt .teac a').attr('data-job');
    
    var partid = $(ele).attr("data-partid");
    var partname = $(ele).attr("title");
    var url = $(ele).attr("data-url");
    if(url!==undefined){
        url = $(ele).attr("data-url");
        window.location.href = url + '?sex='+user_sex+'&age='+user_age+'&job='+user_job;
    }else{
        url = "/zicha/jbzc_zz/?partid="+partid;
        window.location.href = url + '&sex='+user_sex+'&age='+user_age+'&job='+user_job;
    }
    return false;
}

//初始化
$(".age .confo").click();
$(".work .confo").click();
</script>