<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$disease = $data['disease'];
$hotDisease = $data['hotDisease'];
$category = $data['peopleCategory'];
?>
<!--第二屏 按人群查疾病 开始-->
<div class="content-one">
    <div class="peopl fl">
        <h2><span></span>按人群查疾病</h2>
        <div class="comdi">
            <div class="dislid">
                <a class="indexahover" style="padding:0 33px; border-left:none; cursor:default; text-decoration:none;">常见病</a>
                <a href="/jbzz/nanke/">男性</a>
                <a href="/jbzz/fuke/">女性</a>
                <a href="/jbzz/erke/">儿童</a>
                <a style="cursor:default; text-decoration:none;">老人</a>
                <a href="/jbzz/fuke/">孕妇</a>
                <a style="cursor:default; text-decoration:none;">职业病</a>
            </div>
            <?php
            $n=0;
            foreach($category as $k=>$v){
                $dis = $n==0?'':' disn';
            ?>
            <ul class="expsy<?=$dis?>">
                <?php
                foreach($disease[$k] as $kk=>$vv){
                    if($kk < 48){
                        $diseaseTitle = $vv['name'];
                        $diseaseShortTitle = String::cutString($diseaseTitle, 7, '...');
                        $url = Url::to("@jb_domain/{$vv['pinyin_initial']}/");
                ?>
                <li><a href="<?=$url?>" title="<?=$diseaseTitle?>"><?=$diseaseTitle?></a></li>
                <?php
                    }
                    $n++;
                }
                ?>
            </ul>
            <?php
            }
            ?>
            <dl class="hotdis deas"><dt>热门疾病</dt>
                <?php
                foreach($hotDisease as $k=>$v){
                    $diseaseTitle = $v['name'];
                    $diseaseShortTitle = String::cutString($diseaseTitle, 7, '...');
                    $url = Url::to("@jb_domain/{$v['pinyin_initial']}/");
                    echo '<dd><a href="'.$url.'" title="'.$diseaseTitle.'">'.$diseaseTitle.'</a></dd>';
                }
                ?>
            </dl>
        </div>

    </div>
    <div class="expres fr" style="margin-top:0;">
        <div class="conpa expan">
            <h3 class="dise">最近热门科室</h3>
            <div class="provi">
                <a href="/tnb/" title="糖尿病"><img src="/images/clin_01.jpg" alt="糖尿病" title="糖尿病"></a>
                <h4><a href="/tnb/" title="糖尿病">糖尿病</a></h4>
                <p><a href="http://jb.9939.com/sec/1665.shtml" title="内分泌科">内分泌科</a></p><p><a href="http://hospital.9939.com/hosp/19925/index.shtml" title="北京大学人民医院">北京大学人民医院</a></p>
            </div>
            <dl class="reldi">
                <dt><span></span>相关疾病</dt>
                <dd><a href="/tnbsb/" title="糖尿病肾病">糖尿病肾病</a></dd>
                <dd><a href="/tnbz/" title="糖尿病足">糖尿病足</a></dd>
                <dd><a href="/rshbtnb/" title="妊娠合并糖尿病">妊娠合并糖尿病</a></dd>
<!--                <dd><a href="/tnbxsjb/" title="糖尿病性神经病">糖尿病性神经病</a></dd>-->
            </dl>
        </div>
        <div class="conpa cabtop">
            <h3 class="dise">季节高发疾病</h3>
            <div class="provi">
                <a href="/gm/" title="感冒"><img src="/images/clin_02.jpg" alt="感冒" title="感冒"></a>
                <h4><a href="/gm/" title="感冒">感冒</a></h4>
                <p><a href="http://jb.9939.com/sec/1659.shtml" title="内科">内科</a></p><p><a href="http://hospital.9939.com/hosp/272446/index.shtml" title="北京协和医院">北京协和医院</a></p>
            </div>
            <dl class="reldi">
                <dt><span></span>相关疾病</dt>
                <dd><a href="/lxxgm/" title="流行性感冒">流行性感冒</a></dd>
<!--                <dd><a href="/jxqg_zqgy/">急性气管－支气管炎</a></dd>-->
                <dd><a href="/fy/" title="肺炎">肺炎</a></dd>
                <dd><a href="/mxzqgy/" title="慢性支气管炎">慢性支气管炎</a></dd>
            </dl>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!--第二屏 按人群查疾病 结束-->