<?php

use yii\helpers\Url;
?>
<a href="<?php echo Url::to('/zhengzhuang/' . $symptom['pinyin_initial'] . '/jianjie'); ?>"><?php echo $symptom['name']; ?>知识<span>简介</span></a>
<a href="<?php echo Url::to('/zhengzhuang/' . $symptom['pinyin_initial'] . '/zzqy'); ?>"><?php echo $symptom['name']; ?><span>病因</span></a>
<a href="<?php echo Url::to('/zhengzhuang/' . $symptom['pinyin_initial'] . '/jiancha'); ?>"><?php echo $symptom['name']; ?>典型<span>检查</span>项目</a>
<a href="<?php echo Url::to('/zhengzhuang/' . $symptom['pinyin_initial'] . '/shiliao'); ?>"><?php echo $symptom['name']; ?>的<span>饮食</span></a>
<a href="<?php echo Url::to('/zhengzhuang/' . $symptom['pinyin_initial'] . '/yufang'); ?>"><?php echo $symptom['name']; ?>如何<span>预防</span></a>
