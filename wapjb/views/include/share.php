<?php
$url = \yii\helpers\Url::current([], true);
$title = isset($title) ? $title : '';
?>
<div class="oubra disn"></div>
<div class="sio arsha disn">
    <div class="cdoer">
        <article class="shala">
            <div class="shar">
                <a href="http://qr.liantu.com/api.php?text=<?php echo $url; ?>" data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>"><img src="/images/we_01.png" alt="微信好友"><p>微信好友</p></a>
                <a href="http://qr.liantu.com/api.php?text=<?php echo $url; ?>" data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>"><img src="/images/we_02.png" alt="朋友圈"><p>朋友圈</p></a>
                <a href="http://service.weibo.com/share/share.php?title=<?php echo $title; ?>&url=<?php echo $url; ?>&pic="
                   data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>"><img src="/images/we_03.png" alt="新浪微博"><p>新浪微博</p></a>
                <a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo $url; ?>"
                   data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>"><img src="/images/we_04.png" alt="腾讯QQ"><p>腾讯QQ</p></a>
            </div>
        </article>
    </div>
    <p class="cairet">取消</p>
</div>

