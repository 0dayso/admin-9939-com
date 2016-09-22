<?php
use yii\helpers\Url;
$this->title = "角色管理";
?>
<div class="dis-bread">
    <a href="<?php echo Url::home(); ?>">首页</a>>
    <a href="<?php echo Url::toRoute('default/index'); ?>">系统管理</a>>
    <a href="javascript:;" class="bolde">角色管理</a>
</div>

<div class="dis-main">
    <div class="d-titr d-manar clearfix">
        <a href="<?php echo Url::toRoute('role/add'); ?>"><i class="fa fa-plus"></i> 新增角色</a>
        <h3>角色列表</h3>
    </div>
    <table border="1" cellspacing="0" class="tablay"> 
        <thead>
            <tr style="border-left: 1px solid #ececec;"> 
                <th class="to_02">ID</th>
                <th class="to_03">角色名称</th>  
                <th class="to_04">描述</th>
                <th class="to_07">操 作</th>                                 
            </tr> 
        </thead>
        <tbody class="ddf">
            <?php foreach ($roleList as $role) { ?>
                <tr class="odd gradeX">
                    <td> <?php echo $role['id'];?></td>
                    <td> <?php echo $role['role_name'];?></td>
                    <td> <?php echo $role['remark'];?></td>
                    <td>
                        <a href="<?php echo  Url::toRoute(['role/edit','role_id'=>$role['id']]); ?>"
                           class="btn btn-warning">编辑</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <!-- 页码 -->
    <div class="paget dep">
    </div>
</div>
