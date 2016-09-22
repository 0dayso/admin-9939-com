<?php
use yii\helpers\Url;
$this->title = "重置密码";
?>
<div class="dis-bread">
    <a href="<?php echo Url::home(); ?>">首页</a>>
    <a href="<?php echo Url::toRoute('default/index'); ?>">系统管理</a>>
    <a href="javascript:;" class="bolde">用户管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::toRoute('user/index'); ?>">返回</a>
        <h3>用户管理 -- 重置密码</h3>
    </div>
    <div class="row"  style="margin:10px;">
        <div class="col-md-8">
            <!-- BEGIN FORM-->
            <form action="<?php echo Url::toRoute('user/modpassword'); ?>" method="post" class="form-horizontal"  autocomplete = "off" class="form-horizontal form-bordered form-label-stripped">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">新密码</label>
                        <div class="col-md-9">
                            <input type="text" style="display:none" />
                            <input  id="password" name="password" size="30" type="password" placeholder="请输入密码" autocomplete="off" class="form-control"/>
                            <span>注:请不要设置简单密码 </span>
                        </div>
                    </div>
                    <div class="form-group last">
                        <label class="control-label col-md-3">确认密码</label>
                        <div class="col-md-9">
                            <input type="text" style="display:none" />
                            <input  id="password2" name="password2" size="30" type="password" placeholder="请输入确认密码" autocomplete="off" class="form-control"/>
                            <span>注:请再次确认密码 </span>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="hidden" id="uid" name="uid" value="<?php echo $uid; ?>" />
                            <button type="submit" class="btn green"><i class="fa fa-check"></i> 保存</button>
                            <a href="javascript:window.history.back()" class="btn default">取消</a>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
</div>