<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$URL = $model['url'];
$hotwords = $model['hotwords']['list'];
$diseaseArticle = $model['diseaseArticle'];
$diseases = $model['diseases'];
$symptoms = $model['symptoms'];
$ask = $model['asklist'];
$keywords_list = $model['list'];
?>

<?php
//引入导航
echo $this->render("inc_main_nav");
?>

<div class="bran">
    <span>您所在的位置：</span>
    <a href="http://jb.9939.com/">疾病百科</a><span>&gt;</span>
    <a href="<?php echo $URL->domainurl;?>" title="疾病专题">疾病专题</a>
</div>

<!--最新热词 疾病资讯 疾病大全 begin-->
<div class="wrapper matip">
    <!--最新热词 begin-->
    <div class="upda fl">
        <h3 class="titin">最新热词</h3>
        <?php if(!empty($hotwords)){ ?>
            <ul class="infde">
                <?php foreach($hotwords as $k=>$v) { 
                    $name = $v['keywords'];
                    $short_name = String::cutString($name, 16,0) ;
                    $url = sprintf('%s%s/',$URL->searchurl,  str_replace(' ', '', $v['pinyin']));
                    ?>
                    <li><a href="<?php echo $url; ?> " title="<?php echo $name; ?>"><?php echo $short_name; ?></a></li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
    <!--最新热词 end-->
    
    <div class="blan fr">
        <!--疾病咨询 begin-->
        <div class="news">
            <h3 class="titin"><a href="http://jb.9939.com/article_list.shtml">疾病资讯</a></h3>
            <?php if(!empty($diseaseArticle)) { ?>
                <?php $mod = 12;$row_index=1;$len = count($diseaseArticle); $group_num =ceil($len/$mod);   foreach($diseaseArticle as $k=>$v) {
                        $mod_num =$row_index%$mod;
                        $ys_num = floor($row_index/$mod);
                        $class_name = ($ys_num<($group_num-1) && $mod_num==1)?'inplac':'';
                        $li_class_name = $mod_num==3?'class="macha"':'class="macha"';
                        $style=in_array($mod_num,array(1,2,3))?'style="font-weight: bold;"':'';
                        $title = $v['title'];
                        $short_title = String::cutString($title, 14,0) ;
                        $date_path = date('Y/md',$v['inputtime']);
                        $article_path = sprintf("%s/%s/%d.shtml",'article',$date_path,$v['id']);
                        $url = sprintf('%s/%s',Yii::getAlias("@jb_domain"), $article_path);
                    ?>
                        <?php if($mod_num==1){ ?>
                            <div  class="nraid <?php echo $class_name; ?>"><ul>
                        <?php }?>
                            <li <?php echo $style; ?>  <?php echo $li_class_name; ?>><a  href="<?php echo $url; ?>" title="<?php echo $title;?>"><?php echo $short_title;?></a></li>
                        <?php if($mod_num==0 && $row_index<$len){ ?>
                            </ul></div>
                        <?php } ?>
                        <?php if($row_index==$len) {?>
                            </ul></div>
                        <?php } ?>
                        <?php $row_index++; ?>
                <?php } ?>
            <?php } ?>
        </div>
        <!--疾病咨询 end-->
        
        <!--疾病大全 begin-->
        <div class="news cond">
            <h3 class="titin"><a href="http://jb.9939.com/jbzz_t1/">疾病大全</a></h3>
            <?php if(!empty($diseases)) { ?>
                <?php $mod = 12;$row_index=1;$len = count($diseases); $group_num =ceil($len/$mod);   foreach($diseases as $k=>$v) {
                        $mod_num =$row_index%$mod;
                        $ys_num = floor($row_index/$mod);
                        $class_name = ($ys_num<($group_num-1) && $mod_num==1)?'inplac':'';
                        $li_class_name = $mod_num==3?'class="macha"':'class="macha"';
                        $style=in_array($mod_num,array(1,2,3))?'style="font-weight: bold;"':'';
                        $title = $v['name'];
                        $short_title = String::cutString($title, 14,0) ;
                        $url = sprintf('%s/%s/', \Yii::getAlias("@jb_domain"), $v['pinyin_initial']);
                    ?>
                        <?php if($mod_num==1){ ?>
                            <div  class="nraid <?php echo $class_name; ?>"><ul>
                        <?php }?>
                            <li <?php echo $style; ?>  <?php echo $li_class_name; ?>><a  href="<?php echo $url; ?>" title="<?php echo $title;?>"><?php echo $short_title;?></a></li>
                        <?php if($mod_num==0 && $row_index<$len){ ?>
                            </ul></div>
                        <?php } ?>
                        <?php if($row_index==$len) {?>
                            </ul></div>
                        <?php } ?>
                        <?php $row_index++; ?>
                <?php } ?>
            <?php } ?>
        </div>
        <!--疾病大全 end-->
    </div>
    <div class="clear"></div>
</div>
<!--最新热词 疾病资讯 疾病大全 end-->

<!--专家咨询 症状大全 begin-->
<div class="wrapper matip">
    <div class="upda fl">
        <h3 class="titin">专家咨询</h3>
        <ul class="expert pr20">
            <?php if(!empty($model['doctor_ads_text'])) { ?>
                <div>
                    <?php echo $model['doctor_ads_text']; ?>
                </div>
            <?php } ?>
        </ul>
    </div>
    
    <div class="news fr">
        <h3 class="titin"><a href="http://jb.9939.com/jbzz_t2/">症状大全</a></h3>
        <?php if(!empty($symptoms)) { ?>
            <?php $mod = 12;$row_index=1;$len = count($symptoms); $group_num =ceil($len/$mod);   foreach($symptoms as $k=>$v) {
                    $mod_num =$row_index%$mod;
                    $ys_num = floor($row_index/$mod);
                    $class_name = ($ys_num<($group_num-1) && $mod_num==1)?'inplac':'';
                    $li_class_name = $mod_num==3?'class="macha"':'class="macha"';
                    $style=in_array($mod_num,array(1,2,3))?'style="font-weight: bold;"':'';
                    $title = $v['name'];
                    $short_title = String::cutString($title, 14,0) ;
                    $url = sprintf('%s/zhengzhuang/%s/', \Yii::getAlias("@jb_domain"), $v['pinyin_initial']);
                ?>
                    <?php if($mod_num==1){ ?>
                        <div  class="nraid <?php echo $class_name; ?>"><ul>
                    <?php }?>
                        <li <?php echo $style; ?>  <?php echo $li_class_name; ?>><a  href="<?php echo $url; ?>" title="<?php echo $title;?>"><?php echo $short_title;?></a></li>
                    <?php if($mod_num==0 && $row_index<$len){ ?>
                        </ul></div>
                    <?php } ?>
                    <?php if($row_index==$len) {?>
                        </ul></div>
                    <?php } ?>
                    <?php $row_index++; ?>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="clear"></div>
</div>
<!--专家咨询 症状大全 end-->

<!--推荐医院 热门问答 begin-->
<div class="wrapper matip">
    <div class="upda fl">
        <h3 class="titin">推荐医院</h3>
        <ul class="hostp physic">
            <?php if(!empty($model['hospital_ads_text'])) { ?>
                <div>
                    <?php echo $model['hospital_ads_text']; ?>
                </div>
            <?php } ?>
        </ul>
    </div>
    <div class="news fr">
        <h3 class="titin"><a href="http://ask.9939.com/hot/">热门问答</a></h3>
        <?php if(!empty($ask)) { ?>
            <?php $mod = 12;$row_index=1;$len = count($ask); $group_num =ceil($len/$mod);   foreach($ask as $k=>$v) {
                    $mod_num =$row_index%$mod;
                    $ys_num = floor($row_index/$mod);
                    $class_name = ($ys_num<($group_num-1) && $mod_num==1)?'inplac':'';
                    $li_class_name = $mod_num==3?'class="macha"':'class="macha"';
                    $style=in_array($mod_num,array(1,2,3))?'style="font-weight: bold;"':'';
                    $title = $v['title'];
                    $short_title = String::cutString($title, 14,0) ;
                    $url = sprintf('%s/id/%s', \Yii::getAlias("@ask"), $v['id']);
                ?>
                    <?php if($mod_num==1){ ?>
                        <div  class="nraid <?php echo $class_name; ?>"><ul>
                    <?php }?>
                        <li <?php echo $style; ?>  <?php echo $li_class_name; ?>><a  href="<?php echo $url; ?>" title="<?php echo $title;?>"><?php echo $short_title;?></a></li>
                    <?php if($mod_num==0 && $row_index<$len){ ?>
                        </ul></div>
                    <?php } ?>
                    <?php if($row_index==$len) {?>
                        </ul></div>
                    <?php } ?>
                    <?php $row_index++; ?>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="clear"></div>
</div>
<!--推荐医院 热门问答 end-->


<!--热词部分 begin-->
<div class="wrapper">
    <div class="letin">
        <?php
        //字母导航
        echo $this->render("letterNav",[
            'letterNav' => $model['letterNav']
        ]);
        ?>
    </div>
    <div class="lincon">
        
        <?php $mod = 2;$row_index=1; foreach($keywords_list as $k=>$v) { 
                    $mod_num = $row_index%$mod;
                    $classname = $mod_num==1?"class='plates one-{$k}'":"class='plates sameml one-{$k}'";
                    $letter_name = strtoupper($k);
                    $letter_url = sprintf('%s%s/', $URL->letterurl, $letter_name);
            ?>
            <div class="specon">
                <div class="morela"><a href="<?php echo $letter_url; ?>">更多>></a><span><?php echo $letter_name; ?></span></div>
                <ul class="spin">
                    <?php  foreach($v as $kk=>$kv){ 
                                $name = $kv['keywords'];
                                $short_name = String::cutString($name, 12,0) ;
                                $url = sprintf('%s%s/', $URL->searchurl,  str_replace(' ', '', $kv['pinyin']));
                    ?>
                        <li><a href="<?php echo $url; ?> " title="<?php echo $name; ?>"><?php echo $short_name; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <?php $row_index++; ?>
        <?php } ?>
        
    </div>
</div>
<!--热词部分 end-->
<?php
     echo $this->render("/include/footer_zhuanti", [
            'links' => $model['links']
        ]);
?>

<?php
//统计代码，自动推送代码等
echo $this->render("inc_stat_push_other");
?>