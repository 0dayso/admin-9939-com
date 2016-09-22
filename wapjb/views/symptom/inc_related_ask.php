<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;

if (isset($asks) && !empty($asks)) {
    foreach ($asks['list'] as $k => $v) {
        ?>
        <li>
            <h3>
                <q><a href="<?php echo Url::to('@wapask/id/' . $v['ask']['id'] . '.html', true); ?>"><?php echo String::cutString($v['ask']['title'], 40); ?></a></q>
            </h3>
            <div class="spabs">
                <h4>
                    <img src="<?php echo Url::to('@community/upload/pic/' . $v['answer']['pic']); ?>" alt="">
                    <b><?php echo $v['answer']['truename']; ?></b>
                    <span><?php echo $v['answer']['doc_keshi']; ?></span>
                </h4>
                <p><?php echo String::cutString($v['answer']['content'], 80); ?></p>
                <a href="<?php echo Url::to('@wapask/ask/doctor/' . $v['answer']['userid'], true) ?>" class="ask">向TA提问</a>
            </div>
        </li>
        <?php
    }
}
?>

