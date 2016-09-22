<?php

use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$URL = $model['url'];
$detail = $model['detail'];

$art_list = $model['rel_art_list'];
$ask_list = $model['rel_ask_list'];
$disease_list = $model['disease_list'];
$diseaseArticle = $model['diseaseArticle'];
$arr_art_splice = array_splice($art_list, 1);
?>

<?php
//引入导航
echo $this->render("inc_main_nav");
?>

<div class="becrum">
    <a href="http://jb.9939.com/">疾病百科</a>&gt;
    <a href="<?php echo $URL->domainurl;?>" title="疾病专题">疾病专题</a>&gt;
    <a href="<?php echo $URL->domainurl;?><?=$detail['pinyinKeywords']?>/" title="<?=$detail['cn_key_name']?>"><?=$detail['cn_key_name']?></a>
</div>

<!--关于专题 begin-->
<div class="outtop">
    <div class="wrapper shrec">	
        <div class="about">
            <div class="cont"><p>关于</p><h1><?=$detail['cn_key_name']?></h1><p>的专题</p></div>
        </div>
        <div class="reason">
            <?php if (!empty($art_list)) { ?>
                <?php foreach($art_list as $k=>$v){ 
                        $title = $v['title'];
                        $url = $v['url'];
                        $descp = String::cutString($v['description'], 90, 1);
                        $short_title = String::cutString($title, 18, 0);
                    ?>
                    <h2>
                        <div class="date">
                            <span><?= date("Y-m-d H:i", $v['inputtime']) ?> </span>
                            <span class="fxah">
                                <b>分享</b>
                                <ul class="zomm">
                                    <li  class="first">
                                        <a class="share_9939 ntshare_sina" title="分享到新浪微博" target="_blank" data-url='<?php echo $url; ?>' data-text="<?php echo $v['title']; ?>" href="http://service.weibo.com/share/share.php?title=<?php echo $v['title']; ?>&url=<?php echo $v['url'] ?>&pic=">
                                            <i class="ep_share_icon ep_share_sina"></i>
                                            <span class="share_way">新浪微博</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="share_9939 ntshare_qzone" title="分享到QQ空间" target="_blank" data-url='<?php echo $url; ?>' data-text="<?php echo $v['title']; ?>" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo $v['url'] ?>">
                                            <i class="ep_share_icon ep_share_qzone"></i>
                                            <span class="share_way">腾讯空间</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="share_9939 ntshare_youdao sfre" title="朋友圈" target="_self" data-url='<?php echo $url; ?>' data-text="<?php echo $v['title']; ?>" href="javascript:;">
                                            <i class="ep_share_icon ep_share_wenxin"></i>
                                            <span class="share_way">朋友圈</span>
                                        </a>
                                        <div class="secod">
                                            <h4>
                                                <a class="closw">X</a>
                                                分享到微信朋友圈
                                            </h4>
                                            <img src="http://qr.liantu.com/api.php?text=<?php echo $url; ?>" alt="" width="150" height="120"/>
                                            <p>打开微信，点击底部的“发现”，使用“扫一扫”即可将网页分享至朋友圈。</p>
                                        </div>
                                    </li>
                                </ul>	  
                            </span>
                        </div>
                        <a href="<?php echo $url;?>" title="<?php echo $title;?>"><?php echo $short_title; ?></a>
                    </h2>
                    <p><?php echo $descp;?><a href="<?php echo $url;?>">[详细]</a></p>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
<!--关于专题 end-->

<!--中间部分 begin-->
<div class="wrapper">
    <div class="leftbar fl"> 
        <?php $a_art_list = array_splice($arr_art_splice,0,8); ?>
        <?php if(!empty($a_art_list)) { ?>
            <?php $fst_art_list = array_splice($a_art_list, 4); ?>
            <?php if(!empty($a_art_list)) { ?>
                <div class="infoc">
                    <?php $tmp_sheng_arr = array_splice($a_art_list, 1); ?>
                    <?php if(!empty($a_art_list)){ 
                        foreach($a_art_list as $k=>$v){
                            $title = $v['title'];
                            $url = $v['url'];
                            $descp = String::cutString($v['description'], 90, 1);
                            $short_title = String::cutString($title, 18, 0);
                        ?>
                        <h2><a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php echo $short_title; ?></a></h2>
                        <?php } ?>
                    <?php } ?>
                    <?php if(!empty($tmp_sheng_arr)){ ?>
                        <ul>
                            <?php foreach($tmp_sheng_arr as $k=>$v){ 
                                    $title = $v['title'];
                                    $url = $v['url'];
                                    $descp = String::cutString($v['description'], 90, 1);
                                    $short_title = String::cutString($title, 18, 0);
                                ?>
                                <li><a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php echo $short_title; ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if(!empty($fst_art_list)) { ?>
                <div class="infoc">
                    <?php $tmp_sheng_arr = array_splice($fst_art_list, 1); ?>
                    <?php if(!empty($fst_art_list)){ 
                        foreach($fst_art_list as $k=>$v){
                            $title = $v['title'];
                            $url = $v['url'];
                            $descp = String::cutString($v['description'], 90, 1);
                            $short_title = String::cutString($title, 18, 0);
                        ?>
                        <h2><a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php echo $short_title; ?></a></h2>
                        <?php } ?>
                    <?php } ?>
                    <?php if(!empty($tmp_sheng_arr)){ ?>
                        <ul>
                            <?php foreach($tmp_sheng_arr as $k=>$v){ 
                                    $title = $v['title'];
                                    $url = $v['url'];
                                    $descp = String::cutString($v['description'], 90, 1);
                                    $short_title = String::cutString($title, 18, 0);
                                ?>
                                <li><a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php echo $short_title; ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>
        <?php $a_art_list = array_splice($arr_art_splice,0,12); ?>
        <?php if(!empty($a_art_list)){ ?>
            <ul class="deinl">
                <?php foreach($a_art_list as $k=>$v) { 
                         $title = $v['title'];
                        $url = $v['url'];
                        $descp = String::cutString($v['description'], 90, 1);
                        $short_title = String::cutString($title, 18, 0);
                    ?>
                    <li><a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php echo $short_title; ?></a></li>
                <?php } ?>
            </ul>
        <?php } ?>
        
        <?php if(!empty($model['mid_ads_text'])) { ?>
            <div>
                <?php echo $model['mid_ads_text']; ?>
            </div>
        <?php } ?>
        
        <div class="childre">
            <h3><span><?=$detail['cn_key_name']?></span>热门问答</h3>
            <?php if(!empty($ask_list)) { ?>
                <ul class="serie">
                    <?php foreach($ask_list as $k=>$v) { 
                            $title =  strip_tags($v['title']);
                            $short_title =  String::cutString($title, 14);
                            $ctime = $v['cntime'];
                            $url = $v['askurl'];
                        ?>
                        <li><span><?php echo $ctime; ?></span><a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php echo $short_title; ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <div class="inqex">
            <ul>
                <?php
                if(!empty($model['mid_ads_docs'])){
                    foreach ($model['mid_ads_docs'] as $key => $value) {
                        echo $value['text'];
                    }
                }
                ?>
            </ul>
            <div>推荐专家</div>
        </div>
        <div class="wd_pd">
            <div class="wd_pd_z">
                <div class="bdisea clearfix">
                    <a class="" style="text-decoration:none;">热门科室</a>
                    <a class="indexahover" style="text-decoration:none;">热门部位</a>
                </div>
                <div class="wd_qh disn">
                    <div class="disesl">
                        <?php
                        if (isset($disease_list['departmentDis']) && !empty($disease_list['departmentDis'])) {
                            ?>
                            <div class="syname fl">
                                <?php
                                foreach ($disease_list['departmentDis'] as $key => $departmentDis){
                                    $class = ($key == 0) ? 'indexahover': '';
                                    $depURL = 'http://jb.9939.com/jbzz/'. $departmentDis['department']['pinyin'] .'/';
                                    ?>
                                    <a class="<?php echo $class; ?>" href="<?php echo $depURL; ?>">
                                        <?php echo $departmentDis['department']['name']; ?>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                          <div class="prout">
                              <?php foreach ($disease_list['departmentDis'] as $key => $departmentDis){
                                  $ulClass = ($key == 0) ? 'shc' : 'disn';
                                  ?>
                                  <ul class="power fr <?php echo $ulClass; ?>">
                                      <?php foreach($departmentDis['disease'] as $innerKey => $disease) {
                                          $name = $disease['name'];
                                          $url = 'http://jb.9939.com/' . $disease['pinyin_initial'] . '/';
                                          $short_name = String::cutString($name, 7,0);
                                          ?>
                                          <li><a href="<?php echo $url;?>" title="<?php echo $name;?>"><?php echo $short_name;?></a></li>
                                      <?php } ?>
                                  </ul>
                                  <?php
                              }?>
                          </div>
                            <?php
                        }
                        ?>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="wd_qh shc">
                    <div class="disesl">
                        <?php
                        if (isset($disease_list['partSymptom']) && !empty($disease_list['partSymptom'])) {
                            ?>
                            <div class="syname fl">
                                <?php
                                foreach ($disease_list['partSymptom'] as $key => $partSymptom){
                                    $class = ($key == 0) ? 'indexahover': '';
                                    $partURL = 'http://jb.9939.com/jbzz/'. $partSymptom['part']['pinyin'] .'/';
                                    ?>
                                    <a class="<?php echo $class; ?>" href="<?php echo $partURL; ?>">
                                        <?php echo $partSymptom['part']['name']; ?>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="prout">
                                <?php foreach ($disease_list['partSymptom'] as $key => $partSymptom){
                                    $ulClass = ($key == 0) ? 'shc' : 'disn';
                                    ?>
                                    <ul class="power fr <?php echo $ulClass; ?>">
                                        <?php foreach($partSymptom['symptom'] as $innerKey => $symptom) {
                                            $name = $symptom['name'];
                                            $url = 'http://jb.9939.com/zhengzhuang/' . $symptom['pinyin_initial'] . '/';
                                            $short_name = String::cutString($name, 7,0);
                                            ?>
                                            <li><a href="<?php echo $url;?>" title="<?php echo $name;?>"><?php echo $short_name;?></a></li>
                                        <?php } ?>
                                    </ul>
                                    <?php
                                }?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rightbar fr">
        <div class="borin">
            <script type="text/javascript">
                var cpro_id = "u2316046";
                (window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id] = {at: "3", rsi0: "300", rsi1: "250", pat: "17", tn: "baiduCustNativeAD", rss1: "#FFFFFF", conBW: "1", adp: "1", ptt: "0", titFF: "%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91", titFS: "14", rss2: "#000000", titSU: "0"}
            </script>
            <script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
        </div>
        
        <div class="borin paval">
            <h3><span></span>最新疾病资讯</h3>
            <ul class="medi">
            <?php if(!empty($diseaseArticle)) { ?>
                <?php foreach($diseaseArticle as $k=>$v) {
                    $title = $v['title'];
                    $short_title = String::cutString($title, 14,0) ;
                    $date_path = date('Y/md',$v['inputtime']);
                    $article_path = sprintf("%s/%s/%d.shtml",'article',$date_path,$v['id']);
                    $url = sprintf('%s/%s',Yii::getAlias("@jb_domain"), $article_path);
                ?>
                    <li><a  href="<?php echo $url; ?>" title="<?php echo $title;?>"><?php echo $short_title;?></a></li>
                <?php } ?>
            <?php } ?>
            </ul>
        </div>
        <div class="borin paval">
            <h3><span></span>相关疾病资讯</h3>
            <?php if(!empty($arr_art_splice)){ ?>
                <ul class="medi">
                    <?php foreach($arr_art_splice as $k=>$v) { 
                             $title = $v['title'];
                            $url = $v['url'];
                            $descp = String::cutString($v['description'], 90, 1);
                            $short_title = String::cutString($title, 18, 0);
                        ?>
                        <li><a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php echo $short_title; ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <div class="borin paval">
            <h3><span></span>推荐医院</h3>
            <ul class="hostp">
                <?php if(!empty($model['hospital_ads_text'])) { ?>
                    <div>
                        <?php echo $model['hospital_ads_text']; ?>
                    </div>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!--中间部分 end-->

<script>
$(function(){
    //微信分享    
    $('.sfre').click(function () {
        $(this).parent().find('.secod').show();
    });
    $('.closw').click(function () {
        $(this).parent().parent().hide();
        $(this).parent().parent().parent().parent().show();
    });
});  
</script>

<?php
    //底部随机热词
    echo $this->render("inc_randwords",[
        'URL'           => $URL,
        'randwords'     => $model['randwords'],
    ]);
?>
<?php
    //底部带logo
    echo $this->render("inc_footer_logo");
?>
<?php echo $this->render("/include/baidu_cnzz_statictis"); ?>
<?php echo $this->render("/include/baidu_push"); ?>
<?php
    //统计代码，自动推送代码等
    echo $this->render("inc_stat_push_other");
?>