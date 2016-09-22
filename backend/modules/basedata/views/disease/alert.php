<?php
use yii\helpers\Url;
?>

<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<div id="message"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<script>
	$(function(){
		$('#dialog').dialogBox({
			width:400,
			hasClose: false,
			effect: 'fade',
			hasBtn: true,
			type: 'correct',
			confirmValue: "确定",  //确定按钮文字内容
			cancelValue: null,  //取消按钮文字内容
			confirm:function(){
				//如果更新成功，跳转到 列表页：
				<?php 
				if ($promptFlag == 1) {
				?>
				window.location.href = "/basedata/disease/";
				
				<?php 	
				}else{
				//如果失败，返回到当前的编辑页：
				?>
				history.back();
				<?php 	
				}
				?>
			},
			title: '更新提示',
			content: '<?php echo $operation;?>疾病信息：<?php echo $promptMsg;?>'
		});
	});
</script>

