<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$disease = $data['disease'];
$topDisease = $data['topDisease'];
?>
<!--第三屏 按科室查疾病 开始-->
<div class="content-one">
    <div class="peopl fl">
        <h2 class="clinc"><span></span>按科室查疾病</h2>
        <div class="comdi nest newn">
            <div class="dislid phisi yanz">
                <a href="/jbzz/neike/" class="indexahover" style="padding:0 21px; border-left:none;">内科</a>
                <a href="/jbzz/waike/">外科</a>
                <a href="/jbzz/erke/">儿科</a>
                <a href="/jbzz/fuchanke/">妇产科</a>
                <a href="/jbzz/pifuke/">皮肤科</a>
                <a href="/jbzz/wuguanke/">五官科</a>
                <a href="/jbzz/xingbingke/">性病科</a>
                <a href="/jbzz/zhongliuke/">肿瘤科</a>
                <a href="/jbzz/chuanranke/">传染科</a>
            </div>
            <?php
            $n=0;
            foreach($disease as $k=>$v){
                $dis = $n==0?' shw':'';
            ?>
            <dl class="hotdis eddi<?=$dis?>"><dt>常见疾病</dt>
                <?php
                foreach($v as $kk=>$vv){
                    $hot = $kk==0?'<div class="hola"></div>':'';
                    if($kk < 60){
                        $diseaseTitle = $vv['name'];
                        $diseaseShortTitle = String::cutString($diseaseTitle, 7, '...');
                        $url = Url::to("@jb_domain/{$vv['pinyin_initial']}/");
                ?>
                <dd><a href="<?=$url?>" title="<?=$diseaseTitle?>"><?=$diseaseTitle?></a><?=$hot?></dd>
                <?php
                    }
                    $n++;
                }
                ?>
            </dl>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="expres fr" style="margin-top:0;">
        <div class="conpa rannu">
            <h3 class="dise">疾病排行榜</h3>
            <ul class="diran">
                <?php
                $n = 0;
                foreach($topDisease as $key=>$val){
                    $num = $n+1;
                    $cls = $n==0 ? ' ranb' : '';
                    $dis = $n==0 ? ' style="display:block;"' : '';
                    
                    $title = $val['name'];
                    $description = $val['description'];
                    $shortDescription = String::cutString($description, 26, '...');
                    $click = $val['click'];
                    $url = Url::to("@jb_domain/{$val['pinyin_initial']}/");
                ?>
                <li>
                    <div class="rand_01<?=$cls?>">
                        <span class="sran"><?=$click?></span>
                        <span class="srt"><?=$num?></span>
                        <a href="<?=$url?>" title="<?=$title?>"><?=$title?></a>
                    </div>
                    <div class="rand_02"<?=$dis?>>
                        <p><?=$shortDescription?><a href="<?=$url?>" title="<?=$title?>">[详细]</a></p>
                    </div>
                </li>
                <?php
                $n++;
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!--第三屏 按科室查疾病 结束-->