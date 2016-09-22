<!-- 图谱部分 -->

<!-- 广告位部分 Start -->
<div>
    <?php echo $this->render('detail_below_rec_ads'); ?>
</div>
<!-- 广告位部分 End -->

<div class="rela_a a_labe">
    <div class="a_rea a_hop a_mar">
        <h2>
            <span><a href="http://pic.9939.com/">更多>></a></span>
            <img src="/images/pi_01.png">
        </h2>
        <ul class="a_im">

            <?php
            if ($this->beginCache('frontend_article_detail_belowpicspart', ['cache' => 'cache_file', 'duration' => CACHE_AD_TIME])){
                $ads = new \common\models\ads\Ads();
                $content = $ads->ads(4552);
                if (isset($content) && !empty($content)){
                    echo $content;
                }
                $this->endCache();
            }
            ?>

            <!--<li><a href="http://pic.9939.com/btsj/wk/2015/0723/1751032.shtml#1"><img src="http://www.9939.com/9939/res/disease/v1/images/pic1.jpg" alt=""></a><div><a href="http://pic.9939.com/btsj/wk/2015/0723/1751032.shtml#1">抑郁症摄影师描绘内心</a></div></li>
            <li><a href="http://pic.9939.com/bjtk/zx/2015/0713/1749922.shtml#1"><img src="http://www.9939.com/9939/res/disease/v1/images/pic2.jpg" alt=""></a><div><a href="http://pic.9939.com/bjtk/zx/2015/0713/1749922.shtml#1">整容过程全揭秘</a></div></li>
            <li><a href="http://pic.9939.com/btsj/xbk/2009/0624/453659.shtml#1"><img src="http://www.9939.com/9939/res/disease/v1/images/pic3.jpg" alt=""></a><div><a href="http://pic.9939.com/btsj/xbk/2009/0624/453659.shtml#1">认识毒品的危害性</a></div></li>
            <li><a href="http://pic.9939.com/bjtk/zx/2015/0723/1751057.shtml#1"><img src="http://www.9939.com/9939/res/disease/v1/images/pic4.jpg" alt=""></a><div><a href="http://pic.9939.com/bjtk/zx/2015/0723/1751057.shtml#1">图片：90后模特隆胸记</a></div></li>
            <li><a href="http://pic.9939.com/btsj/fck/nxsltp/2014/0701/1683449.shtml#10"><img src="http://www.9939.com/9939/res/disease/v1/images/pic5.jpg" alt=""></a><div><a href="http://pic.9939.com/btsj/fck/nxsltp/2014/0701/1683449.shtml#10">医院实拍少女人流过程</a></div></li>
            <li><a href="http://pic.9939.com/yxzl/jpt/2015/0728/1751504.shtml#1"><img src="http://www.9939.com/9939/res/disease/v1/images/pic6.jpg" alt=""></a><div><a href="http://pic.9939.com/yxzl/jpt/2015/0728/1751504.shtml#1">超逼真医用尸体模型</a></div></li>
            <li><a href="http://pic.9939.com/yxzl/yxyxt/2009/0309/304828.shtml#1"><img src="http://www.9939.com/9939/res/disease/v1/images/pic7.jpg" alt=""></a><div><a href="http://pic.9939.com/yxzl/yxyxt/2009/0309/304828.shtml#1">中医文化:拔火罐</a></div></li>
            <li><a href="http://pic.9939.com/yxzl/yxyxt/2015/0615/1746683.shtml#1"><img src="http://www.9939.com/9939/res/disease/v1/images/pic8.jpg" alt=""></a><div><a href="http://pic.9939.com/yxzl/yxyxt/2015/0615/1746683.shtml#1">奇妙的人体X光片</a></div></li>
        -->
        </ul>
    </div>
</div>