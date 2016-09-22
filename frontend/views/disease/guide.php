<?php

use yii\helpers\Url;

$this->title = $disease['name'] . '挂什么科_' . $disease['name'] . '就诊流程指南_疾病百科_久久健康网';
$this->metaTags['keywords'] = $disease['name'] . '挂什么科,' . $disease['name'] . '就诊流程指南';
$this->metaTags['description'] = '久久健康网-疾病百科频道提供专业、全面的' . $disease['name'] . '挂什么科、' . $disease['name'] . '就诊流程指南等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
?>
<!-- 导航条 start -->
<?php
echo $this->render('index_nav', [
    'disease' => $disease,
    ]);
?>


<div class="conter">
    <div class="disea fl">
        
        <div class="tost bshare spread graco">
            <h2><span><?php echo $disease['name'];?></span>就诊指南</h2>
            
            <!--  分享 -->
            <?php echo $this->render('share',['title'=>$this->title]);?>
            <!--  分享 -->
            
            <div class="defin">
                <b>典型症状</b><p><?php echo $disease['typical_symptom'];?></p>
                <ul class="clicl">
                    <li><b>建议就诊科室：</b><p><?php echo $disease['treat_department'];?></p></li>
                    <li><b>易感人群：</b><p><?php echo $disease['yiganrenqun'];?></p></li>
                    <li><b>传染方式：</b><p><?php echo $disease['chuanranfangshi'];?></p></li>
                    <li><b>治疗方式：</b><p><?php echo $disease['treatment'];?></p></li>
                </ul>
                
                <b>常见问诊内容</b>
                <p class="spea"><?php echo $disease['inspect_item'];?></p>
                
                <b>重点检查项目</b>
                <p class="spea"><?php echo $disease['inspect'];?></p>
                
                <b>诊断鉴别</b>
                <p class="spea"><?php echo $disease['diagnosis'];?></p>
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
    
    <?php
    echo $this->render('index_right');
    ?>
    <div class="clear"></div>
</div>

