<!-- 疾病预防 -->

<?php
$diseaseName = $disease['name'];
$this->title =  "${diseaseName}预防_如何预防${diseaseName}_预防${diseaseName}的措施_疾病百科_久久健康网";
$this->metaTags = [
    'keywords' => "${diseaseName}预防,如何预防${diseaseName},预防${diseaseName}的措施",
    'description' => "久久健康网-疾病百科频道提供专业、全面的${diseaseName}预防、如何预防${diseaseName}、预防${diseaseName}的措施等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！",
];
?>

<!-- 首页导航 Start -->
<?php echo $this->render('index_nav', ['disease' => $disease]); ?>
<!-- 首页导航 End -->

<div class="conter">
    <div class="disea fl">
        <div class="tost nickn bshare spread graco"><h2><span><?php echo $disease['name']; ?></span>预防措施：</h2>
            <p class="spea"><?php echo str_replace(PHP_EOL,"</p><p style='text-indent:2em'>",$disease['prevent']); ?></p>

            <!-- 分享 Start -->
            <?php echo $this->render('share', ['title' => $disease['name']]); ?>
            <!-- 分享 End -->
        </div>
        <p class="wartip mabot">（温馨提示：以上资料仅供参考，具体情况请向医生详细咨询）</p>
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
        <div class="tost nickn reart"><h2><span><?php echo $disease['name']; ?></span>预防文章</h2>
            <ul class="artcl">
                <?php
                if (isset($preventArticles) && !empty($preventArticles)) {
                    foreach ($preventArticles as $preventArticle){
                        ?>
                        <li>
                            <a href="/<?php echo $preventArticle['url']; ?>" title="<?php echo $preventArticle['title']; ?>">
                                <?php echo $preventArticle['title']; ?>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <div class="rela_a a_labe">
            <div class="a_rea a_hop a_mar">
                <h2><b>猜你感兴趣</b></h2>
                <div class="aplces">
                    <?php echo $this->render('ads_cngxq'); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- 首页右侧部分 Start -->
    <?php echo $this->render('index_right'); ?>
    <!-- 首页右侧部分 End -->

    <div class="clear"></div>
</div>

