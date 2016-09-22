<?php
if ($this->beginCache('wapjb_hot_pic', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])) {
    $ads = new \common\models\ads\Ads();
    $content = $ads->getAdsHandle(4582, 6);
    if (isset($content) && !empty($content)) {
        ?>
        <h2>热图推荐</h2>
        <div class="main_visual">
            <div class="flicking_con">
                <?php
                foreach ($content as $k => $v) {
                    if ($k % 2 == 0) {
                        echo '<a href="#">' . ($k / 2 + 1) . '</a>';
                    }
                }
                ?>
            </div>
            <div class="main_image">
                <ul>
                    <?php
                    foreach ($content as $kk => $vv) {
                        if ($kk % 2 == 0){
                            echo '<li>';
                        }
                        echo '<a href="' . $vv['linkurl'] . '"><img src="' . $vv['imageurl'] . '" alt="' . $vv['adsname'] . '"><p>' . $vv['adsname'] . '</p></a>';
                        if ($kk % 2 == 1){
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
                <a href="javascript:void(0);" id="btn_prev"></a>
                <a href="javascript:void(0);" id="btn_next"></a>
            </div>
        </div>
        <?php
    }
    $this->endCache();
}
