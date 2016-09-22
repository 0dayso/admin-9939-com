<div class="letter-switch  lett-tab leume  mT25 clearfix">
    <?php
    foreach ($model['randWords']['letter'] as $k => $v) {
        $class_name = ($model['currLetter'] == strtoupper($v)) ? 'class="indexahover"' : 'class=""';
        ?>
        <a href="<?php echo yii\helpers\Url::to('@jb_domain' . '/so/' . strtoupper($v) . '/'); ?>" onmouseover="divTag('n7Tab77', 'indexahover', '', <?= ($k + 1) ?>, 0)" name="n7Tab77" id="n7Tab77" <?php echo $class_name; ?>><?= strtoupper($v) ?></a>
        <?php
    }
    ?>
</div>
<div class="lett-tab-con f12">
    <?php
    foreach ($model['randWords']['words'] as $k => $v) {
        $letter = strtoupper($k);
        $isshow = ($model['currLetter'] == $k) ? '' : ' style="display:none;"';
        ?>
        <div class="lett-tab-<?= $letter ?> hotwords"  name="n7Tab77Content" id="n7Tab77Content" <?php echo $isshow; ?>>
            <?php
            foreach ($v['list'] as $vv) {
                    $url = \librarys\helpers\utils\Url::getkeywordsUrl($vv);
                ?>
                <a href="<?php echo $url; ?>" title="<?= $vv['keywords'] ?>"><?= $vv['keywords'] ?></a>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>