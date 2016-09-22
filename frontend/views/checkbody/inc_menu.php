<?php
use yii\helpers\Url;
$cur = \Yii::$app->controller->action->id;
?>
<!--左侧右侧-->
<div class="absbar" id="adla">
    <ul>
        <li><a href="/zhengzhuang/<?=$pinyin_initial?>/" target="_self" <?php if($cur=='index'){?> class="cust"<?php }?>>简&nbsp;介</a></li>
        <li><a href="/zhengzhuang/<?=$pinyin_initial?>/zzqy/" target="_self"<?php if($cur=='cause'){?> class="cust"<?php }?>>病&nbsp;因</a></li>
        <li><a href="/zhengzhuang/<?=$pinyin_initial?>/yufang/" target="_self"<?php if($cur=='prevent'){?> class="cust"<?php }?>>预&nbsp;防</a></li>
        <li><a href="/zhengzhuang/<?=$pinyin_initial?>/jiancha/" target="_self"<?php if($cur=='examine'){?> class="cust"<?php }?>>检&nbsp;查</a></li>
        <li><a href="/zhengzhuang/<?=$pinyin_initial?>/shiliao/" target="_self"<?php if($cur=='food'){?> class="cust"<?php }?>>食&nbsp;疗</a></li>
    </ul>
</div>

<script>
//$("#adla a").eq(2).click(function(){
//    alert('内容完善中');
//    return false;
//});
</script>
    