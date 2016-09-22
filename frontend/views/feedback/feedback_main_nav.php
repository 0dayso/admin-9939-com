<?php
	use yii\helpers\Url;
?>
<div class="nav">
	<div class="content">
        <ul class="tnav clind fl"><li><a href="<?php echo Url::to('@jb_domain' , true);?>">首页</a></li><li class="licu"><a href="<?php echo Url::to('@jb_domain/jbzz/' , true);?>">疾病症状</a></li><li><a href="<?php echo Url::to('@jb_domain/zicha/jbzc/' , true);?>">症状自查</a></li></ul>
        <ul class="fhost finho fl"><li><a href="http://hospital.9939.com">找医院</a></li><li><a href="http://yisheng.9939.com">找医生</a></li><li><a href="http://yiyao.9939.com">找药品</a></li></ul>
        <div class="mobil fr"><span>移动端：</span><span class="sp_02"></span><a href="http://m.jb.9939.com">手机站</a></div>
        <div class="clear"></div>
	</div>
</div>