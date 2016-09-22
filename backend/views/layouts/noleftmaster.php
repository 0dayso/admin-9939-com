<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?=Yii::$app->charset; ?>">
    <title><?= Html::encode($this->title); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/bootstrap/css/bootstrap_9939.css')?>">
    <link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/body.css')?>">
    <script type="text/javascript" src="<?php echo Url::to('@domain/js/jquery-1.7.2.min.js')?>"></script>
    <script type=text/javascript src="<?php echo Url::to('@domain/js/detail.js')?>"></script>
    <?php $this->head(); ?>
</head>

<?=$this->beginBody()?>
<body style="background:#ecf0f1;">
	<!-- 头部 Start -->
	<div class="header">
		<div class="inde_l fl">
			<a href="javascript:"><img src="<?php echo Url::to('@domain/images/inlogo.png')?>" alt="" title=""></a>
		</div>
		<div class="lonan fl">
            <p><?php echo $this->context->user->getDisplayName(); ?></p>
			<ul class="domenu">
				<li><img src="<?php echo Url::to('@domain/images/info_01.png')?>"><a href="">个人资料</a></li>
				<li><img src="<?php echo Url::to('@domain/images/info_02.png')?>"><a href="">修改密码</a></li>
				<li><img src="<?php echo Url::to('@domain/images/info_03.png')?>"><a href="/site/logout">退出系统</a></li>
			</ul>
		</div>
		<div class="topna fr">
            <?php 
            $curr_module_func = array();
            $mvc_info = $this->context->helpGetDispatchPath();
            $my_funcs = $this->context->user->getMyFunc();
            $is_super = $this->context->user->is_super;
            ?>
			<?php foreach($this->context->funclist as $k=>$v) { 
                if(isset($my_funcs[$v['id']])|| $is_super){
                    $curr_flag = strtolower($mvc_info['module'])===strtolower($v['moduleid']);
                    $classname = $curr_flag? 'class="curr"':'';
                    if($curr_flag){
                        $curr_module_func=$v;
                    }
                    ?>
                    <a href="<?php echo Url::toRoute($v['url']); ?>" <?php echo $classname; ?> >
                        <div>
                             <img src="<?php echo Url::to("@domain/{$v['bigicon']}");?>">
                        </div><?php echo $v['caption']; ?>
                    </a>
                <?php } ?>
            <?php } ?>
		</div>
		<div class="clear"></div>
	</div>
	<!-- 头部 End -->
    <!-- 主体内容部分 Start -->
    <?= $content ?>
    <!-- 主体内容部分 End -->
    <div class="folog">
        <p><?php echo Yii::$app->params['copyright']; ?></p>
    </div>
</body>
<?=$this->endBody()?>

</html>