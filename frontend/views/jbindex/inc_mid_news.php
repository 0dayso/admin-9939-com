<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<!--第六屏 疾病资讯 开始-->
<div class="content-one">
    <div class="peopl fl">
        <h2 class="dians diin"><a href="http://jb.9939.com/article_list.shtml" class="morl">更多>></a><span></span>疾病资讯</h2>
        <ul class="akna donp" id="diseaseArticle">
            <?php
            if(isset($data['news'])){
                foreach($data['news'] as $k=>$v){
                    $words = $k;
                    $wordsUrl = Url::to("@jb_domain/{$data['newsWords'][$k]['pinyin_initial']}/");
                    if(isset($v['title'])){
                        $title = (new String())->filter_html($v['title']);
                        $shortTitle = String::cutString($title, 17);
                        $newUrl = '/article/'.date("Y/md", $v["inputtime"]).'/'.$v['id'].'.shtml';
                        $newsDate = date("m-d", $v['inputtime']);
                ?>
                    <li>
                        <span class="dat"><?=$newsDate?></span>
                        <div>
                            <span class="circ">[<a href="<?=$wordsUrl?>" title="<?=$words?>"><?=$words?></a>]</span>
                            <a href="<?=$newUrl?>" title="<?=$title?>"><?=$title?></a>
                        </div>
                    </li>
            <?php
                    }else{
            ?>
                    <li>
                        <span class="dat"></span>
                        <div>
                            <span class="circ">[<a href="<?=$wordsUrl?>" title="<?=$words?>"><?=$words?></a>]</span>
                        </div>
                    </li>
            <?php
                    }
                }
            }
            ?>
        </ul>
        <dl class="selte">
            <dt><img src="/images/tes_01.png"></dt>
            <dd><div><img src="/images/tes_02.png"></div><a href="http://jb.9939.com/article/2015/1126/343668.shtml">阳萎自测</a></dd>
            <dd><div><img src="/images/tes_03.png"></div><a href="http://man.9939.com/jkcs/byzc/2015/0306/1733702.shtml">男性不育</a></dd>
            <dd><div><img src="/images/tes_04.png"></div><a href="http://tijian.9939.com/rqtj/tjdt/2016/0106/2140452.shtml">女性不孕</a></dd>
            <dd><div><img src="/images/tes_05.png"></div><a href="http://fitness.9939.com/ysjf/jfsp/2016/0111/2145872.shtml">减肥自测</a></dd>
            <dd><div><img src="/images/tes_06.png"></div><a href="http://xinli.9939.com/xlcs/zhcs/2016/0126/2236318.shtml">智商测试</a></dd>
            <dd><div><img src="/images/tes_07.png"></div><a href="http://lady.9939.com/mr/hfyy/jchf/2015/0914/1755692.shtml">肤质测试</a></dd>
            <dd><div><img src="/images/tes_08.png"></div><a href="http://baby.9939.com/yqzb/hycs/2015/0715/1750118.shtml">怀孕自测</a></dd>
            <dd><div style="padding-top:7px;"><img src="/images/tes_09.png"></div><a href="http://lx.9939.com/xbj/fqxbbj/2015/1127/1888889.shtml" style="margin-top:3px;">痛经自测</a></dd>
            <dd><div><img src="/images/tes_10.png"></div><a href="http://baojian.9939.com/yjk/2012/0618/1563125.shtml">健康状况</a></dd>
        </dl>
    </div>
    <div class="expres riclu fr">
        <div class="conpa">
            <h3 class="dise">资讯排行榜</h3>
            <ul class="inran tcar">
                <?php
                foreach($data['top'] as $k=>$v){
                    $num = $k+1;
                    $url = $v['url'];
                    $title = $v['title'];
                ?>
                <li><div class="rand_01"><span class="srt"><?=$num?></span><a href="<?=$url?>" title="<?=$title?>"><?=$title?>?</a></div></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!--第六屏 疾病资讯 结束-->
