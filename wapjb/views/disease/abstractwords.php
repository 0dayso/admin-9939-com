<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;

$diseaseName = $disease['name'];
$this->title = "${diseaseName}的病因_症状_治疗_饮食_护理_图片_疾病百科_久久健康网";
$this->params['keywords'] = "${diseaseName}的病因,${diseaseName}的症状,${diseaseName}治疗方法,${diseaseName}饮食,${diseaseName}图片";
$this->params['description'] = "久久健康网-疾病百科频道提供专业、全面的${diseaseName}的病因、${diseaseName}的症状、${diseaseName}治疗方法、${diseaseName}饮食、${diseaseName}图片等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！";
$this->params['name'] = $diseaseName;
?>
<?php echo $this->render('inc_nav', ['pinyin_initial' => $disease['pinyin_initial']]); ?>

<article class="bocon compl shagin diacl">
    <h3><?php echo $disease['name']; ?><span>简介</span></h3>
    <p class="inde"><?php echo str_replace(PHP_EOL, "</p><p style='text-indent:2em'>", $disease['description']); ?></p>
    <a class="shic">分享</a>
</article>
<!--分享-->
<?php echo $this->render('/include/share', ['title' => $this->title]); ?>

<a href="javascript:void(0)" class="agmor climo">点击查看更多</a>

<article class="bocon compl basic">
    <h3><?php echo $disease['name']; ?><span>基本知识</span></h3>
    <p>别名：<span><?php echo $disease['alias']; ?></span>
    <p>是否属于医保：<span>暂无</span>
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
        </span>
    <p>传染性：<span><?php echo $disease['chuanranxing']; ?></span>
    <p>传播途径：<span><?php echo $disease['chuanranfangshi']; ?></span>
    <p>多发人群：<span><?php echo $disease['yiganrenqun']; ?></span>
    <p class="unsy"><span>典型症状：</span><span>
            <?php
            if (isset($disease['tsymptom']) && !empty($disease['tsymptom'])) {
                $len = 0;
                $max = 20;
                foreach ($disease['tsymptom'] as $symptom) {
                    $currentLen = $len + mb_strlen($symptom['name'], 'utf-8');
                    if ($currentLen > $max) {
                        ?>
                        <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/" title="<?php echo $symptom['name']; ?>">
                            <?php echo \librarys\helpers\utils\String::cutString($symptom['name'], $max - $len, 0); ?>
                        </a>
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
        </span>
    <p class="unsy"><span>相关疾病：</span><span>
            <?php
            if (isset($disease['reldis']) && !empty($disease['reldis'])) {
                $len = 0;
                $max = 20;
                foreach ($disease['reldis'] as $reldisease) {
                    $currentLen = $len + mb_strlen($reldisease['name'], 'utf-8');
                    if ($currentLen > $max) {
                        ?>
                        <a href="/<?php echo $reldisease['pinyin_initial']; ?>/" title="<?php echo $reldisease['name']; ?>">
                            <?php echo \librarys\helpers\utils\String::cutString($reldisease['name'], $max - $len, 0); ?>
                        </a>
                        <?php
                        break;
                    } else {
                        ?>
                        <a href="/<?php echo $reldisease['pinyin_initial']; ?>/" title="<?php echo $reldisease['name']; ?>"><?php echo $reldisease['name']; ?></a>
                        <?php
                    }
                    $len = $currentLen;
                }
            }
            ?>
        </span></p>
</article>
<article class="bocon compl basic">
    <h3><?php echo $disease['name']; ?><span>诊疗知识</span></h3>
    <p>就诊科室：<span>
            <?php
            if (isset($disease['department']) && !empty($disease['department'])) {
                foreach ($disease['department'] as $department) {
                    ?>
                    <a href="/jbzz/<?php echo $department['pinyin']; ?>/"><?php echo $department['name']; ?></a>
                    <?php
                }
            } else {
                ?>
                暂无
                <?php
            }
            ?>
        </span>
    <p>治疗方法：<span><?php echo $disease['treatment']; ?></span>
    <p>常用药品：<span>
            <?php
            if (isset($disease['medicine']) && !empty($disease['medicine'])) {
                foreach ($disease['medicine'] as $medicine) {
                    ?>
                    <a ><?php echo $medicine; ?></a>
                    <?php
                }
            }
            ?>
        </span>
</article>
<a href="<?php echo Url::to('/' . $disease['pinyin_initial'] . '/'); ?>" class="fimor resea">返回疾病<span>&gt;</span></a>
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

<!-- 免费提问 -->
<?php echo $this->render('inc_free_ask', ['pinyin_initial' => $disease['pinyin_initial']]); ?>


<div class="thre"></div>



