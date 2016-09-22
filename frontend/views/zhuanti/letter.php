<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$URL = $model['url'];
$list = $model['list'];
$paging = $model['paging'];
$currLetter = $model['letterNav']['curr_letter'];
?>

<?php
//引入导航
echo $this->render("inc_main_nav");
?>

<div class="conlay">
    <div class="conare">
        <div class="letin larang">
            <?php
            //字母导航
            echo $this->render("letterNav",[
                'letterNav' => $model['letterNav']
            ]);
            ?>
        </div>
        
        <div class="lincon">
            <div class="weboper">
                <span class="hea_01"><?php echo $model['letterNav']['curr_letter']?></span>
                <span class="hea_02">
                    <a href="http://jb.9939.com/">疾病百科</a>&gt;
                    <a href="<?php echo $URL->domainurl;?>" title="疾病专题">疾病专题</a>&gt;
                    <a href="<?php echo $URL->domainurl;?><?php echo $currLetter?>/" title="<?php echo $currLetter?>"><?php echo $currLetter?></a>
                </span>
            </div>
            
            <?php if (!empty($list)) { ?>
                <ul class="topinf"> 
                    <?php
                    foreach ($list as $k => $v) {
                        $name = $v['keywords'];
                        $short_name = $name;
                        $url = sprintf('%s%s/', $URL->searchurl, str_replace(' ', '', $v['pinyin']));
                        ?>
                        <li><a href="<?php echo $url; ?> " title="<?php echo $name; ?>"><?php echo $short_name; ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <div class="paget">
                <?php echo $paging->view(); ?>
            </div>
        </div>

        <div class="wrapper">
            <div class="letter cabor">
                <?php
                //字母导航
                echo $this->render("letterNav",[
                    'letterNav' => $model['letterNav']
                ]);
                ?>
            </div>
        </div>
    </div>
    <!--底部 开始-->
    
    <?php
        echo $this->render("/include/footer");
    ?>
</div>

<?php
//统计代码，自动推送代码等
echo $this->render("inc_stat_push_other");
?>