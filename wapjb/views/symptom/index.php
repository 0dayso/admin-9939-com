<?php

use yii\helpers\Url;

$name = $symptom['info']['name'];
$this->title['title'] = "{$name}的原因_{$name}的表现_{$name}的治疗方法_症状查询_久久健康网";
$this->title['keywords'] = "{$name}的原因,{$name}的表现,{$name}的治疗方法";
$this->title['description'] = "久久健康网-症状查询频道提供专业、全面的{$name}的原因、{$name}的表现、{$name}的治疗方法等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
$this->params['name'] = $symptom['info']['name'];
?>

<?php echo $this->render('inc_nav',['pinyin_initial'=>$symptom['pinyin_initial']]); ?>

<article class="spnic">
    <h3><?php echo $symptom['info']['name']; ?></h3>
    <div class="imarr moim">
        <a href="javascript:;">
            <img src="<?php echo $symptom['thumb']['src']?>" alt="<?php echo $symptom['info']['name']; ?>" title="<?php echo $symptom['info']['name']; ?>">
        </a>
        <p>
            <?php echo \librarys\helpers\utils\String::cutString($symptom['info']['description'], 75); ?>
            <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/zzqy/"><span>...</span>查看更多 </a>
        </p>
    </div>
</article>
<div class="thre"></div>

<h3 class="probal">可能患有的疾病</h3>
<article class="raatu prob">
    <?php
    if(isset($symptom['disease']['relDisease']) && !empty($symptom['disease']['relDisease'])){
        $relDisease = $symptom['disease']['relDisease'];
        foreach($relDisease as $key=>$v){
            $diseaseName = $v['name'];
            $diseasePinyin = $v['pinyin_initial'];
        ?>
            <a href="/<?php echo $diseasePinyin; ?>/" title="<?php echo $diseaseName; ?>">
                <h3><?php echo $diseaseName; ?></h3>
                <p>伴随症状：
                    <?php
                    $diseaseSymptomCustom = $symptom['diseaseSymptomCustom'][$diseasePinyin];
                    foreach ($diseaseSymptomCustom as $k=>$vv) {
                        echo $vv . '&nbsp;';
                    }
                    ?>
                </p>
            </a>
        <?php
        }

    }
    ?>
</article>
<div class="thre"></div>

<article class="spacu cause">
    <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/zzqy/">
        <img src="/images/sp_02.png" alt="">
        <h3>
            <?php echo $symptom['info']['name']; ?>
            <span>病因</span>
        </h3>
        <p><?php echo \librarys\helpers\utils\String::cutString($symptom['symptomContent']['content']['cause'], 17); ?></p>
        <div></div>
    </a>
    <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/yufang/">
        <img src="/images/sp_05.png" alt="">
        <h3>
            <?php echo $symptom['info']['name']; ?>
            <span>预防</span>
        </h3>
        <p><?php echo \librarys\helpers\utils\String::cutString($symptom['symptomContent']['content']['diagnose'], 17); ?></p>
        <div></div>
    </a>
    <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/jiancha/">
        <img src="/images/sp_04.png" alt="">
        <h3>
            <?php echo $symptom['info']['name']; ?>
            <span>检查</span>
        </h3>
        <p><?php echo \librarys\helpers\utils\String::cutString($symptom['symptomContent']['content']['examine'], 17); ?></p>
        <div></div>
    </a>
    <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/shiliao/">
        <img src="/images/sp_07.png" alt="">
        <h3>
            <?php echo $symptom['info']['name']; ?>
            <span>食疗</span>
        </h3>
        <p><?php echo \librarys\helpers\utils\String::cutString($symptom['symptomContent']['content']['goodfood'], 17); ?></p>
        <div></div>
    </a>
</article>
<div class="thre"></div>

<article class="dissy">
    <a href="/zicha/">
        <p>
            <img src="/images/disc.png"></p>
        <p>
            病急不再乱投医，
            <span>马上开始自查></span>
        </p>
    </a>
</article>
<div class="thre"></div>

<h2 class="syart">
    <?php echo $symptom['info']['name']; ?>
    <span>问答</span>
</h2>
<ul class="upda">
    <?php
    foreach ($symptom['questions'] as $k => $v) {
        $answer = array_key_exists('answer', $v) ? (empty($v['answer']['content']) ? $v['answer']['suggest'] : $v['answer']['content']) : '暂无回复';
        $askTitle = $v['ask']['title'];
        $answerContent = $answer;
        $askUrl = 'http://wapask.9939.com/id/' . $v['ask']['id'] . '.html';
        if ($k == 4){
            break;
        }
        ?>
        <li>
            <h3>
                <span>Q</span>
                <a href="<?=$askUrl?>"><?=$askTitle?></a>
            </h3>
            <p>
                <span>A</span>
                <?php echo $answerContent; ?>
            </p>
            <div></div>
        </li>
        <?php
    }
    ?>
</ul>
<a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/zixun/" class="fimor">
    点击查看更多
    <span>></span>
</a>
<div class="thre"></div>

<a class="exname" href="http://wapask.9939.com/ask/goAskDoctor" target="_blank">
    <div class="expin">
        <a href="<?php echo Url::to('@wapask/ask/goAskDoctor');?>">
            <img src="/images/logre.png" alt=""></a>
        <p>专家与您一对一答疑</p>
        <p>
            <span>免费提问</span>
            及时解答
        </p>
    </div>
    <div class="eimg">
        <img src="/images/rexp_01.jpg" alt="">
        <img src="/images/rexp_02.jpg" alt="">
        <img src="/images/rexp_03.jpg" alt="">
        <img src="/images/rexp_04.jpg" alt="">
        <img src="/images/rexp_05.jpg" alt=""></div>
</a>
<div class="thre"></div>

<h2 class="syart">
    <?php echo $symptom['info']['name']; ?>
    <span>文章</span>
</h2>
<article class="male loswei cand">
    <section class="sechoi">
        <ul class="rade">
            <?php
            if(isset($symptom['articles'])){
                foreach($symptom['articles'] as $k=>$v){
                    $articleTitle = $v['title'];
                    $articleUrl = Url::to(["{$v['url']}"]);
                    if ($k == 7){
                        break;
                    }
                    ?>
                    <li><a href="<?=$articleUrl?>" title="<?=$articleTitle?>"><?=$articleTitle?></a></li>
                    <?php
                }
            }
            ?>
        </ul>
        <a href="/article_list.shtml" class="fimor every">
            <mark>每日更新！！</mark>
            点击查看更多
            <span>&gt;</span>
        </a>
    </section>
</article>
<div class="thre"></div>

<h2>症状相关</h2>
<div class="redis clearfix">
    <?php echo $this->render('inc_symptom_related', ['symptom' => $symptom['info']]); ?>
</div>

<div class="apal insad" style="margin-top:-.2rem;">
    <?php echo $this->render('index_first_ads'); ?>
</div>
<div class="apal insad">
    <?php echo $this->render('index_second_ads'); ?>
</div>
<div class="thre"></div>