<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;

$diseaseName = $disease['name'];
$this->title = "${diseaseName}_${diseaseName}的症状_${diseaseName}治疗方法_${diseaseName}用药_疾病百科_久久健康网";
$this->params['keywords'] = "${diseaseName},${diseaseName}的症状,${diseaseName}治疗方法,${diseaseName}用药";
$this->params['description'] = "久久健康网-疾病百科频道提供专业、全面的${diseaseName}、${diseaseName}的症状、${diseaseName}治疗方法、${diseaseName}用药等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
$this->params['name'] = $disease['name'];
?>
<?php echo $this->render('inc_nav', ['pinyin_initial' => $disease['pinyin_initial']]); ?>
<article class="spnic"><h3><?php echo $disease['name']; ?>
        <span>
            <?php
            if (isset($disease['alias'])) {
                echo '（别名：';
                echo $disease['alias'];
                echo '）';
            }
            ?>
        </span>
    </h3>
    <div class="imarr">
        <?php
        $imageUrl = '/images/dise_02.jpg';
        if (isset($disease['thumb']) && !empty($disease['thumb'])) {
            $imageUrl = $disease['thumb'];
        }
        ?>
        <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/tuji/', true) ?>">
            <img src="<?php echo $imageUrl; ?>" alt="<?php echo $disease['name']; ?>图集">
            <span>更多图集</span>
        </a>
        <p><?php echo String::cutString($disease['description'], 50); ?><a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/jianjie/', true) ?>"><span></span>查看更多</a></p>
    </div>
</article>

<article class="bocon compl basic espe">
    <p>易感人群：<span><?php echo $disease['yiganrenqun']; ?></span></p>
    <p>发病部位：<span>
            <?php
            if (isset($disease['part']) && !empty($disease['part'])) {
                $len = 0;
                $max = 14;
                foreach ($disease['part'] as $part) {
                    $currentLen = $len + mb_strlen($part['name'], 'utf-8');
                    if ($currentLen > $max) {
                        ?>
                        <a href="/jbzz/<?php echo $part['pinyin']; ?>/" title="<?php echo $part['name']; ?>">
                        <?php echo \librarys\helpers\utils\String::cutString($part['name'], $max - $len, 0); ?>
                        </a>
                        <?php
                        break;
                    } else {
                        ?>
                        <a href="/jbzz/<?php echo $part['pinyin']; ?>/" title="<?php echo $part['name']; ?>"><?php echo $part['name']; ?></a>
                        <?php
                    }
                    $len = $currentLen;
                }
            }
            ?>
        </span></p>
    <p>挂号科室：<span>
            <?php
            if (isset($disease['department']) && !empty($disease['department'])) {
                foreach ($disease['department'] as $department) {
                    ?>
                    <a href="/jbzz/<?php echo $department['pinyin']; ?>/"><?php echo $department['name']; ?></a>
                    <?php
                }
            } else {
                echo '暂无';
            }
            ?>
        </span></p>
    <p>典型症状：<span>
            <?php
            if (isset($disease['tsymptom']) && !empty($disease['tsymptom'])) {
                $len = 0;
                $max = 12;
                foreach ($disease['tsymptom'] as $symptom) {
                    $currentLen = $len + mb_strlen($symptom['name'], 'utf-8');
                    if ($currentLen > $max) {
                        ?>
                        <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/" title="<?php echo $symptom['name']; ?>">
                        <?php echo \librarys\helpers\utils\String::cutString($symptom['name'], $max - $len, 0); ?>
                        </a>...
                        <?php
                        break;
                    } else {
                        ?>
                        <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/" title="<?php echo $symptom['name']; ?>"><?php echo $symptom['name']; ?></a>
                        <?php
                    }
                    $len = $currentLen;
                }
            }
            ?>
        </span></p>
    <p>传染方式：<span><?php echo $disease['chuanranfangshi']; ?></span></p>
    <p>治疗方法：<span><?php echo $disease['treatment']; ?></span></p>
    <p>临床检查：<span><?php echo \librarys\helpers\utils\String::cutString($disease['inspect'], 18); ?></span></p>
    <p>常用药品：<span>
            <?php
            if (isset($disease['medicine']) && !empty($disease['medicine'])) {
                $len = 0;
                $max = 20;
                foreach ($disease['medicine'] as $medicine) {
                    $currentLen = $len + mb_strlen($medicine, 'utf-8');
                    if ($currentLen > $max) {
                        ?>
                        <a  title="<?php echo $medicine; ?>" style="cursor: default">
                        <?php echo \librarys\helpers\utils\String::cutString($medicine, $max - $len, 0); ?>
                        </a>
                        <?php
                        break;
                    } else {
                        ?>
                        <a  title="<?php echo $medicine; ?>" style="cursor: default"><?php echo $medicine; ?></a>
                        <?php
                    }
                    $len = $currentLen;
                }
            }
            ?>
        </span></p>
</article>

<!--疾病首页第一个广告-->
<div class="adv adban">
<?php echo $this->render('ads/index_first_ads'); ?>
</div>

<div class="thre"></div>
<article class="spacu">
    <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/zz/', true) ?>"><img src="/images/sp_01.png" alt="<?php echo $disease['name'] . '症状'; ?>"><h3><?php echo $disease['name']; ?><span>症状</span></h3><p><?php echo String::cutString($disease['symptom'], 36); ?></p><div></div></a>
    <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/by/', true) ?>"><img src="/images/sp_02.png" alt="<?php echo $disease['name'] . '病因'; ?>"><h3><?php echo $disease['name']; ?><span>病因</span></h3><p><?php echo String::cutString($disease['cause'], 36); ?></p><div></div></a>
    <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/yf/', true) ?>"><img src="/images/sp_03.png" alt="<?php echo $disease['name'] . '预防'; ?>"><h3><?php echo $disease['name']; ?><span>预防</span></h3><p><?php echo String::cutString($disease['prevent'], 36); ?></p><div></div></a>
    <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/lcjc/', true) ?>"><img src="/images/sp_04.png" alt="<?php echo $disease['name'] . '检查'; ?>"><h3><?php echo $disease['name']; ?><span>检查</span></h3><p><?php echo String::cutString($disease['inspect'], 36); ?></p><div></div></a>
    <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/zl/', true) ?>"><img src="/images/sp_05.png" alt="<?php echo $disease['name'] . '治疗'; ?>"><h3><?php echo $disease['name']; ?><span>治疗</span></h3><p><?php echo String::cutString($disease['treat'], 36); ?></p><div></div></a>
    <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/yshl/', true) ?>"><img src="/images/sp_06.png" alt="<?php echo $disease['name'] . '护理'; ?>"><h3><?php echo $disease['name']; ?><span>护理</span></h3><p><?php echo String::cutString($disease['food'], 36); ?></p><div></div></a>
    <a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/bfz/', true) ?>"><img src="/images/sp_07.png" alt="<?php echo $disease['name'] . '并发症'; ?>"><h3><?php echo $disease['name']; ?><span>并发症</span></h3><p><?php echo String::cutString($disease['neopathy'], 36); ?></p><div></div></a>
</article>
<div class="thre"></div>

<h2 class="syart"><?php echo $disease['name']; ?><span>知识</span></h2>
<ul class="dica">
    <?php
    if (isset($allReads) && !empty($allReads)) {
        foreach ($allReads as $allReadKey => $allRead) {
            ?>
            <li>
                <dl>
                    <dt><?php echo $allReadKey; ?></dt>
                    <?php
                    if (isset($allRead) && !empty($allRead)) {
                        $i = 0;
                        foreach ($allRead as $k => $read) {
                            if ($i > 1) {
                                break;
                            }
                            ?>
                            <dd>
                                <a href="/<?php echo $read['url']; ?>" title="<?php echo $read['title']; ?>"><?php echo $read['title']; ?></a>
                            </dd>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </dl>
            </li>
            <?php
        }
    }
    ?>
</ul>

<a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/article_list.shtml', true) ?>" class="fimor every"><mark>每日更新！！</mark>点击查看更多<span>&gt;</span></a>
<div class="thre"></div>

<h2 class="syart"><?php echo $disease['name']; ?><span>问答</span></h2>
<ul class="upda">
    <?php
    if (isset($asks['list']) && !empty($asks['list'])) {
        foreach ($asks['list'] as $outerKey => $outerAsk) {
            $ask_title = (isset($outerAsk['ask']) && !empty($outerAsk['ask'])) ? strip_tags($outerAsk['ask']['title']) : '';
            $answer_content = (isset($outerAsk['answer']) && !empty($outerAsk['answer'])) ? strip_tags($outerAsk['answer']['content']) : '';
            ?>
            <li>
                <h3>
                    <span>Q</span>
                    <a href="<?php echo \yii\helpers\Url::to('@wapask/id/' . $outerAsk['ask']['id'] . '.html'); ?>" title="<?php echo $ask_title; ?>">
                        <?php
                        echo String::cutString($ask_title, 18);
                        ?>
                    </a>
                </h3>
                <p>
                    <span>A</span>
                    <?php
                    echo String::cutString($answer_content, 40);
                    ?>
                </p>
                <div></div>
            </li>

            <?php
        }
    }
    ?>
</ul>
<a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/zixun/', true) ?>" class="fimor">点击查看更多<span>></span></a>
<div class="thre"></div>

<!-- 免费提问 -->
<?php echo $this->render('inc_free_ask', ['pinyin_initial' => $disease['pinyin_initial']]); ?>
<div class="thre"></div>

<!-- 医生 -->
<?php echo $this->render('index_doctor', ['name' => $disease['name'], 'pinyin_initial' => $disease['pinyin_initial'], 'doctors' => $doctors]); ?>
<div class="thre"></div>

<!-- 医院 -->
<?php echo $this->render('index_hospital', ['name' => $disease['name'], 'pinyin_initial' => $disease['pinyin_initial']]); ?>



<!--<h2 class="syart">手足口病<span>用药</span></h2>
<ul class="blood boxs ndrug"><li><a href=""><img src="/images/dru_01.jpg" alt=""></a><div><h3><a href="">小快克小儿氨酚黄那敏颗粒小儿氨酚黄那敏颗粒小快快小快快</a></h3><p>主治功效：小儿感冒,小儿流行性感冒,流行性感冒，急性上呼吸道感染,呼吸道急性上呼吸道感染,呼吸道</p><p>北京万生药业有限责任公司</p></div></li><li><a href=""><img src="/images/dru_02.jpg" alt=""></a><div><h3><a href="">小快克小儿氨酚黄那敏颗粒小儿氨酚</a></h3><p>主治功效：小儿感冒,小儿流行性感冒,流行性感冒，急性上呼吸道感染,呼吸道急性上呼吸道感染,呼吸道</p><p>北京万生药业有限责任公司</p></div></li><li><a href=""><img src="/images/dru_02.jpg" alt=""></a><div><h3><a href="">小快克小儿氨酚黄那敏颗粒小儿氨酚</a></h3><p>主治功效：小儿感冒,小儿流行性感冒,流行性感冒，急性上呼吸道感染,呼吸道急性上呼吸道感染,呼吸道</p><p>北京万生药业有限责任公司</p></div></li></ul>
<a href="" class="fimor">点击查看更多<span>></span></a>-->
<div class="thre"></div>

<article class="dissy">
    <a href="<?php echo Url::to('/zicha/', true) ?>">
        <p><img src="/images/disc.png"></p>
        <p>病急不再乱投医，<span>马上开始自查&gt;</span></p>
    </a>
</article>

<div class="thre"></div>

<h2>疾病相关</h2>
<div class="redis clearfix">
<?php echo $this->render('inc_disease_related', ['name' => $disease['name'], 'pinyin_initial' => $disease['pinyin_initial']]); ?>
</div>

<div class="apal insad txco">
<?php echo $this->render('ads/common_disease_ads_1'); ?>
</div>

<div class="apal insad">
<?php echo $this->render('ads/common_disease_ads_2'); ?>
</div>
<div class="thre"></div>

