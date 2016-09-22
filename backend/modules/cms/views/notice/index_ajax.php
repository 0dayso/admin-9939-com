<?php
use yii\helpers\Html;
use yii\helpers\Url;
if(count($model['noticelist']) > 0){
?>
			<table  border="1" cellspacing="0" class="d-cell-bos tablay"> 
                  <thead>
                    <tr style="border-left: 1px solid #ececec;"> 
                        <th class="til_01">全部<input  class="d-asrl" id="check_all" type="checkbox" value="<?php echo $model['status'];?>"/></th> 
                         <th class="til_02">ID</th>
                         <th class="til_03">公告标题 </th> 
                         <th class="til_04">所属客户端</th>
                         <th class="til_05">发布状态</th>  
                         <th class="til_06">发布者</th>
                         <th class="til_07">发布时间</th>
                         <th class="til_09">操 作</th>                  
                    </tr>
                 </thead>
                <tbody class="ddf" id="<?php echo $model['status'];?>">
                <?php
                    foreach ($model['noticelist'] as $k=>$list){
                ?>
                 <tr id="line<?php echo $list['id']?>"> 
                    <td><input type="checkbox" name="articleid[]" id = "articleid" value="<?php echo $list['id']?>"/></td>
                    <td><?php echo $list['id'];?></td> 
                    <td><?php echo $list['title'];?></td> 
                    <td><?php if($list['client'] == '0'){echo '所有客户端';}elseif ($list['client']=='1') {echo '医生端';}  else {echo'客户端';};?></td>
                    <td><?php if($list['status'] == '0'){echo '未发布';}elseif ($list['status']=='1') {echo '已发布';}  else {echo'屏蔽';};?></td>
                    <td><?php echo $list['username'];?></td>
                    <td><?php echo date('Y-m-d H:i:s',$list['createtime']);?></td>
                    <td><?php if($list['status']!='2'){ ?><a href="javascript:void(0);" onclick="screen(<?php echo $list['id']?>)" class="d-shre">屏蔽</a><?php }else{?><a href="javascript:void(0);"class="d-delet">已屏蔽</a><?php }?>&nbsp;<a href="/cms/notice/edit?nid=<?php echo $list['id']?>" class="d-editor">编辑</a>&nbsp;<a href="javascript:void(0);" onclick="deletes(<?php echo $list['id']?>);" class="d-delet">删除</a></td>
                </tr> 
               <?php
                    }
               ?>
                </tbody>
            </table>
            <div class="paget">
                 <?php echo $model['paging'] ->view(); ?>
            </div>
<?php
}else{
?>
        <table  border="1" cellspacing="0" class="d-cell-bos tablay"> 
                  <thead>
                    <tr style="border-left: 1px solid #ececec;"> 
                         <th class="til_01">全部<input  class="d-asrl" type="checkbox"/></th> 
                         <th class="til_02">ID</th>
                         <th class="til_03">公告标题 </th> 
                         <th class="til_04">所属客户端</th>
                         <th class="til_05">发布状态</th>  
                         <th class="til_06">发布者</th>
                         <th class="til_07">发布时间</th>
                         <th class="til_09">操 作</th>                                 
                    </tr>
                 </thead>
                <tbody class="ddf" id="all_result_tbody">
                    <tr><td colspan="9" align="center">根据条件暂时还查不到数据...</td></tr>
                </tbody>
            </table>
<?php 
}
?>