<?php
use yii\helpers\Url;

$this->title = $disease['name'] . '相关解答_' . $disease['name'] . '相关文章_疾病百科_久久健康网';
$this->metaTags['keywords'] = $disease['name'] . '相关解答,' . $disease['name'] . '相关文章';
$this->metaTags['description'] = '久久健康网-疾病百科频道提供专业、全面的' . $disease['name'] . '相关解答、' . $disease['name'] . '相关文章等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
?>

<?php
echo $this->render('index_nav', [
    'disease' => $disease,
]);
?>

    <!--引入头部 End-->
    <div class="art_wra erupt">
        <div class="art_l">
            <div class="tost bshare reati todi spread graco">
                <h2><span><?php echo $disease['name'];?></span>相关文章</h2>
                <p><?php echo $disease['description'];?></p>
            </div>

            <!--相关资讯-->
            <div class="a_info">
                <h3 class="toimg">
                    <?php
                    //1 症状 2 病因 3 检查 4 鉴别 5 治疗 6 护理 7 饮食 8 并发症
                    //1 症状 2 病因 3 检查 4 鉴别 5 治疗 6 饮食护理 7 预防 8 并发症
                    $arrtype = [
                        '0' => '全部文章',
                        '1' => '症状',
                        '2' => '病因',
                        '3' => '检查',
                        '4' => '鉴别',
                        '5' => '治疗',
                        '6' => '饮食护理',
                        '7' => '预防',
                        '8' => '并发症',
                    ];
                    foreach ($arrtype as $k => $v) {
                        $indexahover = ($type == $k) ? 'indexahover' : '';
                        ?>
                        <a href="/<?php echo $disease['pinyin_initial']; ?>/article_list<?php echo $k ? '_t' . $k : ''; ?>.shtml" name="n1Tab11" id="n1Tab11" class="<?php echo $indexahover; ?>" target="_self"><?php echo $v; ?></a>
                        <?php
                    }
                    ?>
                </h3>	
                <div name="n1Tab11Content" id="n1Tab11Content">
                    <ul class="newlis fitmou">
                        <!-- group -->
                        <?php
                        if (!empty($article)) {
                            foreach ($article as $k => $v) {
                                $url = '/article/'.date("Y/md", $v["inputtime"]).'/'.$v['id'].'.shtml';
                                if ($k % 5 == 0) {
                                    echo '<li><dl>';
                                }
                                echo '<dd><span>' . date('Y-m-d', $v['inputtime']) . '</span><a href="' . Url::to($url) .'" title="' . $v['title'] . '">' . $v['title'] . '</a></dd>';

                                if ($k % 5 == 4) {
                                    echo '</li></dl>';
                                }
                            }
                        }
                        ?>
                    </ul>
                    <div class="paget paint">
                        <?php echo $paging->view();?>
                    </div>
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
        </div>
        
        <!--右侧部分 start-->
        <?php
        echo $this->render('index_right');
        ?>
        <!--右侧部分 end-->

    </div>
   
    <div class="conet">
        <!--英文字母列表-->
        <?php
        $model['currLetter'] = strtoupper($disease['pinyin_initial']{0}); //拼音简写的第一个字母
        $model['randWords'] = $hotWords;
        echo $this->render('/include/foot_zimu', [
            'model' => $model,
        ]);
        ?>
    </div>
    <script type="text/javascript" src="<?php echo Url::to('@jb_domain/js/disease/list.js') ?>"></script>
