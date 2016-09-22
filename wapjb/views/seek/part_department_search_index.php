<?php
   use yii\helpers\Url;
   use yii\helpers\Html;
   use librarys\helpers\utils\String;
?>
<?php
    $this->title="科室部位相关疾病查询,科室部位相关症状查询";
?>
<article class="head"><a href="/"></a><span>综合查找</span><a href="/jbzz/" class="setn"></a><a class="clna"></a></article>
<!--导航栏展开-->
<?php
    echo $this->render("/include/navigation");
    echo $this->render("/include/search");
?>
<nav class="acfi"><a href="/chaxun/renqun/"><span></span><p>按人群查</p></a><a href="/jbzz/buwei/"><span></span><p>按部位查</p></a><a href="/jbzz/keshi/"><span></span><p>按科室查</p></a></nav>
<div class="thre"></div>
<!--症状1板块-->
<article class="sexn">
    <a <?php if($tab==''){echo 'class="curr"';}?> href="/jbzz/<?php echo $part;?>/<?php echo $department;?>/" />全部</a>
    <a <?php if($tab=='t1'){echo 'class="curr"';}?> href="/jbzz/<?php echo $part;?>/<?php echo $department;?>_t1/" />疾病</a>
    <a <?php if($tab=='t2'){echo 'class="curr"';}?>style="width:33.4%;" href="/jbzz/<?php echo $part;?>/<?php echo $department;?>_t2/" />症状</a>
</article>
<script>
$(function(){
    $(".sexn a").unbind( "click");
});
</script>
<article class="male">
    <section class="sechoi">
    	<ul class="ache">
            <?php
                foreach($res as $k=>$res){
                    if($res['source_flag']=='1'){
            ?>
            <li>
                <h3><b class="ac_01">病</b>
                    <p>
                        <a href="/<?php echo $res['pinyin_initial'];?>/">
                        <?php 
                            echo $res['name'];
                        ?>
                        </a>
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
                    <p><a href="/zhengzhuang/<?php echo $res['pinyin_initial'];?>/">
                        <?php 
                            echo $res['name'];;
                        ?>
                        </a>
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
        <div class="lasp">
            <?php $paging->view_2(); ?>
        </div>
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


