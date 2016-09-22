<?php
use librarys\helpers\utils\String;
?>
<!-- 文章正文 下面部分 -->

<div class="a_info neinf">
    <div>
        <div class="a_rea a_hop">
            <h2>
                <span><a href="http://jb.9939.com/article_list.shtml">更多文章>></a></span>
                与“<font style="color:#F00"><?php echo String::cutString($title, 8, 1)?></font>”相似的文章
            </h2>
            <ul class="a_prev">
                <?php
                if (isset($relArticles['list']) && !empty($relArticles['list'])) {
                    $leftRelArticles = array_splice($relArticles['list'], 0, 12);
                    foreach ($leftRelArticles as $relArticle){
                ?>
                        <li>
                            <a href="<?php echo '/article/'.date("Y/md", $relArticle["inputtime"]).'/'.$relArticle['id'].'.shtml' ; ?>" title="<?php echo $relArticle['title']; ?>"><?php echo $relArticle['title']; ?></a>
                        </li>
                <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div>
        <div class="a_rea a_hop inpc">
            <h2>
                <span>
                    <a href="http://ask.9939.com/asking/" class="inqu">我要提问</a>
                    <a href="http://ask.9939.com/">更多问答>></a>
                </span>
                <img src="/images/pi_02.png">
            </h2>
            <ul class="a_mon">
            	<?php
                if (isset($asks['list']) && !empty($asks['list'])) {
                    foreach ($asks['list'] as $outerKey => $outerAsk){
                ?>
                <li>
                    <h3>
	                    <a href="<?php echo \yii\helpers\Url::to('@ask/id/' . $outerAsk['ask']['id']); ?>" title="<?php echo $outerAsk['ask']['title']; ?>">
	                    	<?php echo $outerAsk['ask']['title']; ?>
	                    </a>
                    </h3>
                    <p>
                    <?php
                                    if (isset($outerAsk['answer']) && !empty($outerAsk['answer'])) {
                                        ?>
                                        <?php echo \librarys\helpers\utils\String::cutString($outerAsk['answer']['content'], 54); ?>
                                        <?php
                                    }
                                    ?>
                    <a href="<?php echo \yii\helpers\Url::to('@ask/id/' . $outerAsk['ask']['id']); ?>">详细</a>
                    </p>
                </li>
                <?php 
                    }
                }   
                ?>
            </ul>
        </div>
    </div>
    
    
    <?php
    if (isset($disease) && !empty($disease)) {
        ?>
        <!--热门疾病-->
        <div class="a_rea a_hop inpc" style="background: none;">
            <h2>
                    <span>
                        <?php
                            if (isset($isSymptom) && $isSymptom == 1) {
                        ?>
                                <a href="/zhengzhuang/<?php echo $disease['pinyin_initial']; ?>/jiancha/">更多&gt;&gt;</a>
                        <?php
                            }else {
                        ?>
                                <a href="/<?php echo $disease['pinyin_initial']; ?>/lcjc/">更多&gt;&gt;</a>
                        <?php } ?>
                    </span>
                <img src="/images/reche.gif">
            </h2>
            <div class="nipat">
                <?php
                    if (isset($isSymptom) && $isSymptom == 1){
                ?>
                        <h3><?php echo $disease['name']; ?><span>症状</span></h3>
                        <p><?php echo String::cutString($disease['examine'], 100); ?>
                            <a href="/zhengzhuang/<?php echo $disease['pinyin_initial']; ?>/jiancha/">详细</a>
                        </p>
                <?php
                    }else {
                ?>
                        <h3><?php echo $disease['name']; ?><span>疾病</span></h3>
                        <p><?php echo String::cutString($disease['inspect'], 100); ?>
                            <a href="/<?php echo $disease['pinyin_initial']; ?>/lcjc/">详细</a>
                        </p>
                <?php
                    }
                ?>
            </div>
        </div>
    <?php } ?>
    <div class="a_rea a_hop inpc" style="background: none;">
        <h2>
            <img src="/images/everb.gif">
        </h2>
        <?php
        if (isset($disease) && !empty($disease)) {
            ?>
            <ul class="finin clearfix">
                <?php
                if (isset($stillFind) && !empty($stillFind)) {
                    foreach ($stillFind as $find){
                        ?>
                        <li>
                            <a href="http://jb.9939.com/so/<?php echo $find['pinyin']; ?>/" title="<?php echo $find['keywords']; ?>">
                                <?php echo $find['keywords']; ?>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <?php
        }
        ?>
    </div>

    <!-- 图谱部分 Start -->
    <?php echo $this->render('detail_below_pic'); ?>
    <!-- 图谱部分 End -->
    
</div>