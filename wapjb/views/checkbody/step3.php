<?php

use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$options = $model['option'];
$condition = $model['condition'];
$pinyin_initial = '';
$selectSymptom = $model['selectSymptom']['name'];
?>
<!--slide滚动-->
    <script type="text/javascript" src="/js/jquery.event.drag-1.5.min.js"></script>
    <script type="text/javascript" src="/js/jquery.touchSlider.js"></script>
    <script src="/js/slide.js"></script>
<!--ends-->
<article class="fasnv" data-sex="<?=$condition['sex']?>" data-age="<?=$condition['age']?>" data-job="<?=$condition['job']?>">
    <?=$options['job'][$condition['job']]?>（<?=$options['sex'][$condition['sex']]?>，<?=$options['age'][$condition['age']]?>）
</article>
<div class="thre"></div>
<article class="isno icom confir bolcy">是否出现以下症状<a id="submit">确定</a></article>

<article class="isno pablo pressu boli disn">
    <div class="spfi_01"></div>
    <div class="spfi_02"></div>
</article>

<article class="clsa regul patie disax spdi bolcy cusyp">
    <a class="cus" data-symptomid='<?=$model['selectSymptom']['id']?>'><?=$selectSymptom?></a>
    
    <?php
        foreach ($model['relSymptom'] as $v){
    ?>
    <a id="relSymptom_<?=$v['rel_symptomid']?>" data-symptomid='<?=$v['rel_symptomid']?>'><?=$v['name']?></a>
    <?php
        }
    ?>
</article>

<div class="thre"></div>

<h3 class="mayb">可能的患病结果</h3>

<section class="sechoi">
    	<ul class="ache">
            <?php
            foreach($model['relDisease'] as $v){
            ?>
            
            <li>
                <h3>
                    <b class="ac_01">病</b>
                    <p>
                        <a href="/<?=$v['pinyin_initial']?>/" title="<?=$v['name']?>" target="_blank"><?=$v['name']?></a>
                        <?php if(isset($v['alias'])){?><span>（别名：<?=$v['alias']?>）</span><?php }?>
                    </p>
                </h3>
                <div class="simg">
                    <?php
                    if(isset($v['img'])){
                        $img = $v['img']['name'];
                    }else{
                        $img = '/images/ache.jpg';
                    }
                    ?>
                    <a href="/<?=$v['pinyin_initial']?>/jianjie/" title="<?=$v['name']?>"><img src="<?=$img?>" alt="<?=$v['name']?>"></a>
                    <p>
                        <?=String::cutString($v['description'], 45, '...')?>
                        <a href="/<?=$v['pinyin_initial']?>/jianjie/"><span>...</span>查看更多</a>
                    </p>
                </div>
                <div class="sprea">
                    <a href="/<?=$v['pinyin_initial']?>/by/">病因</a>
                    <a href="/<?=$v['pinyin_initial']?>/zz/">症状</a>
                    <a href="/<?=$v['pinyin_initial']?>/lcjc/">检查</a>
                    <a href="/<?=$v['pinyin_initial']?>/zl/">治疗</a>
                </div>
            </li>
            <?php
            }
            ?>
        
        </ul>

        <div class="lasp">
            <?php echo $model['paging']->view();?>
        </div>
    </section>

<div class="thre"></div>

<ul class="askan">
    <?php
    foreach ($model['questions'] as $k => $v) {
        $answer = array_key_exists('answer', $v) ? (empty($v['answer']['content']) ? $v['answer']['suggest'] : $v['answer']['content']) : '暂无回复';
        $askTitle = str_replace($selectSymptom, "<span>{$selectSymptom}</span>", $v['ask']['title']);
        $answerContent = String::cutString($answer, 50, '...');
        $askUrl = 'http://ask.9939.com/id/' . $v['ask']['id'];
        
        $doctorid = $v['doctor']['uid'];
        $doctor = $v['doctor']['truename'] ? $v['doctor']['truename'] : $v['doctor']['nickname'];
        $zhicheng = $v['doctor']['zhicheng'];
        $avatar = $v['doctor']['pic'] ? Url::to('@community/upload/pic/'.$v['doctor']['pic']) : Url::to('@community/upload/pic/'.'default.jpg');
    ?>
        <li>
            <h3><q><?=$askTitle?></q></h3>
            <div class="spabs">
                <h4><img src="<?=$avatar?>" alt="<?=$doctor?>"><b><?=$doctor?></b><span><?=$zhicheng?></span></h4>
                <p><?=$answerContent?></p>
                <a href="http://wapask.9939.com/ask/doctor/<?=$doctorid?>" class="ask">向TA提问</a>
            </div>
        </li>
    <?php
    }
    ?>
</ul>

<a href="/zhengzhuang/<?=$model['selectSymptom']['pinyin_initial']?>/" class="mout">查看<span><?=$selectSymptom?></span>症状&nbsp;></a>

<div class="thre"></div>

<article class="dissy"><a href="/zicha/"><p><img src="/images/disc.png"></p><p>病急不再乱投医，<span>马上开始自查&gt;</span></p></a></article>

<div class="thre"></div>

<article class="exname">
    <div class="expin"><a href="http://wapask.9939.com/ask/goAskDoctor"><img src="/images/logre.png" alt=""></a><p>专家与您一对一答疑</p><p><span>免费提问</span>及时解答</p></div>
    <a href="http://wapask.9939.com/ask/goAskDoctor">
        <div class="eimg">
            <img src="/images/rexp_01.jpg" alt="">
            <img src="/images/rexp_02.jpg" alt="">
            <img src="/images/rexp_03.jpg" alt="">
            <img src="/images/rexp_04.jpg" alt="">
            <img src="/images/rexp_05.jpg" alt="">
        </div>
    </a>
</article>

<div class="thre"></div>

<h2>相关热搜</h2>
<div class="apal">
    <?php echo $this->render('ad_step3_xgrs');?>
</div>

<div class="thre"></div>

<?php echo $this->render('/include/hot_pic');?>


<!--广告位-->
<div class="adv">
    <?php echo $this->render('ad_step3_rttj');?>
</div>

<div class="thre"></div>

<?php echo $this->render('/include/health_assistant');?>

<?php echo $this->render('/include/footer');?>
<script>
$("#submit").click(function(){
    var arrayObj = [];
    var index = 0;
    $(".cusyp .cus").each(function(){
        var symptomid = $(this).attr("data-symptomid");
        var symptomname = $(this).html();
        var symptomArr = [symptomid, symptomname];
        arrayObj[index] = symptomArr;
        index++;
    });
//    console.log(arrayObj);
    var str = '';
    for(i=0;i<arrayObj.length;i++){
        var cloneSymptomid = arrayObj[i][0];
        var cloneSymptomname = arrayObj[i][1];
        var num = i+1;
        str += '<span data-symptomid="'+ cloneSymptomid +'">'+ cloneSymptomname +'</span>';
        if( num < arrayObj.length ){
            str += '<b>，</b>\n';
        }
    }
    $(".spfi_01").html(str);
    showDisease(1);
//    console.log(str);
});

function turnpage(page, obj){
    showDisease(page);
}

function showDisease(page){
    var symptomid = '';
    var pagenum = 1;
    if($(".spfi_01 span").length > 0){
        $(".spfi_01 span").each(function(){
            symptomid += $(this).attr('data-symptomid')+'|';
        });
    }else{
        symptomid = $(".cusyp .cus").attr('data-symptomid')+'|';
    }
    
    if(page !== 'undefined' || page !== ''){
        pagenum = page;
    }
    
    $.ajax({
        type: 'post',
        url: '/zicha/query/',
        data: {'type':4, 'symptomid':symptomid, 'page':pagenum},
        dataType: 'html',
        beforeSend: function(){
            $(".sechoi").html('<li><a href="javascript:void(0);" target="_self">加载中...</a></li>');
        },
        success: function(data){
            $(".sechoi").html(data);
            click_scroll();
        },
        error: function(){}
    });
}

function click_scroll() {
    var scroll_offset = $(".mayb").offset();  //得到pos这个div层的offset，包含两个值，top和left
    $("body,html").animate({
        scrollTop:scroll_offset.top  //让body的scrollTop等于pos的top，就实现了滚动
    },0);
}
</script>