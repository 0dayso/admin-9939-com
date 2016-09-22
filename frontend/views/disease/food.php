<!-- 疾病饮食护理 -->

<?php
$diseaseName = $disease['name'];
$this->title =  "${diseaseName}的饮食_${diseaseName}吃什么好_${diseaseName}食疗食谱_疾病百科_久久健康网";
$this->metaTags = [
    'keywords' => "${diseaseName}的饮食,${diseaseName}吃什么好,${diseaseName}食疗食谱",
    'description' => "久久健康网-疾病百科频道提供专业、全面的${diseaseName}的饮食、${diseaseName}吃什么好、${diseaseName}食疗食谱等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！",
];
?>

<!-- 首页导航 Start -->
<?php echo $this->render('index_nav', ['disease' => $disease]); ?>
<!-- 首页导航 End -->

<div class="conter">
    <div class="disea fl">
        <div class="tost nickn bshare prevp spread graco">
            <h2><span><?php echo $disease['name']; ?></span>应该如何护理？</h2>
            <p class="spea"><?php echo str_replace(PHP_EOL,"</p><p style='text-indent:2em'>",$disease['food']); ?></p>

            <p class="wartip mabot">（温馨提示：以上资料仅供参考，具体情况请向医生详细咨询）</p>
            <!-- 分享 Start -->
            <?php echo $this->render('share', ['title' => $disease['name']]); ?>
            <!-- 分享 End -->
        </div>
        <div class="tost nickn reread"><h2>相关阅读</h2>
            <ul class="recon">
                <?php
                if (isset($relArticles) && !empty($relArticles)) {
                    foreach ($relArticles as $relArticle){
                        ?>
                        <li>
                            <a href="/<?php echo $relArticle['url']; ?>" title="<?php echo $relArticle['title']; ?>">
                                <?php echo $relArticle['title']; ?>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <div class="pal">
                <?php echo $this->render('ads_xgrd'); ?>
            </div>
        </div>
        <div class="tost nickn reart"><h2><span><?php echo $disease['name']; ?></span>护理文章</h2>
            <ul class="artcl">
                <?php
                if (isset($foodArticles) && !empty($foodArticles)) {
                    foreach ($foodArticles as $foodArticle){
                        ?>
                        <li>
                            <a href="/<?php echo $foodArticle['url']; ?>" title="<?php echo $foodArticle['title']; ?>">
                                <?php echo $foodArticle['title']; ?>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <!-- 猜你感兴趣 start-->
        <div class="rela_a a_labe">
            <div class="a_rea a_hop a_mar">
                <h2><b>猜你感兴趣</b></h2>
                <div class="aplces">
                    <?php echo $this->render('/ads/common/ads_interest'); ?>
                </div>
            </div>
        </div>
        <!-- 猜你感兴趣 end-->
    </div>
    <!-- 首页右侧部分 Start -->
    <?php echo $this->render('index_right'); ?>
    <!-- 首页右侧部分 End -->
    <div class="clear"></div>
</div>
