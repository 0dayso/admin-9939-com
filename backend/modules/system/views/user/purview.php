<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = "用户权限设置";
?>
<div class="dis-bread">
    <a href="<?php echo Url::home(); ?>">首页</a>>
    <a href="<?php echo Url::toRoute('default/index'); ?>">系统管理</a>>
    <a href="javascript:;" class="bolde">用户管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::toRoute('user/index'); ?>">返回</a>
        <h3>用户管理 -- 用户权限设置</h3>
    </div>
    <div class="row text-left"  style="margin:10px;">
        <form id="addFuncForm" name="addModulesForm" action="/user/savepurview" method="post" class="form-horizontal" onsubmit="return checkForm();" class="form-horizontal form-bordered form-label-stripped">
            <div class="form-group">
                    <label class="control-label col-md-3">角色类型</label>
                    <div id="role_list" class="col-md-9 checkbox">
                        <?php foreach ($roleList as $role) { ?>
                            <label class="span2">
                                <input type="checkbox" name="role_ids[]"  value="<?php echo $role['id']?>" /> <?php echo $role['role_name'];?>
                            </label>
                        <?php } ?>
                    </div>
                </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="hidden" name="purview_ids" id="purview_ids" value="" />
                        <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>" />
                        <button type="submit" class="btn green"><i class="fa fa-check"></i> 保存</button>
                        <a href="<?php echo Url::toRoute('user/index'); ?>" class="btn default">取消</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

var setting = {
		check: {
			enable: true,
			nocheckInherit: false
		}
};
var user_role_id = '<?php echo json_encode($user_role_ids);?>';
var zNodes = <?php echo json_encode($funcData); ?>;
$(document).ready(function(){
	$.fn.zTree.init($("#funcTree"), setting, zNodes);
	getPurview(user_role_ids,true);
	$(":checkbox").click(function(){
		getPurview(this.value,$(this).prop("checked"));
	});

	$("#reset").click(function(){
		$(":checkbox").prop("checked",false);
		checkNode(null,false,true);
	});

	$("#role_list :checkbox").click(function(){
		$(this).siblings().prop("checked",false);
	});
});

function checkForm() {
	var treeObj = $.fn.zTree.getZTreeObj("funcTree");
	var nodes = treeObj.getCheckedNodes(true);
	var selNodeIds = "";

	for(var i in nodes) {
		selNodeIds += nodes[i].id;
		selNodeIds += ","
	}
	if(selNodeIds == "") {
		alert('请至少选择一个权限');
		return false;
	}
	$('#purview_ids').val(selNodeIds);
	return true;
}

function getPurview(roleId,isRequest){
	
	if(isRequest == true){
		$.get("/utils/getpurview",{'rid':roleId},function(result){
			$("#role_list :checkbox[value='"+roleId+"']").attr("checked",true);
            $("#role_list :checkbox[value='"+roleId+"']" ).parent().addClass("checked");
			checkNode(result.data,false,true);
			checkNode(result.data,true);
		});
	}else{
		checkNode(null,false,true);
	}
}

// 设置节点是否选中 
// nodes 节点 Json 
// isCheck 是否选中标识 false:不选中 true:选中 
// isAll 是否为全部节点 true:全部 false或空:不是全部 
function checkNode(nodes,isCheck,isAll){
	var treeObj = $.fn.zTree.getZTreeObj("funcTree");
	if(isAll == true){
		treeObj.checkAllNodes(isCheck);
		return false;
	}
    if( nodes != null ){
        for (var i=0, l=nodes.length; i < l; i++) {
            var node = treeObj.getNodeByParam("id", nodes[i].id, null);
            treeObj.checkNode(node, isCheck, false);
        }
    }
}

</script>
