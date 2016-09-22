
<?php

use librarys\helpers\utils\String;

$this->title = $article['title'] . "_久久健康网";
$keywords = implode(',', $article['keywords']);
$content = strip_tags($article['content']);
$desc = empty($article['description']) ? String::cutString($content, 80, 0) : $article['description'];
$this->metaTags = [
    'keywords' => $keywords,
    'description' => $desc,
];
?>

<!-- 文章页导航 Start -->
<?php echo $this->render('detail_nav', ['disease' => $disease,'isSymptom'=>$isSymptom]); ?>
<!-- 文章页导航 End -->

<div class="art_wra camat">
    <div class="art_l">
        <div class="art_t"><h1><?php echo $article['title']; ?></h1>
            <p>
                <span>时间 : <?php echo $article['inputtime']; ?></span>
                <span>来源：<?php echo $article['copyfrom']; ?></span>
            </p>
        </div>

        <!-- 栏目关注 -->
        <div class="a_care smokin">
        <?php echo $this->render('detail_content_channel_care', ['disease' => $disease,'isSymptom'=>$isSymptom]); ?>
        </div>

        <div class="a_const abstra"><b>[摘要]</b>
            <p>
<?php echo $article['description']; ?>
            </p>
        </div>

        <div class="a_los">
<?php echo $this->render('detail_content_upper_ad'); ?>
        </div>

        <div class="a_bod">
            <?php
            $contetStr = $article['content'];

            //最终截取的位置数
            $SplitNum = 0;
            $lastOneNum = mb_strrpos($contetStr, '<p>', 'utf-8');

            if ($lastOneNum) {
                $SplitNum = $lastOneNum;

                $contetLastOneStr = mb_substr($contetStr, 0, $lastOneNum, 'utf-8');
                $lastSecondNum = mb_strrpos($contetLastOneStr, '<p>', 'utf-8');
                if ($lastSecondNum) {
                    $SplitNum = $lastSecondNum;

                    $contetLastThridStr = mb_substr($contetStr, 0, $lastSecondNum, 'utf-8');
                    $lastThridNum = mb_strrpos($contetLastThridStr, '<p>', 'utf-8');

                    if ($lastThridNum) {
                        $SplitNum = $lastThridNum;

                        $contetLastFourStr = mb_substr($contetStr, 0, $lastThridNum, 'utf-8');
                        $lastFourNum = mb_strrpos($contetLastFourStr, '<p>', 'utf-8');

                        if ($lastFourNum) {
                            $SplitNum = $lastFourNum;
                        }
                    }
                }
            }
            echo mb_substr($contetStr, 0, $SplitNum, 'utf-8');
            ?>
        </div>

        <div class="a_adv clearfix">
            <a style="float:left; margin:0 20px 10px 0;">
                <?php echo $this->render('ads_middle'); ?>
            </a>
            <div>
                <?php
                echo mb_substr($contetStr, $SplitNum, mb_strlen($contetStr, 'utf-8') - $SplitNum, 'utf-8');
                ?>
            </div>

            <!-- 广告位 Start -->
            <div class="a_los clearfix">
<?php echo $this->render('detail_content_floor_ad'); ?>
            </div>
            <!-- 广告位 End -->

            <ul class="laspa">
                <li><span>上一篇：</span>
                    <?php
                    if (isset($preArticle) && !empty($preArticle)) {
                        ?>
                        <a href="<?php echo '/article/' . date("Y/md", $preArticle["inputtime"]) . '/' . $preArticle['id'] . '.shtml'; ?>" title="<?php echo $preArticle['title']; ?>"><?php echo $preArticle['title']; ?></a>
                        <?php
                    }
                    ?>
                </li>
                <li><span>下一篇：</span>
                    <?php
                    if (isset($nextArticle) && !empty($nextArticle)) {
                        ?>
                        <a href="<?php echo '/article/' . date("Y/md", $nextArticle["inputtime"]) . '/' . $nextArticle['id'] . '.shtml'; ?>" title="<?php echo $nextArticle['title']; ?>"><?php echo $nextArticle['title']; ?></a>
                        <?php
                    }
                    ?>
                </li>
            </ul>
        </div>

        <div class="a_keyl">
            <div class="a_ke">
                <b>关键词:</b>
                <?php
                if (isset($article['keywords']) && !empty($article['keywords'])) {
                    foreach ($article['keywords'] as $keyword) {
                        ?>
                        <a href="http://so.9939.com/?kw=<?php echo $keyword; ?>"><?php echo $keyword; ?></a>
                        <?php
                    }
                }
                ?>
            </div>

            <!-- 分享部分 Start -->
<?php echo $this->render('share', ['title' => $article['title']]); ?>
            <!-- 分享部分 End -->

            <div class="clear"></div>
        </div>

        <!-- 文章内容下面部分 Start -->
<?php echo $this->render('detail_below', ['title' => $article['title'], 'relArticles' => $relArticles, 'asks' => $asks, 'disease' => $disease,'isSymptom'=>$isSymptom, 'stillFind' => $stillFind ]); ?>
        <!-- 文章内容下面部分 End -->

    </div>

    <!-- 文章右侧部分 Start -->
<?php echo $this->render('detail_right', ['relArticles' => $relArticles, 'lastestArticles' => $lastestArticles]); ?>
    <!-- 文章右侧部分 End -->
    <div class="clear"></div>
</div>
<!--1123-->

<!-- 文章热搜部分 Start -->
<?php echo $this->render('detail_hot', ['hotWords' => $hotWords, 'article' => $article, 'commonDisDep' => $commonDisDep]); ?>
<!-- 文章热搜部分 End -->

<!-- 文章底部部分 Start -->
<?php echo $this->render('detail_bottom'); ?>
<!-- 文章底部部分 End -->
