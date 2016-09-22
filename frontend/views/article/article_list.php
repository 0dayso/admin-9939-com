<?php

use yii\helpers\Url;

$this->title = '疾病文章_久久健康网';
?>

<?php
    echo $this->render('include/nav');
?>

<!--引入头部 End-->
<div class="art_wra erupt">
    <div class="art_l">
        <!--相关资讯-->
        <div class="a_info">
            <ul class="newlis">
                <!-- 5 * 8 -->
                <?php
                    if($article){
                        foreach ($article as $k => $v) {
                            $url = '/article/'.date("Y/md", $v["inputtime"]).'/'.$v['id'].'.shtml';
                            if($k%5 == 0){echo '<li><dl>';}
                            echo '<dd><span>'.  date("Y-m-d", $v["inputtime"]).'</span><a href="'.Url::to($url).'" title="'.$v['title'].'" target="_blank">'.$v['title'].'</a></dd>';
                            if($k%5 == 4){echo '</dl></li>';}
                        }
                    }
                ?>
                
            </ul>
            
            <div class="paget paint">
                <?php echo $paging->view();?>
            </div>
            <!--热门疾病-->

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
    </div>
    <!--右侧 start-->
        <?php echo $this->render('detail_right',['lastestArticles'=>$lastestArticles, 'isartlist' => true]); ?>
    <!--右侧 end-->

</div>
<!--字母 科室 start--> 
<div class="conet">
    <?php
    $model['currLetter'] = 'A';//拼音简写的第一个字母
    $model['randWords'] = $randWords;
    echo $this->render('/include/foot_zimu',[
        'model'=>$model
    ]);
    ?>
</div>
<!--字母 科室 end--> 
<script type="text/javascript" src="<?php echo Url::to('@jb_domain/js/article/list.js') ?>"></script>
