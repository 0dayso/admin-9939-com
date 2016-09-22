<!-- 疾病图集分享部分 -->

<?php
$url = \yii\helpers\Url::current([], true);
if ($flag == 1){
    //第一部分的分享：
?>
    <span class="bdsharebuttonbox" id="sarel">
                    <b>分享到：</b>
                    <a href="http://service.weibo.com/share/share.php?title=<?php echo $title; ?>&url=<?php echo $url; ?>&pic="
                       data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>" class="bds_tsina" id="shc_07" data-cmd="tsina"  title="分享到新浪微博"></a>
                    <a href="http://qr.liantu.com/api.php?text=<?php echo $url; ?>" data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>"
                       id="shc_09" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                    <a id="shc_10"
                       href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo $url; ?>"
                       data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>"
                       class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                </span>
    <script>window._bd_share_config = {
            "common": {
                "bdSnsKey": {},
                "bdText": "",
                "bdMini": "2",
                "bdMiniList": false,
                "bdPic": "",
                "bdStyle": "0",
                "bdSize": "18"
            }, "share": {}
        };
        with (document)
            0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
    </script>
<?php
}else{
    //第二部分的分享：
?>
    <div class="bdsharebuttonbox shrea srenn" id="sarel">
        <b>分享到：</b>
        <a href="http://service.weibo.com/share/share.php?title=<?php echo $title; ?>&url=<?php echo $url; ?>&pic="
           data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>" class="bds_tsina" id="sh_01" data-cmd="tsina" title="分享到新浪微博"></a>
        <a href="http://service.weibo.com/share/share.php?title=<?php echo $title; ?>&url=<?php echo $url; ?>&pic="
           data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>" class="wodes">新浪微博</a>
        <a href="http://qr.liantu.com/api.php?text=<?php echo $url; ?>" data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>" id="sh_03" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
        <a href="http://qr.liantu.com/api.php?text=<?php echo $url; ?>" data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>" class="wodes freai devel">微信</a>
        <a id="sh_04" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo $url; ?>"
           data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
        <a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo $url; ?>"
           data-url='<?php echo $url; ?>' data-text="<?php echo $title; ?>" class="wodes freai">QQ空间</a>
    </div>
    <script>window._bd_share_config = {
            "common": {
                "bdSnsKey": {},
                "bdText": "",
                "bdMini": "2",
                "bdMiniList": false,
                "bdPic": "",
                "bdStyle": "0",
                "bdSize": "18"
            }, "share": {}
        };
        with (document)
            0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
    </script>
<?php
}
?>

