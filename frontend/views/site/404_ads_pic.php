
<!-- 404 页面图片部分 -->

<?php
if ($this->beginCache('frontend_404_page_pics', ['cache' => 'cache_file', 'duration' => 24*3600])){
    $ads = new \common\models\ads\Ads();
    $picAd = $ads->ads_content(4456, 0, 8);
    ?>
    <?php foreach($picAd as $v){?>
        <li>
            <a href="<?php echo $v['linkurl']?>" title="<?php echo $v['adsname']?>">
                <img src="http://www.9939.com/uploadfile/<?php echo $v['imageurl']?>" alt="<?php echo $v['adsname']?>" title="<?php echo $v['adsname']?>">
            </a>
        </li>
    <?php }?>
    <?php
    $this->endCache();
}
?>

