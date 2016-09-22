<?php
use yii\helpers\Url;
$cur = \Yii::$app->controller->action->id;
?>
    <div class="diack causeb focar" id="float">
        <a href="/zhengzhuang/<?=$pinyin_initial?>/" target="_self" <?php if($cur=='index'){?> class="indexahover"<?php }?>>症状首页</a>
        <a href="/zhengzhuang/<?=$pinyin_initial?>/zzqy/" target="_self" <?php if(in_array($cur,['introd','cause','prevent','examine','food'])){?> class="indexahover"<?php }?>>症状知识</a>
        <a href="/zhengzhuang/<?=$pinyin_initial?>/zixun/" target="_self" <?php if($cur=='online'){?> class="indexahover"<?php }?>>在线问诊</a>
        <a href="/zhengzhuang/<?=$pinyin_initial?>/yiyao/"  target="_self" <?php if($cur=='medicine'){?> class="indexahover"<?php }?>>常用药品</a>
        <a href="/zhengzhuang/<?=$pinyin_initial?>/article_list.shtml" target="_self" <?php if($cur=='article'){?> class="indexahover"<?php }?>>文章解读</a>
        <div class="incon">
            <a href="http://hospital.9939.com/" class="fin_01"><span></span>找医院</a>
            <a href="http://yisheng.9939.com/" class="fin_02"><span></span>找医生</a>
            <a href="http://yiyao.9939.com/" class="fin_03"><span></span>找药品</a>
        </div>
    </div>