<?php
use yii\helpers\Url;
$this->title = "修改用户";
?>
<div class="dis-bread">
    <a href="<?php echo Url::home(); ?>">首页</a>>
    <a href="<?php echo Url::toRoute('default/index'); ?>">系统管理</a>>
    <a href="javascript:;" class="bolde">用户管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::toRoute('user/index'); ?>">返回</a>
        <h3>用户管理 -- 修改用户</h3>
    </div>
    <div class="row"  style="margin:10px;">
        <div class="col-md-8">
            <!-- BEGIN FORM-->
            <form id="addFuncForm" name="addModulesForm" action="<?php echo Url::toRoute('user/save'); ?>" method="post" class="form-horizontal" onsubmit="return checkForm();" class="form-horizontal form-bordered form-label-stripped">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">登录名</label>
                        <div class="col-md-9">
                            <input type="text" id="users[login_name]" name="users[login_name]"   size="30" autocomplete="off" placeholder="请输入登录名"  value="<?php echo $userinfo['login_name'];?>" readonly="true" class="form-control"/>
                            <span>注：用于用户登录 </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">角色类型</label>
                        <div class="col-md-9">
                            <select id="role_id" name="role_id">
                                <option value="0">选择角色类型</option>
                                <?php foreach ($roleList as $role) { 
                                    $selected = isset($user_role_ids[$role['id']])?'selected':'';
                                    ?>
                                    <option value="<?php echo $role['id']?>" <?php echo $selected; ?> ><?php echo $role['role_name'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Email</label>
                        <div class="col-md-9">
                            <input  type="text" class="form-control" id="users[email]" name="users[email]" size="30"  value="<?php echo $userinfo['email'];?>" />
                            <span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">真实姓名</label>
                        <div class="col-md-9">
                            <input type="text" id="users[real_name]" name="users[real_name]" size="30"  value="<?php echo $userinfo['real_name'];?>"  class="form-control"  />
                            <span>注：登录后显示 </span>
                        </div>
                    </div>
                    <div class="form-group last">
                        <label class="control-label col-md-3">电话</label>
                        <div class="col-md-9">
                            <input type="text" id="users[phone]" name="users[phone]" size="30"  value="<?php echo $userinfo['phone'];?>"  class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="hidden" id="users[id]" name="users[id]" value="<?php echo $userinfo['id'];?>" />
                            <button type="submit" class="btn green"><i class="fa fa-check"></i> 保存</button>
                            <a href="<?php echo Url::toRoute('user/index'); ?>" class="btn default">取消</a>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
</div>