<!-- 文章页 导航 -->

<!--左侧右侧-->
<dl class="rightbar">
    <dt><img src="/images/bar_01.png">
    <p>扫一扫官方微信<br/>关注更多健康资讯</p></dt>
    <dd class="hel_01"></dd>
    <dd class="hel_02"><p><a href="">问专家</a></p></dd>
    <dd class="hel_03"><p><a href="">提建议</a></p></dd>
    <dd class="hel_04"><p><a href="javascript:scroll(0,0)" target="_self">回顶部</a></p></dd>
</dl>
<SCRIPT language=JavaScript type=text/javascript src="/js/retop.js"></SCRIPT>
<!--ends-->

<div class="content bocon">
    <div class="art_s"> 您所在的位置：
        <a href="http://www.9939.com/" target="_blank">久久健康网</a>>
        <a href="http://jb.9939.com/" target="_blank">疾病百科</a>>
        <a href="/jbzz/">疾病症状</a>>
        <?php
        $url = '#';
        $name = '正文';
        if(isset($disease) && !empty($disease)){
            if($isSymptom == 0){
                $url = '/'.$disease['pinyin_initial'].'/';
            }else{
                $url = '/zhengzhuang/'.$disease['pinyin_initial'].'/';
            }
            $name = $disease['name'];
        }
        ?>
        <a href="<?php echo $url;?>">
            <b>
                <?php echo $name;?>
            </b>
        </a>
    </div>
</div>
<!--引入头部 End-->