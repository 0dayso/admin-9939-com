<div class="letter-switch  lett-tab leume  mT25 clearfix">
    <?php 
    foreach($model['randWords']['letter'] as $k=>$v) {
    ?>
    <a href="<?php echo yii\helpers\Url::to('@jb_domain' . '/so/' . strtoupper($v) . '/'); ?>"><?=strtoupper($v)?></a>
    <?php 
        } 
    ?>
</div>
<div class="lett-tab-con f12">
    <?php 
    $n=0;
    foreach($model['randWords']['words'] as $k=>$v) {
        $letter = strtoupper($k);
        $isshow =($n==0)? '': 'disn';
    ?>
    <div class="lett-tab-<?=$letter?> hotwords <?=$isshow?>">
        <?php
        foreach($v as $vv){
            $url = \librarys\helpers\utils\Url::getkeywordsUrl($vv);
        ?>
        <a href="<?php echo $url; ?>" title="<?=$vv['keywords']?>"><?=$vv['keywords']?></a>
        <?php
        }
        ?>
    </div>
    <?php
    $n++;
    }
    ?>
</div>