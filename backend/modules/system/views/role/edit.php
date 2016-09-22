<?php
use yii\helpers\Url;
$this->title = "编辑角色";
?>
<div class="dis-bread">
    <a href="<?php echo Url::home(); ?>">首页</a>>
    <a href="<?php echo Url::toRoute('default/index'); ?>">系统管理</a>>
    <a href="javascript:;" class="bolde">角色管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::toRoute('role/index'); ?>">返回</a>
        <h3>角色管理 -- 编辑角色</h3>
    </div>
    <div class="row"  style="margin:10px;">
        <div class="col-md-8">
            <!-- BEGIN FORM-->
            <form id="addFuncForm" name="addModulesForm" action="<?php echo Url::toRoute('role/save'); ?>" method="post" class="form-horizontal" onsubmit="return checkForm();" class="form-horizontal form-bordered form-label-stripped">
                <div class="form-body">
                    <table align="center" border="0" cellpadding="3" cellspacing="1" width="98%" style="text-align:left;">
                        <tbody>
                            <tr bgcolor="#FFFFFF"> 
                                <td height="25" align="center">角色名称：</td>
                                <td style="padding-top:10px;">
                                    <div class="col-md-9">
                                        <input type="text" id="role[role_name]" name="role[role_name]" size="30" placeholder="请输入角色名称" class="form-control"  value="<?php echo $role['role_name'];?>"/>
                                        <span>注:用于表示用户所属角色 </span>
                                    </div>
                                </td>
                            </tr>
                            <tr bgcolor="#FFFFFF"> 
                                <td height="25"  align="center">角色描述：</td>
                                <td style="padding-top:10px;">
                                    <div class="col-md-9">
                                        <textarea id="role[remark]" name="role[remark]" class="form-control span7"><?php echo $role['remark']?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr bgcolor="#FFFFFF"> 
                                <td height="25" align="center" width="10%" valign="top">
                                    <div style="margin-top: 18px;">权限分配：</div>
                                </td>
                                <td height="25">
                                    <table  border="0" cellpadding="3" cellspacing="1" width="100%" style="margin-top:0;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p class="tocho"><input type="checkbox" id="cbx_func_group_all" name="cbx_func_group_all"  data-func-id="0"  data-func-fatherid="0" class="cbx_func_group_all">全选</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table class="table-bordered"  boder="0"  cellpadding="3" cellspacing="1" width="100%" style="margin:3px 3px 3px 0;">
                                                        <tbody>
                                                            <?php $group_index = 1; foreach($funcData as $k=>$v){ ?> 
                                                                <tr> 
                                                                    <td><div class="syup"><p class="tocho agalc"><input type="checkbox" id="cbx_func_group_<?php echo $group_index; ?>" name="cbx_func_group_<?php echo $group_index; ?>"  data-func-group-index="<?php echo $group_index; ?>"   class="cbx_func_group css_cbx"><?php echo $v['name']; ?></p><p class="syset"></p></div></td>
                                                                </tr>
                                                                <tr> 
                                                                    <td bgcolor="#FFFFFF" width="90%" style=" border-bottom:none;">
                                                                        <ul class="menu">
                                                                            <?php $fst_checked = isset($role_func_data[$v['id']])?'checked="checked"':''; ?>
                                                                            <li><input  type="checkbox" id="cbx_func_item_<?php echo $v['id']; ?>" name="cbx_func_item_<?php echo $v['id']; ?>" data-func-id="<?php echo $v['id']; ?>" data-func-group-index="<?php echo $group_index; ?>" class="css_cbx css_func_item"  value="<?php echo $v['id']; ?>" <?php echo $fst_checked; ?> ><?php echo $v['name'].'首页'; ?></li>
                                                                            <?php $cfuncs = $v['children']; ?>
                                                                            <?php foreach($cfuncs as $kk=>$vv) { 
                                                                                $item_checked = isset($role_func_data[$vv['id']])?'checked="checked"':'';
                                                                                ?>
                                                                                <li><input type="checkbox"  id="cbx_func_item_<?php echo $vv['id']; ?>" name="cbx_func_item_<?php echo $vv['id']; ?>" data-func-id="<?php echo $vv['id']; ?>" data-func-group-index="<?php echo $group_index; ?>" class="css_cbx css_func_item"  value="<?php echo $vv['id']; ?>"  <?php echo $item_checked; ?> ><?php echo $vv['name']; ?></li>
                                                                            <?php } ?>
                                                                        </ul>

                                                                    </td>
                                                                </tr>
                                                            <?php $group_index++; ?>

                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>   
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <input type="hidden" name="role[id]" id="role[id]" value="<?php echo $role['id']?>" />
                                <input type="hidden" name="purview_ids" id="purview_ids" value=""/>
                                <button type="submit" class="btn green"><i class="fa fa-check"></i> 保存</button>
                                <a href="<?php echo Url::toRoute('role/index'); ?>" class="btn default">取消</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
</div>
<style type="text/css">
    .menu{ overflow:hidden; margin:0;}
    .menu li{ float:left;height:32px; line-height:32px;  width:19.9%; text-align:left; overflow:hidden; }
    .menu li input{ float:left; margin:8px 6px 0 20%;}
    p.tocho{ overflow:hidden; margin-top:15px;text-align:left; width:120px;}
    p.tocho input{ float:left; margin:4px 4px 0 0;}
    .syup{ overflow:hidden;}
    p.agalc{ float:left; margin-left:14px;}
    p.syset{ float:left; margin:15px 10px 0 45%; }
</style>
<script type="text/javascript">
    $(function(){
        $(".cbx_func_group_all").click(function(){
            var checked = $(this).attr("checked");
            if(checked){
                $(".css_cbx").attr("checked","checked");
            }else{
                $(".css_cbx").removeAttr("checked");
            }
        });
        $(".cbx_func_group").click(function(){
            var func_group_index  = $(this).attr("data-func-group-index");
            var group_name = "[data-func-group-index='"+String(func_group_index)+"']";
            var checked = $(this).attr("checked");
            if(checked){
                $(group_name).attr("checked","checked");
            }else{
                $(group_name).removeAttr("checked");
            }
            setFuncAllCheckState();
        });
        
        $(".css_func_item").click(function(){
            setFuncAllCheckState();
        });
        
        setFuncAllCheckState();
    });
    function checkForm() {
        var func_ids_arr = [];
        $(".css_func_item:checked").each(function(i){
            var func_id = $(this).attr("data-func-id");
            func_ids_arr.push(func_id);
        });
        var func_ids = func_ids_arr.join(',');
        $('#purview_ids').val(func_ids);
        return true;
    }
    function setFuncAllCheckState(){
        var item_len = $(".css_func_item").length;
        var item_checked_len = $(".css_func_item:checked").length;
        if(item_len==item_checked_len){
            $("[data-func-id='0']").attr("checked","checked");
            $(".cbx_func_group").attr("checked","checked");
        }else{
            $("[data-func-id='0']").removeAttr("checked");
        }
        
        $(".cbx_func_group").each(function(i){
            var func_group_index = $(this).attr("data-func-group-index");
            var group_name = ".css_func_item[data-func-group-index='"+String(func_group_index)+"']";
            var group_len =  $(group_name).length;
            var checked_len = $(group_name+":checked").length;
            if(group_len==checked_len){
                $("#cbx_func_group"+"_"+String(func_group_index)).attr("checked","checked");
            }else{
                $("#cbx_func_group"+"_"+String(func_group_index)).removeAttr("checked");
            }
        });
    }
</script>