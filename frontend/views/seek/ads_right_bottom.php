
<?php
//猜你喜欢广告位
if ($this->beginCache('jb_ads_seek_right_bottom', ['cache' => 'cache_file', 'duration' => 3600])) {
    $ads = new \common\models\ads\Ads();
    $ads_br = $ads->ads(4545);
	if (isset($ads_br) && !empty($ads_br)) {
		echo $ads_br;
	}
    $this->endCache();
}
?>