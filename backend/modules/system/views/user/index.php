<?php
use yii\helpers\Url;
$this->title = "用户管理";
?>
<div class="dis-bread">
    <a href="<?php echo Url::home(); ?>">首页</a>>
    <a href="<?php echo Url::toRoute('default/index'); ?>">系统管理</a>>
    <a href="javascript:;" class="bolde">用户管理</a>
</div>

<div class="dis-main">
    <div class="d-titr d-manar clearfix">
        <a href="<?php echo Url::toRoute('user/add'); ?>"><i class="fa fa-plus"></i> 新增用户</a>
        <h3>用户列表</h3>
    </div>
    <table border="1" cellspacing="0" class="tablay"> 
        <thead>
            <tr style="border-left: 1px solid #ececec;"> 
                <th class="to_01">ID</th>
                <th class="to_02">登录名</th>
                <th class="to_02">真实姓名</th>  
                <th class="to_03">Email</th>
                <th class="to_05">电话</th>
                <th class="to_02">状态</th>
                <th class="to_07">操 作</th> 
            </tr> 
        </thead>
        <tbody class="ddf">
            <?php foreach ( $userList as $user ) { ?>
                <tr class="odd gradeX">
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['login_name']; ?></td>
                    <td><?php echo $user['real_name'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['phone'] ?></td>
                    <td>
                        <?php if( $user['status'] == 1 ) { ?>
                            <span class="label label-success">启用</span>
                        <?php } else { ?>
                            <span class="label label-danger">停用</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a class="btn btn-warning" href="<?php echo Url::toRoute(['user/edit','uid'=>$user['id']]); ?>">
                            编辑
                        </a>
                        <?php if( $user['status'] == 1 ) { ?>
                            <a class="btn btn-danger" href="<?php echo Url::toRoute(['user/editpassword','uid'=>$user['id']]); ?>">
                               重置密码
                            </a>
                            <?php if($user['is_super']==1) { ?>
                                 <a class="btn btn-danger <?php echo $user['is_super']==1?'disabled':''; ?>" href="javascript:">
                                    停用
                                </a>
                            <?php }else{ ?>
                                <a class="btn btn-danger" href="<?php echo Url::toRoute(['user/disable','uid'=>$user['id']]); ?>">
                                    停用
                                </a>
                            <?php } ?>
                        <?php } elseif( $user['status'] == 2 ) { ?>
                            <a class="btn btn-success" href="<?php echo Url::toRoute(['user/enable','uid'=>$user['id']]); ?>">
                                启用
                            </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <!-- 页码 -->
    <div class="paget dep">
        <?php $paging->view(); ?>
    </div>
</div>