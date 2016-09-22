<?php
use yii\helpers\Url;
use librarys\helpers\utils\String;

$existLetter = array_keys($model['letterSymptoms']);
//                print_r($existLetter);
//                exit;
//                exit;

$letters = [
                'A','B','C','D','E','F','G','H','I',
                'J','K','L','M','N','O','P','Q','R',
                'S','T','U','V','W','X','Y','Z',
            ];
$partname = $model['partname'].'部症状';
?>

            <div class="retur-body"><a href="javascript:void(0);">返回人体部位图</a><span><?=$partname;?></span></div>
            <div class="letter-sw  lett-tab leume  mT25 clearfix" id="letters">
                <b>字母排序：</b>
                <?php
                foreach($existLetter as $k=>$v){
                ?>
                    <a switc="<?=$v?>" href="javascript:" class="currm <?=$k==0?'move':'';?>"><?=$v?></a>
                <?php
                }
                ?>
            </div>
            <div class="lett-tab-c f12 clearfix" id="result">
                <?php
                foreach($existLetter as $k=>$letter){
                ?>
                <div switc-ass="<?=$letter?>" class="lett-tab-<?=$letter?> hotwor <?=$k!==0?'curro':'';?>">
                    <li>
                    <?php
                    $symptoms = $model['letterSymptoms'];
                    if(in_array($letter, $existLetter) ){
                        $i=1;
                        foreach($symptoms[$letter] as $v){
                            $title = $v['name'];
                            $shortTitle = String::cutString($v['name'], 7, '...');
                            $url = '/zicha/jbzc_jg/?symptomid='.$v['id'];
                            echo '<a href="'.$url.'" title="'.$title.'">'.$shortTitle.'</a>';
                            if($i % 6 == 0 && count($symptoms[$letter]) % 6 !==0){echo '</li><li>';}
                            $i++;
                        }
                    }else{
                        echo '<a href="javascript:void(0);">暂无数据</a>';
                    }
                    ?>
                    </li>
                </div>
                <?php
                }
                ?>
            </div>
<script>
$("#result .hotwor").find('li:odd').css('background','#fafafa'); 
    
$(".lett-tab-c a").click(function(){
    var url = $(this).attr("href");
    var user_sex=user_age=user_job='';
    //获取性别数据
    user_sex = $('.sexdul .currt').attr('data-sex');
    
    //获取年龄
    user_age = $('.age .set').attr('data-age');
    
    //获取职业
    user_job = $('.profess p.currmd').attr('data-job');
    window.location.href = url + '&sex='+user_sex+'&age='+user_age+'&job='+user_job;
    return false;
});
    
//单击查询结果页卡的 返回人体部位图 动作
$(".retur-body a").click(function(){
    $(".sympt-chose").show();
    $("#queryResult").hide();
});
    
$('.currm').click(function () {
    var zimu = $(this).attr('switc');
    var className=".lett-tab-" + zimu;
    $('.move').removeClass('move');
    $(this).addClass('move');
    var div=$(".lett-tab-c").find(className);
    $(".lett-tab-c div").addClass('curro');
    if(div){
        div.removeClass('curro');
    }
}).click(function(){
    return false;
});
</script>