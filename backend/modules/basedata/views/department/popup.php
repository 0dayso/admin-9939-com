<?php

use yii\helpers\Url;
?>
<div class="qbwrt qbwrt_shn" style=" display:none;">
    <div class="d-list-form">
        <div class="d-titr  d-grew">
            <a href="javascript:void(0)" class="d-errtu">
                <img  src="<?php echo Url::to('@domain/images/d-wor.png'); ?>"/>
            </a>
            <h3>科室管理 — 添加疾病 — 相关疾病</h3>
        </div>
        <input type="hidden" name="note_level2" id="note_level2" value=""/>
        <div class="disin fosub infc">
            <label>一级科室：</label>
            <select class="level" name="search[class_level1]" id="class_level1">
                <option value="0" >请选择</option>
                <?php
                if ($class_level1) {
                    foreach ($class_level1 as $key => $val) {
                        if ($key == 0) {
                            ?>
                            <option value="<?php echo $val['id']; ?>" selected="selected"><?php echo $val['name']; ?></option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                            <?php
                        }
                    }
                }
                ?>
            </select>
            <label>二级科室：</label>
            <select class="level" name="search[class_level2]" id="class_level2">
                <option value="0" >请选择</option>
            </select>
            <label>疾病名称：</label>
            <input type="text" id="name" name="dis_name" value="" class="dina dindex">
            <a href="javascript:void(0)" id="search_dis">搜索</a>
        </div>
        
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
            </tbody>
        </table>
        <!--表格 结束-->
    </div>
</div> 