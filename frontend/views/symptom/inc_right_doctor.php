<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<div class="build third">
    <h4 class="gre-arrow intho">专家咨询</h4>
    <div class="third-block two-block third-doc mT18">
        <?php
        if (isset($doctorInfos) && !empty($doctorInfos)) {
            foreach ($doctorInfos as $k => $v) {
                $nelid = ($k == 2) ? 'nelid' : '';
                $truename = $v['truename'] ? : $v['nickname'];
                ?>
                <div class="lie clearfix <?php echo $nelid; ?>">
                    <div class="doc_pic fl"><a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>"><img src="<?php echo Url::to('@community/upload/pic/' . $v['pic']); ?>"></a></div>
                    <div class="doc_writ fl">
                        <p class="pagename"><?php echo $truename; ?></p>
                        <p class="grat pagna12"><?php echo $v['doc_keshi']; ?> <?php echo $v['zhicheng']; ?></p>
                        <?php
                        if (!empty($v['best_dis'])) {
                            echo '<p class="pagna12">擅长：' . String::cutString($v['best_dis'], 8, '...') . '<a href="' . Url::to('@community/user/?uid=' . $v['uid']) . '"> [详情]</a></p>';
                        }
                        ?>
                        <p class="ruser_ques89"><a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>">向TA提问</a></p>
                    </div>
                </div>
                <?php
            }
        }
        ?> 
    </div>
</div>
