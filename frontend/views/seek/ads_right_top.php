
<?php
//右上角广告
if ($this->beginCache('jb_ads_seek_right_top', ['cache' => 'cache_file', 'duration' => 3600])) {
    $ads = new \common\models\ads\Ads();
    $ads_br = $ads->ads(4544);
?>
		<div class="clumn mTop">
			<?php
				if (isset($ads_br) && !empty($ads_br)) {
					echo $ads_br;
				}
			?>
		</div>
<?php
    $this->endCache();
}
?>