
<?php
$diseaseName = $disease['name'];
$this->title =  "${diseaseName}_${diseaseName}的症状_${diseaseName}治疗方法_${diseaseName}用药_疾病百科_久久健康网";
$this->metaTags = [
    'keywords' => "${diseaseName},${diseaseName}的症状,${diseaseName}治疗方法,${diseaseName}用药",
    'description' => "久久健康网-疾病百科频道提供专业、全面的${diseaseName}、${diseaseName}的症状、${diseaseName}治疗方法、${diseaseName}用药等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！",
];
?>

<!-- 首页导航 Start -->
<?php echo $this->render('index_nav', ['disease' => $disease]); ?>
<!-- 首页导航 End -->

<!-- 首页主内容部分 Start -->
<?php echo $this->render('index_main',
    [
        'disease' => $disease,
        'symptoms' => $symptoms,
        'allReads' => $allReads,
        'asks' => $asks,
        'v2snsKeshiID' => $v2snsKeshiID,
        'doctors' => $doctors,
    ]
); ?>
<!-- 首页主内容部分 End -->

<!-- 首页专题部分 Start -->
<div class="conet">
    <?php
    $model['currLetter'] = strtoupper($disease['pinyin_initial']{0});//拼音简写的第一个字母
    $model['randWords'] = $model['randWords'];
    echo $this->render('/include/foot_zimu',[
        'model'=>$model
    ]);
    ?>
</div>
<!-- 首页专题部分 End -->

