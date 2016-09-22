<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;

$this->title = $disease['name'] . '在线咨询_' . $disease['name'] . '在线预约、挂号_疾病百科_久久健康网';
$this->params['keywords'] = $disease['name'] . '在线咨询,' . $disease['name'] . '在线预约,' . $disease['name'] . '在线挂号';
$this->params['description'] = '久久健康网-疾病百科频道提供专业、全面的' . $disease['name'] . '在线咨询、' . $disease['name'] . '在线预约、' . $disease['name'] . '在线挂号等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
$this->params['name'] = $disease['name'];
?>

<?php echo $this->render('inc_nav', ['pinyin_initial' => $disease['pinyin_initial']]); ?>

<ul class="expert blood doname">
    <?php
    if (isset($doctor) && !empty($doctor)) {
        foreach ($doctor as $k => $v) {
            $truename = $v['truename'] ? : $v['nickname'];
            ?>

            <li>
                <a href="<?php echo Url::to('@wapask/ask/doctor/' . $v['uid']); ?>">
                    <img src="<?php echo Url::to('@community/upload/pic/' . $v['pic']); ?>" alt="<?php echo $truename; ?>">
                </a>
                <div>
                    <h3><a href="<?php echo Url::to('@wapask/ask/doctor/' . $v['uid']); ?>"><?php echo $truename; ?></a><span style="display: none;"><b>问</b><b>挂</b><b>加</b><b>图</b></a></span></h3>
                    <p><?php echo $v['zhicheng']; ?>&nbsp;<?php echo $v['doc_keshi']; ?></p>
                    <p>擅长：<?php echo!empty($v['best_dis']) ? $v['best_dis'] : '暂无'; ?></p>
                </div>
                <em></em>
            </li>

            <?php
        }
    }
    ?>


</ul>
<div class="thre"></div>
<ul class="askan gain">
    <?php echo $this->render('inc_related_ask',['asks'=>$asks]);?>
</ul>
<input type="hidden" name="keywords" id="keywords" value="<?php echo $disease['keywords'];?>">
<input type="hidden" name="total" id="total" value="<?php echo $asks['total'];?>">
<a href="javascript:;" class="fimor">点击查看更多<span>&gt;</span></a>
<div class="thre"></div>
<h2>疾病相关</h2>
<div class="redis clearfix">
    <?php echo $this->render('inc_disease_related', ['name' => $disease['name'], 'pinyin_initial' => $disease['pinyin_initial']]); ?>
</div>

<div class="apal insad" style="margin-top:-.2rem;">
    <?php echo $this->render('ads/common_disease_ads_1');?>
</div>

<div class="apal insad">
    <?php echo $this->render('ads/common_disease_ads_2');?>
</div>

<div class="thre"></div>
<article class="dissy">
    <a href="<?php echo Url::to('/zicha/', true) ?>"><p><img src="/images/disc.png"></p><p>病急不再乱投医，<span>马上开始自查></span></p></a>
</article>
<div class="thre"></div>

<!-- 免费提问-->
<?php echo $this->render('inc_free_ask', ['pinyin_initial' => $disease['pinyin_initial']]); ?>
<div class="thre"></div>
<script type="text/javascript" src="<?php echo Url::to('/js/disease/load_more.js') ?>"></script>

