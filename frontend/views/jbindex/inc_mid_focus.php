<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
        <div class="hodis">
            <div class="ackno">
                <?php
                foreach($focus as $k=>$v){
                    $num = $k+1;
                    $img = Url::to($v['img']);
                    $url = Url::to($v['url']);
                    $txt = Url::to($v['txt']);
                    $first = $num==1 ? ' class="indexahover"' : '';
                    $last = $num==3 ? ' style="margin-right:0;"' : '';
                    $isshow = $num==1 ? '' : ' style="display:none;"';
                ?>
                <a href="<?=$url?>" title="<?=$txt?>" onmouseover="divTag('n3Tab33', 'indexahover', '', <?=$num?>, 0)" name="n3Tab33" id="n3Tab33"<?=$first.$last?>><?=$txt?></a>
                <?php
                }
                ?>
            </div>
            <?php
            foreach($focus as $k=>$v){
                    $num = $k+1;
                    $img = Url::to($v['img']);
                    $url = Url::to($v['url']);
                    $title = Url::to($v['title']);
                    $isshow = $num==1 ? '' : ' style="display:none;"';
            ?>
            <div class="imsho" name="n3Tab33Content" id="n3Tab33Content"<?=$isshow?>>
                <a href="<?=$url?>" title="<?=$title?>"><img src="<?=$img?>" alt="<?=$title?>" title="<?=$title?>"></a>
            </div>
            <?php
            }
            ?>
        </div>