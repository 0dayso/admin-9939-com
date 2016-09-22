
<?php
//右侧中间广告位
if ($this->beginCache('jb_ads_seek_right_center', ['cache' => 'cache_file', 'duration' => 3600])) {
    $ads = new \common\models\ads\Ads();
    $ads_br = $ads->ads(4562);
	if (isset($ads_br) && !empty($ads_br)) {
		echo $ads_br;
	}
    $this->endCache();
}
?>