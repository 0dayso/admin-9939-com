
<?php
$diseaseName = $disease['name'];
$this->title =  "${diseaseName}图片_${diseaseName}症状图片_${diseaseName}图片大全_疾病百科_久久健康网";
$this->metaTags = [
    'keywords' => "${diseaseName}图片,${diseaseName}症状图片,${diseaseName}图片大全",
    'description' => "久久健康网-疾病百科频道提供专业、全面的${diseaseName}图片、${diseaseName}症状图片、${diseaseName}图片大全等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！",
];
?>

<!-- 文章页导航 Start -->
<?php echo $this->render('detail_nav', ['disease' => $disease]); ?>
<!-- 文章页导航 End -->


<div class="art_wra camat">
    <div class="art_l">
        <div class="art_t imcol">
            <h1>
                <?php echo $disease['name']; ?>图集
                <input type="hidden" id="tujiPYInitial" value="<?php echo $disease['pinyin_initial']; ?>" />
            </h1>
            <p><span>2013-11-19 疾病百科</span>
                <!-- 分享部分 Start -->
                <?php echo $this->render('disease_share', ['flag' => 1, 'title' => $disease['name']]); ?>
                <!-- 分享部分 End -->
            </p>
        </div>

        <!-- 栏目关注 -->
        <div class="a_care">
            <?php echo $this->render('detail_content_channel_care'); ?>
        </div>
        <div class="a_rea a_hop a_mar">
            <div class="adpal">
                <?php echo $this->render('detail_content_upper_ad'); ?>
            </div>
        </div>
        <div class="imcle">
            <span class="preim"><a><img src="/images/leftc.png"></a></span>
            <div class="picsh">
                <?php
                if (isset($imagesList) && !empty($imagesList)) {
                    foreach ($imagesList as $image){
                ?>
                        <img src="<?php echo $image['url']; ?>" alt="" title="" class="cusri">
                <?php
                    }
                }
                ?>
            </div>
            <span class="nexim"><a><img src="/images/righc.png"></a></span>
            <div class="lefrig">
                <div class="lef_01"></div>
                <div class="lef_02"></div>
            </div>
        </div>
        <ul class="patrn">
            <?php echo $paging->view();?>
            <input type="hidden" id="tujiTotal" value="<?php echo $paging->getTotal(); ?>" />
        </ul>

        <div>
            <?php echo $this->render('detail_content_floor_ad'); ?>
        </div>

        <!-- 分享部分 Start -->
        <?php echo $this->render('disease_share', ['flag' => 2, 'title' => $disease['name']]); ?>
        <!-- 分享部分 End -->

        <!-- 文章内容下面部分 Start -->
        <?php echo $this->render('detail_below', ['relArticles' => $relArticles, 'asks' => $asks, 'title' => $disease['name'], 'disease' => $disease, 'stillFind' => $stillFind]); ?>
        <!-- 文章内容下面部分 End -->
    </div>

    <!-- 文章右侧部分 Start -->
    <?php echo $this->render('detail_right', ['relArticles' => $relArticles, 'lastestArticles' => $lastestArticles]); ?>
    <!-- 文章右侧部分 End -->
</div>

<!-- 文章底部部分 Start -->
<?php echo $this->render('detail_bottom'); ?>
<!-- 文章底部部分 End -->

<script src="/js/article/disease_images.js"></script>
