<?php
use yii\helpers\Url;
use yii\helpers\StringHelper;

$this->title = $disease['name'] . '在线咨询_' . $disease['name'] . '在线预约、挂号_疾病百科_久久健康网';
$this->metaTags['keywords'] = $disease['name'] . '在线咨询,' . $disease['name'] . '在线预约,' . $disease['name'] . '在线挂号';
$this->metaTags['description'] = '久久健康网-疾病百科频道提供专业、全面的' . $disease['name'] . '在线咨询、' . $disease['name'] . '在线预约、' . $disease['name'] . '在线挂号等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
?>
<?php
echo $this->render('index_nav', [
    'disease' => $disease,
]);
?>

<div class="art_wra"  id="fsD1" style="margin:0 auto;">
    <div class="art_l" id="D1pic1">
        <div class="fadoc">名医推荐</div>
        <ul class="fadol fcon">
            <?php
            if ($doctor && !empty($doctor)) {
                foreach ($doctor as $k => $v) {
                    $truename = $v['truename'] ?: $v['nickname'];
                    ?>
                    <li>
                        <div class="exdoc fl">
                            <a href="<?php echo Url::to('@community/user/?uid=' . $v['uid']); ?>">
                                <img src="<?php echo Url::to('@community/upload/pic/' . $v['pic']); ?>" alt="<?php echo $truename; ?>" title="<?php echo $truename; ?>">
                            </a>
                            <p><a href="<?php echo Url::to('@community/user/?uid=' . $v['uid']); ?>">向TA咨询</a></p>
                        </div>
                        <div class="docun fl">
                            <p class="inst_01"><a href="<?php echo Url::to('@community/user/?uid=' . $v['uid']); ?>" title="<?php echo $truename; ?>"><?php echo $truename; ?></a></p>
                            <p class="inst_02"><?php echo $v['zhicheng']; ?></p>
                            <p class="inst_04"><span class="sp_01">擅长：</span><span class="sp_02"><?php echo !empty($v['best_dis']) ? $v['best_dis'] : '暂无';?></span></p>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>

        <?php
        if (isset($asks) && !empty($asks)) {
            ?>
        <div class="tost nickn reart"><h2><a href="<?php echo Url::to('@ask/classid/' . $v2snsKeshiID); ?>" class="amor">更多>></a><span><?php echo $disease['name']; ?></span>热门咨询</h2>
                <ul class="hoque">
                    <?php
                    foreach ($asks['list'] as $k => $v) {
                        $answer = array_key_exists('answer', $v) ? $v['answer']['content'] : '暂无回复';
                        ?>
                        <li>
                            <dl>
                                <dt><a href="<?php echo Url::to('@ask/id/' . $v['ask']['id']); ?>" title="<?php echo $v['ask']['title']; ?>"><?php echo $v['ask']['title']; ?></a></dt>
                                <dd><?php echo StringHelper::truncate(trim(strip_tags($answer)), 45, '...', 'utf-8'); ?><a href="<?php echo Url::to('@ask/id/' . $v['ask']['id']); ?>">[详情]</a></dd>
                            </dl>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
        ?>


        <!--暂时隐藏 start -->
<!--    <div class="tost nickn reart eypa"><h2><span>手足口病</span>推荐专家</h2>
                <ul class="exnur expco einfo">
                <li><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
                <li><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
                <li><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
                <li><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
                <li><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
                <li><a href=""><img src="/images/doc.jpg" alt="" title=""></a><h3><a href="">宋兵杰</a></h3><p>急诊科  副主任医师</p><p class="inlas">擅长：手足口病</p></li>
            </ul>
        </div>-->
        <!--暂时隐藏 end -->

        <!--热门疾病-->
        <!-- 猜你感兴趣 start-->
        <div class="rela_a a_labe">
            <div class="a_rea a_hop a_mar">
                <h2><b>猜你感兴趣</b></h2>
                <div class="aplces">
                    <?php echo $this->render('/ads/common/ads_interest'); ?>
                </div>
            </div>
        </div>
        <!-- 猜你感兴趣 end-->
    </div>

    <!--右侧-->
    <?php
    echo $this->render('index_right');
    ?>
    <!--右侧-->

</div>

