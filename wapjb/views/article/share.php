<!-- 分享部分 -->
<?php
$url = \yii\helpers\Url::current([], true);
?>
<article class="shala">
    <h3>分享</h3>
    <div class="shar">
        <a href="http://service.weibo.com/share/share.php?title=<?php echo $title; ?>&url=<?php echo $url; ?>&pic="
           data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>">
            <img src="/images/we_03.png" alt="">
            <p>新浪微博</p>
        </a>
        <a href="http://qr.liantu.com/api.php?text=<?php echo $url; ?>" data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>">
            <img src="/images/we_01.png" alt="">
            <p>微信好友</p>
        </a>
        <a href="http://qr.liantu.com/api.php?text=<?php echo $url; ?>" data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>">
            <img src="/images/we_02.png" alt="">
            <p>朋友圈</p>
        </a>
        <a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo $url; ?>"
           data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>" >
            <img src="/images/we_04.png" alt="">
            <p>腾讯QQ</p>
        </a>
    </div>
</article>