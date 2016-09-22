<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<!--底部热词 开始-->
<div class="content-one refin">
    <div class="lettf">
        <a class="accor">按拼音查找</a>
        <?php 
        $letter_index = 0;
    foreach($data['letter'] as $k=>$v) {
        $class_name = $k=='A'? 'class="indexahover"': 'class=""';
        $last = $k=='Z'?' style="width:38px;"':'';
    ?>
    <a href="<?php echo yii\helpers\Url::to('@jb_domain' . '/so/' . strtoupper($v) . '/'); ?>" <?php echo $class_name; ?><?php echo $last; ?>><?=strtoupper($v)?></a>
    <?php 
    $letter_index++;
        } 
    ?>
    </div>
    <?php
    $n=0;
    $randwords = $data['words'];
    foreach($randwords as $k=>$v) {
        $letter = strtoupper($k);
        $isshow = $n=='A'? '': ' disn';
    ?>
    <ul class="outro<?php echo $isshow; ?>">
        <?php
            if (count($v) > 1) {
                foreach ($v as $kk => $vv) {
                    $source_name = $vv['source_flag']==1?'/':'/zhengzhuang/';
                    $baseurl = yii\helpers\Url::to('@jb_domain'.$source_name);
                    $url = sprintf('%s%s/', $baseurl, str_replace(' ', '', $vv['pinyin_initial']));
                    echo '<li><a href="' . $url . '" title="' . $vv['name'] . '">' . $vv['name'] . '</a></li>';
                }
            }
        ?>
    </ul>
    <?php
    $n++;
    }
    ?>
</div>
<!--底部热词 结束-->