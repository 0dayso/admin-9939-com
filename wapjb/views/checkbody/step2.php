<?php

use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$options = $model['option'];
$condition = $model['condition'];
$pinyin_initial = '';
?>
<article class="fasnv" data-sex="<?=$condition['sex']?>" data-age="<?=$condition['age']?>" data-job="<?=$condition['job']?>">
    <?=$options['job'][$condition['job']]?>（<?=$options['sex'][$condition['sex']]?>，<?=$options['age'][$condition['age']]?>）
</article>
<div class="thre"></div>
<article class="pale">
    <ul class="spla headis">
        <?php
        $level1Map = [
            17 => '胸部',
            4 => '全身',
            21 => '头部',
            41 => '颈部',
            9 => '腹部',
            27 => '腰部',
            15 => '臀部',
            6 => '男性生殖',
            2 => '女性生殖',
            36 => '上肢',
            56 => '下肢',
        ];
        ?>
        <?php
        $curpartid = $condition['partid'];
        foreach($level1Map as $k=>$v){
            if( array_key_exists($curpartid, $model['allPartLevel2']) ){
                $curpartid = $model['allPartLevel2'][$curpartid]['part_level1'];
            }
            
            if($curpartid == $k){
                $cls = ' class="curs"';
            }else{
                $cls = '';
            }
        ?>
        <li<?=$cls?>>
            <div></div>
            <a class="level1_part" href="javascript:void(0);" data-partid="<?=$k?>"><?=$v?></a>
            <span></span>
            <div class="nexsib disn">
                <?php
                foreach($model['allPartLevel2'] as $kk=>$vv){
                    if($vv['part_level1'] == $k){
                        $partname = $vv['name'];
                        $partid = $vv['id'];
                        echo '<a href="javascript:void(0);" data-partid="'.$partid.'">'.$partname.'</a>';
                    }
                }
                ?>
            </div>
        </li>
        <?php
        }
        ?>
        
        
    </ul>
    <div class="plres"></div>
</article>
<a class="retop" href="javascript:scroll(0,0)"></a>
<script type="text/javascript">
init();
//初始化数据
function init(){
    var num = $(".spla li.curs").length;
    if(num < 1){
        $(".spla li").eq(0).addClass("curs");
    }
    
    var curPart = $(".spla li.curs").find("a.level1_part");
    var partid = curPart.attr("data-partid");
    var parttitle = curPart.html();
    getDataByPartId(partid, parttitle);
}

/**
 * 左侧主部位 点击
 */
$(".spla li div,.level1_part").click(function(){
    var partid= $(this).attr("data-partid");
    var parttitle = $(this).html();
    if(partid == 'undefined' || partid == "" || parttitle == "undefined" || parttitle == ""){
        partid = $(this).next().attr("data-partid");
        parttitle = $(this).next().html();
    }
    $(".spla li").removeClass("curs");
    $(this).parent().addClass("curs");
    
    getDataByPartId(partid, parttitle);
    console.log(parttitle);
    return false;
});

/**
 * 左侧主部位 下二级部位 点击
 */
$(".nexsib a").click(function(){
    var partid= $(this).attr("data-partid");
    var parttitle = $(this).html();
    var parentObj = $(this).parent().parent();
    if(!parentObj.hasClass("curs")){
        $(".spla li").removeClass("curs");
        parentObj.addClass("curs");
    }
    
    getDataByPartId(partid, parttitle);
    console.log(partid);
    return false;
});


//症状自查3，症状自查4头部浮动
var def=$('.spla li.curs').offset().top;
$(window).scroll(function(){
    if ($(window).scrollTop() >= def) {
        $('.spla li.curs').addClass('cufix');
    }
    else if ($(window).scrollTop() < def) {
        $('.spla li.curs').removeClass('cufix');
    }
});




function getDataByPartId(partid, parttitle){
    $.ajax({
        type: 'post',
        url: '/zicha/query/',
        data: {'type':3, 'partid':partid, 'partname':parttitle } ,
        dataType: 'html',
        beforeSend: function(){
            $(".plres").html('<img src="http://image.39.net/jbk/new2013/images/loading_02.gif">');
        },
        success: function(data){
            $(".plres").html(data);
        },
        error: function(){}
    });
}


function showDisease(url){
    var user_sex=user_age=user_job='';
    //获取性别数据
    user_sex = $('.fasnv').attr('data-sex');
    //获取年龄
    user_age = $('.fasnv').attr('data-age');
    //获取职业
    user_job = $('.fasnv').attr('data-job');
    window.location.href = url + '&sex='+user_sex+'&age='+user_age+'&job='+user_job;
    return false;
}
</script>
