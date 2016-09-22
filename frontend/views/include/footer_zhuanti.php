    <!--底部 开始--> 
    <!--底部 开始-->
    <!--1020底部
    <div class="footer" style="margin-bottom:0;"><div class="ftbox"><div class="ftyq"><div class="fre">友情链接</div><div class="mylj conv"> <a href="">首都保健营养协会</a><a href="">健康网</a><a href="">久久健康商城</a><a href="">818医药网</a> <a href="">中华中医网</a><a href="">MSN健康频道</a><a href="">华夏医界网</a> <a href="">快速问答网</a> <a href="">网医网</a><a href="">医学百科</a><a href="">飞华健康网</a><a href="">携手健康网</a><a href="">中药</a><a href="">深圳医院</a><a href="">食品饮料网</a><a href="">百度虫医药招商网</a><a href="">有问必答</a><a href="">药品资讯网</a><a href="">深圳博爱医院</a><a href="">教育人生网</a>
       <a href="">康路网</a><a href="">医学全在线</a><a href="">平安健康网</a> <a href="">健康报网</a> </div> </div></div></div>
    -->   
    
<?php
if($links){
?>
<div class="ftbox" style="border-bottom: 1px solid #ededed;margin-bottom: 20px;">
        <div class="ftyq"><div class="fre">友情链接</div><div class="ftyq-my"><div class="mylj conv">
                    <?php foreach($links as $k => $v){?>
                        <?php
                            $style = $k==0 ? 'margin-left: 0px;' : '';
                        ?>
                        <a href="<?php echo $v['linkurl'];?>" target="_blank"  title="<?php echo $v['adsname'];?>" style="<?php echo $style;?>"><?php echo $v['adsname'];?></a>|
                    <?php }?>
<!--                    <a href="http://life.nvsay.com/ " target="_blank" title="两性故事" style="margin-left: 0px;">两性故事</a>|
                    <a href="http://bbs.bozhong.com" target="_blank" title="怀孕">怀孕</a>|<a href="http://baby.9939.com/zhuanti/" target="_blank" title="母婴热搜">母婴热搜</a>|<a href="http://www.zhongyao.org.cn" target="_blank" title="中药网">中药网</a>|<a href="http://news.120ask.com/" target="_blank" title="健康新闻">健康新闻</a>|<a href="http://sj.39.net" target="_blank" title="39神经科频道">39神经科频道</a>|<a href="http://www.women-health.cn/ " target="_blank" title="女性健康网">女性健康网</a>|<a href="http://www.shinsbo.cn" target="_blank" title="新稀宝官方商城">新稀宝官方商城</a>|<a href="http://sex.familydoctor.com.cn/" target="_blank" title="两性健康">两性健康</a>|<a href="http://ys.99.com.cn/" target="_blank" title=" 饮食健康"> 饮食健康</a>|<a href="http://www.kjrs365.com" target="_blank" title="保健品网">保健品网</a>|<a href="http://love.ewsos.com" target="_blank" title="性生活">性生活</a>|<a href="http://ww.chunhui12.com/" target="_blank" title="巍网">巍网</a>|<a href="http://www.cnksr.com/" target="_blank" title="昆山健康网">昆山健康网</a>|<a href="http://www.qiaoyuwang.com/" target="_blank" title="瞧娱网">瞧娱网</a>|<a href="http://www.ruosi6.cn/" target="_blank" title="明星恋爱情感">明星恋爱情感</a>|<a href="http://bbs.tm51.com" target="_blank" title="不孕不育">不孕不育</a>|<a href="http://love.heima.com/" target="_blank" title="性技巧">性技巧</a>|<a href="http://www.9939.com/zhuanti/" target="_blank" title="久久热搜">久久热搜</a>|<a href="http://www.360bzl.com/ " target="_blank" title="网上药店">网上药店</a>|<a href="http://sex.jiankang.com/ " target="_blank" title="两性健康">两性健康</a>|<a href="http://zzk.qiuyi.cn/ " target="_blank" title="症状库">症状库</a>|<a href="http://www.chunshuitang.com/" target="_blank" title="两性用品">两性用品</a>|<a href="http://jb.9939.com/" target="_blank" title="疾病查询">疾病查询</a>|<a href="http://sex.39.net" target="_blank" title="性教育网">性教育网</a>-->
                </div></div> </div>
    </div>
<?php
}
?>     
    <div class="ftnav colorline">
        <a href="http://www.9939.com/" title="久久健康网">久久健康网</a>|
        <a href="http://www.9939.com/Company/wzjj.shtml" rel="nofollow">关于我们</a>|
        <a href="http://www.9939.com/sitemap/" title="网站地图">网站地图</a>|
        <a href="http://ask.9939.com/sitemap.html">问答地图</a>|
        <a href="http://jb.9939.com/map/">疾病地图</a>|
        <a href="http://www.9939.com/Company/careers.php" rel="nofollow">招聘信息</a>|
        <a href="http://www.9939.com/Company/zlhz.shtml" rel="nofollow">战略合作</a>|
        <a href="http://www.9939.com/Company/wzdt.php" rel="nofollow">媒体报道</a>|
        <a href="mailto:SERVICES@9939.COM" rel="nofollow">意见反馈</a>|
        <a href="http://www.9939.com/Company/lxwm.shtml" rel="nofollow">联系我们</a>|
        <a href="http://www.9939.com/Company/cpfw.shtml" rel="nofollow">服务条款</a>
    </div>
    <div class="ftbox">
        <div class="ftzq">
           <p><?php echo Yii::$app->params['copyright']; ?></p>
            <p><?php echo Yii::$app->params['declaration']; ?></p>
        </div>
    </div>

    <?php echo $this->render("baidu_cnzz_statictis"); ?>
    <?php echo $this->render("baidu_push"); ?>