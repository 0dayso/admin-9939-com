<?php

use yii\helpers\Url;
use yii\helpers\StringHelper;

$right = $this->context->right;
$disease = $right['disease'];
$symptom_rel = $right['symptom_rel'];
$disease_rel = $right['disease_rel'];
$expert = $right['expert'];
?>
<!-- 首页 右侧 部分 -->
<div class="rw298 rdisea">
    <!--右上角广告-->
    <div class="clumn mTop">
        <?php echo $this->render('/ads/common/ads_tr'); ?>
    </div>
    <!--右上角广告-->

    <div class="build one">
        <h4 class="gre-arrow">相关症状</h4>
        <div class="one-block btline mT18">
            <ul class="one-label clearfix">
                <?php
                if (!empty($symptom_rel)) {
                    foreach ($symptom_rel as $k => $v) {
                        if ($k < 15) {
                            echo '<li><a href="' . Url::to('/zhengzhuang/' . $v["pinyin_initial"] . '/') . '" title="' . $v["name"] . '">' . $v["name"] . '</a></li>';
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="build one">
        <h4 class="gre-arrow">相关疾病</h4>
        <div class="one-block btline mT18">
            <ul class="one-label clearfix">
                <?php
                if (!empty($disease_rel)) {
                    foreach ($disease_rel as $k => $v) {
                        if ($k < 15) {
                            echo '<li><a href="' . Url::to('/' . $v["pinyin_initial"] . '/') . '" title="' . $v["name"] . '">' . $v["name"] . '</a></li>';
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="build third">
        <h4 class="gre-arrow intho">专家咨询</h4>
        <div class="third-block two-block third-doc mT18">
            <?php
            if (isset($expert) && !empty($expert)) {
                foreach ($expert as $k => $v) {
                    $nelid = ($k == 2) ? 'nelid' : '';
                    ?>
            <div class="lie clearfix <?php echo $nelid; ?>">
                        <div class="doc_pic fl"><a href="<?php echo Url::to('@community/user/?uid=' . $v['uid']); ?>"><img src="<?php echo Url::to('@community/upload/pic/' . $v['pic']); ?>" title="<?php echo $v['truename']? : $v['nickname']; ?>"></a></div>
                        <div class="doc_writ fl">
                            <p class="pagename"><?php echo $v['truename']? : $v['nickname']; ?></p>
                            <p class="grat pagna12"><?php echo $v['doc_keshi']; ?> <?php echo $v['zhicheng']; ?></p>
                            <p class="pagna12">擅长：<?php echo!empty($v['best_dis']) ? StringHelper::truncate(trim($v['best_dis']), 8, '', 'utf-8') : '暂无'; ?><a href="<?php echo Url::to('@community/user/?uid=' . $v['uid']); ?>"> [详情]</a></p>
                            <p class="ruser_ques89"><a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>">向TA提问</a></p>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="build four">
        <h4 class="gre-arrow">热搜标签</h4>
        <div class="four-block two-block btline mT18 clearfix">
            <ul class="mouak">
                <?php
                if (isset($disease)) {
                    $dname = $disease['name'];
                    $dpinyin = $disease['pinyin_initial'];
                    ?>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/jianjie') . '/'; ?>" title="<?php echo $dname; ?>是什么病"><?php echo $dname; ?>是什么病</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/zz') . '/'; ?>" title="<?php echo $dname; ?>症状表现"><?php echo $dname; ?>症状表现</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/zz') . '/'; ?>" title="<?php echo $dname; ?>早期症状"><?php echo $dname; ?>早期症状</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/by') . '/'; ?>" title="<?php echo $dname; ?>是怎么引起的"><?php echo $dname; ?>是怎么引起的</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/by') . '/'; ?>" title="<?php echo $dname; ?>发病原因"><?php echo $dname; ?>发病原因</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/lcjc') . '/'; ?>" title="<?php echo $dname; ?>检查项目"><?php echo $dname; ?>检查项目</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/lcjc') . '/'; ?>" title="<?php echo $dname; ?>检查费用"><?php echo $dname; ?>检查费用</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/jb') . '/'; ?>" title="<?php echo $dname; ?>诊断方法"><?php echo $dname; ?>诊断方法</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/zl') . '/'; ?>" title="<?php echo $dname; ?>怎么治疗"><?php echo $dname; ?>怎么治疗</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/zl') . '/'; ?>" title="<?php echo $dname; ?>治疗方法"><?php echo $dname; ?>治疗方法</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/yshl') . '/'; ?>" title="<?php echo $dname; ?>吃什么好"><?php echo $dname; ?>吃什么好</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/bfz') . '/'; ?>" title="<?php echo $dname; ?>并发症"><?php echo $dname; ?>并发症</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/zl') . '/'; ?>" title="<?php echo $dname; ?>自测方法"><?php echo $dname; ?>自测方法</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/zl') . '/'; ?>" title="<?php echo $dname; ?>自我治疗"><?php echo $dname; ?>自我治疗</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/yshl') . '/'; ?>" title="<?php echo $dname; ?>的饮食"><?php echo $dname; ?>的饮食</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/yaopin') . '/'; ?>" title="<?php echo $dname; ?>用药"><?php echo $dname; ?>用药</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/yaopin') . '/'; ?>" title="<?php echo $dname; ?>吃什么药"><?php echo $dname; ?>吃什么药</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/yy') . '/'; ?>" title="<?php echo $dname; ?>的医院"><?php echo $dname; ?>的医院</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/ys') . '/'; ?>" title="<?php echo $dname; ?>专家"><?php echo $dname; ?>专家</a></li>
                    <li><a href="<?php echo Url::toRoute('/' . $dpinyin . '/zixun') . '/'; ?>" title="<?php echo $dname; ?>在线咨询"><?php echo $dname; ?>在线咨询</a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="drelat heain btline" style="padding:0 0 10px 0; margin:10px 0 0 0">
        <h4 class="lw5 dyh intho"><a href="http://zt.9939.com/">更多>></a><b style="font-weight:normal;">热门专题</b></h4>
        <div class="drehos">
            <div class="tabMop sty02">
                <div class="ims2"><a href=""> <img src="/images/jingcaizhuanti.jpg" alt="“僵尸肉“你不知道的黑幕"> </a>
                    <div class="intro"><a href="http://zt.9939.com/jsr/" title="“僵尸肉“你不知道的黑幕">“僵尸肉“你不知道的黑幕</a></div>
                </div>
                <ul class="spul spc a_artic a_nlis newa">
                    <li><a href="http://zt.9939.com/yyz/" title="关注抑郁症，你的情绪患了感冒吗？">关注抑郁症，你的情绪患了感冒吗？</a></li>
                    <li><a href="http://zt.9939.com/azyf01/" title="我们进入了癌症时代？与癌症抗争到底">我们进入了癌症时代？与癌症抗争到底</a></li>
                    <li><a href="http://zt.9939.com/sm01/" title="是谁偷走了你的睡眠？">是谁偷走了你的睡眠？</a></li>
                    <li><a href="http://zt.9939.com/mxxd/" title="从明星涉毒 看毒品对身体的危害">从明星涉毒 看毒品对身体的危害</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!--精彩推荐-->
    <div>
        <div class="build five">
            <h4 class="gre-arrow">精彩推荐</h4>
            <div class="clumn mT18">
                <?php echo $this->render('/ads/common/ads_br'); ?>
            </div>
        </div>
    </div>
    <!--精彩推荐-->

    <div class="clear"></div>
</div>