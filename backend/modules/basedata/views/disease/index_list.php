<?php
use yii\helpers\Url;

$this->title = "疾病管理";

?>

<table border="1" cellspacing="0" class="tablay">
    <thead>
    <tr style="border-left: 1px solid #ececec;">
        <th class="to_01">全部<input class="d-asrl" type="checkbox" onclick="fullChecked(this)" id="thCheckbox"/></th>
        <th class="to_02">ID</th>
        <th class="to_03">疾病名称</th>
        <th class="to_04">症 状</th>
        <th class="to_05">发布时间</th>
        <th class="to_06">操 作</th>
    </tr>
    </thead>
    <tbody class="ddf" id="index_tbody">
    <?php
    if (isset($diseaseArr) && !empty($diseaseArr)) {
        foreach ($diseaseArr as $disease){
            ?>
            <tr>
                <td><input type="checkbox" value="<?php echo $disease['id'];?>" data-name = "checkbox" onclick="singleChecked(this)" /></td>
                <td><?php echo $disease['id'];?></td>
                <td><a href=""><?php echo $disease['name'];?></a></td>
                <td><?php echo $disease['typical_symptom'];?></td>
                <td><?php echo $disease['inputtime'];?></td>
                <td>
                    <a href="" class="d-schr">生成</a>&nbsp;
                    <a href="" class="d-scee">预览</a>&nbsp;
                    <a href="" class="d-editor" onclick="updateDis(this)">编辑</a>&nbsp;
                    <a href="javascript:;" class="d-delet"  onclick="deleteDis(this)">删除</a></td>
            </tr>
            <?php
        }
    }else {
        ?>
        <tr>
            <td colspan="6"> </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<div class="paget" id = "paget">
    <?php echo $pageHTML; ?>
</div>
