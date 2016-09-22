<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->params['name'] = $info['name'];
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?= Html::encode($this->title['title']) ?></title>
        <meta name="keywords" content="<?= Html::encode($this->title['keywords']) ?>" />
        <meta name="description" content="<?= Html::encode($this->title['description']) ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <script src="/js/jquery-1.11.2.min.js"></script>
        <script src="/js/detail.js"></script>
        <!--slide滚动-->
        <script type="text/javascript" src="/js/jquery.event.drag-1.5.min.js"></script>
        <script type="text/javascript" src="/js/jquery.touchSlider.js"></script>
        <script src="/js/slide.js"></script>
        <!--ends-->
    </head>
    <body>
        <article class="head"><a href="<?php echo Url::home(true) ?>"></a><span><?php echo $info['name'];?></span><a href="" class="setn"></a><a class="clna"></a></article>
        <!--导航栏展开 start-->
        <?php echo $this->render('/include/navigation'); ?>
        <!--导航栏展开 ends-->
        <?php echo $this->render('inc_nav', ['pinyin_initial' => $info['pinyin_initial']]); ?>
        <div class="merod"><p>暂无</p><p>药品内容正在路上~</p></div>
        <!--<ul class="stati ndrug"><li><a href=""><img src="images/dru_01.jpg" alt=""></a><div><h3><a href="">小快克小儿氨酚黄那敏颗粒小儿氨酚黄那敏颗粒小快快小快快</a></h3><p>主治功效：小儿感冒,小儿流行性感冒,流行性感冒，急性上呼吸道感染,呼吸道急性上呼吸道感染,呼吸道</p><p>北京万生药业有限责任公司</p></div></li><li><a href=""><img src="images/dru_02.jpg" alt=""></a><div><h3><a href="">小快克小儿氨酚黄那敏颗粒小儿氨酚</a></h3><p>主治功效：小儿感冒,小儿流行性感冒,流行性感冒，急性上呼吸道感染,呼吸道急性上呼吸道感染,呼吸道</p><p>北京万生药业有限责任公司</p></div></li><li><a href=""><img src="images/dru_03.jpg" alt=""></a><div><h3><a href="">小快克小儿氨酚黄那敏颗粒小小快</a></h3><p>主治功效：小儿感冒,小儿流行性感冒,流行性感冒，急性上呼吸道感染,呼吸道急性上呼吸道感染,呼吸道</p><p>北京万生药业有限责任公司</p></div></li><li><a href=""><img src="images/dru_01.jpg" alt=""></a><div><h3><a href="">小快克小儿氨酚黄那敏敏颗粒小快</a></h3><p>主治功效：小儿感冒,小儿流行性感冒,流行性感冒，急性上呼吸道感染,呼吸道急性上呼吸道感染,呼吸道</p><p>北京万生药业有限责任公司</p></div></li><li><a href=""><img src="images/dru_01.jpg" alt=""></a><div><h3><a href="">小快克小儿氨酚黄那敏颗粒小儿氨酚黄那敏颗粒小快快小快快</a></h3><p>主治功效：小儿感冒,小儿流行性感冒,流行性感冒，急性上呼吸道感染,呼吸道急性上呼吸道感染,呼吸道</p><p>北京万生药业有限责任公司</p></div></li><li><a href=""><img src="images/dru_02.jpg" alt=""></a><div><h3><a href="">小快克小儿氨酚黄那敏颗粒小儿氨酚</a></h3><p>主治功效：小儿感冒,小儿流行性感冒,流行性感冒，急性上呼吸道感染,呼吸道急性上呼吸道感染,呼吸道</p><p>北京万生药业有限责任公司</p></div></li><li><a href=""><img src="images/dru_03.jpg" alt=""></a><div><h3><a href="">小快克小儿氨酚黄那敏颗粒小小快</a></h3><p>主治功效：小儿感冒,小儿流行性感冒,流行性感冒，急性上呼吸道感染,呼吸道急性上呼吸道感染,呼吸道</p><p>北京万生药业有限责任公司</p></div></li><li><a href=""><img src="images/dru_01.jpg" alt=""></a><div><h3><a href="">小快克小儿氨酚黄那敏敏颗粒小快</a></h3><p>主治功效：小儿感冒,小儿流行性感冒,流行性感冒，急性上呼吸道感染,呼吸道急性上呼吸道感染,呼吸道</p><p>北京万生药业有限责任公司</p></div></li></ul>
        <article class="metho"><a>品牌<span></span></a><a>医保<span></span></a><a>处方<span></span></a><a>类型<span></span></a></article>
        <div class="oubra disn"></div>
        <div class="nolim">
            <div class="brand disn"><a>不限</a><a>益佰</a><a>同仁堂</a><a>万通</a><a>康德科</a><a>益生堂</a><a>同仁堂</a><a>万通</a><a>康德科</a><a>益生堂</a><a>同仁堂</a></div>
            <div class="brand disn"><a>不限</a><a>医保</a><a>非医保</a></div>
            <div class="brand disn"><a>不限</a><a>处方</a><a>非处方</a></div>
            <div class="brand disn"><a>不限</a><a>中药</a><a>西药</a><a>中成药</a></div>
        </div>-->

    </body>
</html>

