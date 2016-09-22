<?php
    use yii\helpers\Url;
?>

<div class="qbwrt qbwrt_shn" style=" display:none;">
    <div class="d-list-form">
        <div class="d-titr  d-grew">
            <a href="javascript:;" class="d-errtu"><img  src="<?php echo Url::to('@domain/images/d-wor.png'); ?>"/></a>
            <h3>问答管理 — 添加关键词 -- 选择疾病</h3>
        </div>
        <form class="disin fosub infc" action="" method="post">
            <label>一级科室：</label>
            <select class="level" id="class_level1">
                <option value="0" selected="selected">请选择科室</option>
                <?php
                if (is_array($class_level1)) {
                    foreach ($class_level1 as $k => $v) {
                        ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <label>二级科室：</label>
            <select class="level" id="class_level2">
                <option value="0">请选择科室</option>
            </select>
            <label>疾病名称：</label>
            <input type="text" value="" class="dina dindex" id="name">
            <a href="javascript:;" id="dis-search">搜索</a>
        </form>
        <!--表格 开始-->
        <table width="990" border="1" cellspacing="0"> 
            <thead class="ells-four">
                <tr> 
                    <th>全部<input  class="d-asrl" type="checkbox"/></th> 
                    <th>序号</th> 
                    <th>ID</th>  
                    <th>疾病名称 </th>
                </tr> 
            </thead>
            <tbody class="ddf">
                <tr> 
                    <td colspan="4" style="text-align: center;">正在加载……</td>
                </tr>
            </tbody>
        </table>
        <!--表格 结束-->
        <div class="d-kodrl">
            <a href="javascript:;" class="d-save-elec">保存选择</a>
            <a href="javascript:;" class="d-sr-elec d-errtu">取消选择</a>
        </div>

        
        <div class="paget d-mruw"></div>
        
    </div>
</div>
