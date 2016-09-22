<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'] = [
    [
        'label' => '内容管理',
        'url' => Url::to(['/cms/']),
    ],
    [
        'label' => '疾病文章管理',
        'url' => Url::to(['/cms/article/']),
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
    <div class="d-titr"><a href="<?php echo Url::to(['/cms/article/index']); ?>">返回</a><h3>疾病资讯 -- 编辑资讯</h3></div>
    
    <?php
    echo $this->render('_form', [
        'model' => $model,
        'action' => Url::to(['/cms/article/edit']),
    ])
    ?>
    
</div>