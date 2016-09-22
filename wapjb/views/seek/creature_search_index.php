<?php
   use yii\helpers\Url;
   use yii\helpers\Html;
   use librarys\helpers\utils\String;
?>
<?php
    $this->title = "人群疾病查询_疾病百科_久久健康网";
?>
<article class="head"><a href="/"></a><span>按人群查找</span><a href="/jbzz/" class="setn"></a><a class="clna"></a></article>
<!--导航栏展开-->
<?php
    echo $this->render("/include/navigation");
    echo $this->render("/include/search");
?>
<h2 class="hepla clearfix"><i>按人群查找</i>
    <dl class="find">
        <dt><em>其他查找</em><div></div></dt>
        <dd><a href="/chaxun/renqun/">按人群查找</a></dd>
        <dd><a href="/jbzz/buwei/">按部位查找</a></dd>
        <dd><a href="/jbzz/keshi/">按科室查找</a></dd>
    </dl>
</h2>

<article class="clsa">
    <a href="/chaxun/renqun/2/" <?php if($creatureid=='2'){echo 'class="cus"';}?>>男性</a>
    <a href="/chaxun/renqun/3/" <?php if($creatureid=='3'){echo 'class="cus"';}?>>女性</a>
    <a href="/chaxun/renqun/4/" <?php if($creatureid=='4'){echo 'class="cus"';}?>>儿童</a>
    <a href="/chaxun/renqun/5/" <?php if($creatureid=='5'){echo 'class="cus"';}?>>老人</a>
    <a href="/chaxun/renqun/6/" <?php if($creatureid=='6'){echo 'class="cus"';}?>>孕妇</a>
    <a href="/chaxun/renqun/7/" <?php if($creatureid=='7'){echo 'class="cus"';}?>>职业病</a>
</article>
<!--症状1板块-->
<article class="sexn">
    <a href="/chaxun/renqun/<?php if(!empty($creatureid)){echo $creatureid.'/';}?>" style="width:50%;"<?php if($tab=="" || $tab!=='t2'){echo'class="curr"';}?>>疾病</a>
    <a href="/chaxun/renqun_t2/<?php if(!empty($creatureid)){echo $creatureid.'/';}?>" style="width:50%;"<?php if($tab=='t2'){echo'class="curr"';}?>>症状</a>
</article>
<script>
$(function(){
    $(".sexn a").unbind( "click");
});
</script>
<article class="male">
    <section class="sechoi">
    	<ul class="ache" id="aaaas">
            <?php
                foreach($res as $k=>$res){
                    if($res['source_flag']=='1'){
            ?>
            <li>
                <h3><b class="ac_01">病</b>
                    <p>
                        <a href="/<?php echo $res['pinyin_initial'];?>/"><?php echo $res['name'];?></a>
                        <span><?php if(!empty($res['alias'])){echo'（别名：'.$res['alias'].'）';}?></span>
                    </p>
                </h3>
                <div class="simg">
                    <a href="/<?php echo $res['pinyin_initial'];?>/">
                        <img src="/images/ache.jpg" alt="<?php echo $res['name'];?>">
                    </a>
                    <p>
                        <?php
                            $content = Html::encode($res['description']);
                            echo String::cutString($content, 20, '...');
                        ?>
                        <a href="/<?php echo $res['pinyin_initial'];?>/">查看更多</a>
                    </p>
                </div>
                <div class="sprea">
                    <a href="/<?php echo $res['pinyin_initial'];?>/by/">病因</a>
                    <a href="/<?php echo $res['pinyin_initial'];?>/zz/">症状</a>
                    <a href="/<?php echo $res['pinyin_initial'];?>/lcjc/">检查</a>
                    <a href="/<?php echo $res['pinyin_initial'];?>/zl/">治疗</a>
                </div>
            </li>
        	<?php
                    }else{
                ?>
            <li>
                <h3>
                    <b class="ac_02">症</b>
                    <p>
                        <a href="/zhengzhuang/<?php echo $res['pinyin_initial'];?>/"><?php echo $res['name'];?></a>
                        <span><?php if(!empty($res['alias'])){echo'（别名：'.$res['alias'].'）';}?></span>
                    </p>
                </h3>
                <div class="simg">
                    <a href="/zhengzhuang/<?php echo $res['pinyin_initial'];?>/"><img src="/images/ache.jpg" alt=""></a>
                    <p>
                        <?php
                            $content = Html::encode($res['description']);
                            echo String::cutString($content, 20, '...');
                        ?>
                        <a href="/zhengzhuang/<?php echo $res['pinyin_initial'];?>/">查看更多</a>
                    </p>
                </div>
                <div class="sprea">
                    <a href="/zhengzhuang/<?php echo $res['pinyin_initial'];?>/zzqy/">病因</a>
                    <a href="/zhengzhuang/<?php echo $res['pinyin_initial'];?>/yufang/">预防</a>
                    <a href="/zhengzhuang/<?php echo $res['pinyin_initial'];?>/jiancha/">检查</a>
                    <a href="/zhengzhuang/<?php echo $res['pinyin_initial'];?>/shiliao/">食疗</a>
                </div>
            </li>	
            <?php
                    }
                }
            ?>
        </ul>
        <div class="lasp"><?php $paging->view_2(); ?></div>
    </section>
</article>
<!--ends-->
<div class="thre"></div>
<h2>相关热搜</h2>
<div class="apal">
    <?php
        echo $this->render('wap_ads_seek_hot_search');
    ?>
</div>

<div class="thre"></div>
<?php
    echo $this->render("/include/hot_pic");
?>
<!--广告位-->
<div class="adv">
    <?php
        echo $this->render('/include/ads_below_hotpic');
    ?>
</div>
<div class="thre"></div>
<script>
    function getsearchlist(id){
        $.ajax({url:"/jbzz/creaturesearchajax/", 
        type: 'POST',
        data:{id:id},
        dataType: 'html',
        timeout: 10000, 
                error: function(){
                },
                beforeSend:function(){
                },
                success:function(result){
                        result=result.replace(/(^\s*)|(\s*$)/g,"");
                        document.getElementById('aaaas').innerHTML=result;
                }
        });
    }
</script>
