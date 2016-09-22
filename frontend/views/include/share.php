
<?php
$url = \yii\helpers\Url::current([], true);
?>

<!-- 分享部分 -->
<div class="shacon">
    <div>分享</div>
    <ul>
        <li class="xinl">
            <a href="http://service.weibo.com/share/share.php?title=<?php echo $title; ?>&url=<?php echo $url; ?>&pic="
               data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>">
                新浪微博
            </a>
        </li>
        <li class="weix">
            <a href="http://qr.liantu.com/api.php?text=<?php echo $url; ?>" data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>">
                微信
            </a>
        </li>
        <li class="zone">
            <a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo $url; ?>"
               data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>" >
                QQ空间
            </a>
        </li>
    </ul>
</div>
