<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'] = [
    [
        'label' => '基础数据',
        'url' => Url::to(['/basedata/']),
    ],
    [
        'label' => '症状管理',
        'url' => Url::to(['/basedata/symptom/']),
    ],
    [
        'label' => Html::encode($this->title),
        'url' => 'javascript:void(0)',
        'template' => "<a>{link}</a>",
        'class' => 'bolde'
    ],
];
?>

<div class="dis-bread">
    <?php
    echo Breadcrumbs::widget([
        'itemTemplate' => "<a>{link}</a>&gt;",
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>
</div>

<div class="dis-main">
    <div class="d-titr clearfix"><a href="<?php echo Url::to(['/basedata/symptom/index']); ?>">返回</a><h3><?php echo Html::encode($this->title); ?></h3></div>


    <?php
    echo $this->render('_form', [
        'model' => $model,
        'allSymptom' => $allSymptom,
        'action' => Url::to(['/basedata/symptom/add']),
    ])
    ?>



</div>