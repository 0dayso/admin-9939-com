<?php
use yii\helpers\Url;
?>
<div class="nav">
    <div class="content-one">
        <div class="classf fl"><span></span>查找分类</div>
        <ul class="tnav fl">
            <li class="licu"><a href="<?=Url::to("@jb_domain")?>">首页</a></li>
            <li><a href="<?=Url::to("@jb_domain/jbzz/")?>">疾病症状</a></li>
            <li><a href="<?=Url::to("@jb_domain/zicha/jbzc/")?>">症状自查</a></li>
        </ul>
        <ul class="fhost fl">
            <li><a href="http://hospital.9939.com/">找医院</a></li>
            <li><a href="http://yisheng.9939.com/">找医生</a></li>
            <li><a href="http://yiyao.9939.com/">找药品</a></li>
        </ul>
        <div class="mobil fr"><span>移动端：</span><span class="sp_02"></span><a href="http://m.jb.9939.com/">手机站</a></div>
        <div class="clear"></div>
    </div>
</div>