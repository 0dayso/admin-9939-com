<!--疾病症状页底部广告位-->
<?php
if ($this->beginCache('jb_ads_seek_bottom', ['cache' => 'cache_file', 'duration' => 3600])) {
    $ads = new \common\models\ads\Ads();
    $ads_br = $ads->ads(4555);
	if (isset($ads_br) && !empty($ads_br)) {
		echo $ads_br;
	}
    $this->endCache();
}
?>