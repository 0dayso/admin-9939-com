<?php
use yii\helpers\Url;
$this->title = "权限项管理";
?>
<div class="dis-bread">
    <a href="<?php echo Url::home(); ?>">首页</a>>
    <a href="<?php echo Url::toRoute('default/index'); ?>">系统管理</a>>
    <a href="javascript:;" class="bolde">功能项管理</a>
</div>

<div class="dis-main">
    <div class="d-titr d-manar clearfix">
        <a href="<?php echo Url::toRoute('func/add'); ?>"><i class="fa fa-plus"></i> 新增功能</a>
        <h3>功能项列表</h3>
    </div>
    <table border="1" cellspacing="0"  class="tablay" id="sortTableExample"> 
        <thead>
            <tr style="border-left: 1px solid #ececec;"> 
                <th class="to_01">ID</th>
                <th class="to_02">模块名称</th>
                <th class="to_02">模块ID</th>
                <th class="to_03">控制器ID</th>
                <th class="to_04">路径</th>  
                <th class="to_05">描述</th>
                <th class="to_07">操 作</th>                                 
            </tr> 
        </thead>
        <tbody class="ddf">
            <?php foreach ($funcList as $func) { ?>
                <tr id="node-<?php echo $func['id'] ?>"  data-tt-id="<?php echo $func['id'];?>">
                    <td><?php echo $func['id']; ?></td>
                    <td title="<?php echo $func['caption'];?>"> <?php echo $func['caption'];?></td>
                    <td><?php echo $func['moduleid']; ?></td>
                    <td><?php echo $func['controllerid']; ?></td>
                    <td><?php echo $func['url']; ?></td>
                    <td><?php echo $func['remark']; ?></td>
                    <td>
                        <a href="<?php echo Url::toRoute(['func/edit','id' => $func['id']]);?>" class="btn btn-warning">编辑</a>
                        <a href="javascript:void(0);" class="btn btn-danger disabled">删除</a>
                    </td>
                </tr>
                <?php if(!empty($func['child'])) { foreach ($func['child'] as $k=>$cFunc) { ?>
                    <tr id="node-<?php echo $cFunc['id'] ?>" class="child-of-node-<?php echo $cFunc['parent_id']; ?>"  data-tt-id="<?php echo $cFunc['id']; ?>" data-tt-parent-id="<?php echo $cFunc['parent_id']; ?>">
                        <td><?php echo $cFunc['id']; ?></td>
                        <td title="<?php echo $cFunc['caption']; ?>"> <?php echo $cFunc['caption']; ?></td>
                        <td><?php echo $cFunc['moduleid']; ?></td>
                        <td><?php echo $cFunc['controllerid']; ?></td>
                        <td><?php echo $cFunc['url']; ?></td>
                        <td><?php echo $cFunc['remark']; ?></td>
                        <td>
                            <a href="<?php echo Url::toRoute(['func/edit','id' => $cFunc['id']]);?>" class="btn btn-warning">编辑</a>
                            <a href="javascript:" data-id="<?php echo $cFunc['id'];?>" class="btn btn-danger btn_del">删除</a>
                        </td>
                    </tr>
                <?php }} ?>
            <?php } ?>
        </tbody>
    </table>
    <!-- 页码 -->
    <div class="paget dep">
    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/treetable/css/jquery.treeTable.css') ;?>" />
<script type="text/javascript" src="<?php echo Url::to('@domain/treetable/js/jquery.treeTable.js');?>"></script> 
<script type="text/javascript">
    $(function() {
        $( "#sortTableExample" ).treeTable( {
             initialState: "collapsed"
        } );
        $(".btn_del").click(function(){
            if(!confirm("是否确认删除？")){
                return false;
            }
            var id = $(this).attr("data-id");
            $.post('<?php echo Url::toRoute('func/del'); ?>',{'id':id},function(result){
                $ret = eval('('+result+')');
                if($ret.code == 200){
                    alert($ret.message);
                    window.location = window.location;
                }else{
                    alert($ret.message);
                }
            });
        });
    });
</script>
 