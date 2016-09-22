<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;

$cate_1 = array_slice($common_disease_population, 0, 3);
$cate_2 = array_slice($common_disease_population, 3, 3);
?>

<h2><a href="/chaxun/renqun/">更多<span>></span></a>人群常见疾病</h2>
<!--男性 女性 儿童 板块 start-->
<article class="sexn"><a class="curr">男性</a><a>女性</a><a>儿童</a></article>
<?php echo $this->render('inc_common_disease_population', ['category_disease_article' => $cate_1]); ?>
<!--男性 女性 儿童 板块 end-->

<!--老人  孕妇 职业病 板块 start-->
<article class="sexn"><a class="curr">老人</a><a>孕妇</a><a style="width:33.4%;">职业病</a></article>
    <?php echo $this->render('inc_common_disease_population', ['category_disease_article' => $cate_2]); ?>
<!--老人  孕妇 职业病 板块 end-->
