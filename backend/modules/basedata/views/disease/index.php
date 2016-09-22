<?php
use yii\helpers\Url;

$this->title = "疾病管理";

?>

<div class="dis-bread">
    <a href="<?php echo Url::to('@domain');?>">首页</a>>
    <a href="<?php echo Url::to(['/basedata/default/index']) ?>">基础数据</a>>
    <a href="<?php echo Url::to(['/basedata/disease/']) ?>" class="bolde">疾病管理</a>
</div>
<div class="dis-main">
    <div class="d-titr d-manar clearfix">
        <a href="<?php echo Url::to(['/basedata/disease/goadd']) ?>">添加疾病</a>

        <h3>疾病管理</h3></div>

    <form class="disin fosub" action="<?php echo Url::to(['/basedata/disease/index']); ?>" method="post" id = "indexForm">
        <p>
            <label>ID：</label>
            <input type="text" id="diseaseid">

            <label>一级科室：</label>
            <select class="level" name="class_level1" id="class_level1">
                <option value="0">一级科室</option>
                <?php
                if (isset($class_level1s) && !empty($class_level1s)) {
                    foreach ($class_level1s as $class_level1) {
                        ?>
                        <option value="<?php echo $class_level1['id']; ?>"><?php echo $class_level1['name']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <label>二级科室：</label>
            <select class="level" name="class_level2" id="class_level2"></select>
        </p>
        <p>
            <label>按疾病：</label><input type="text" id="diseasename"/>
            <label>疾病症状：</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="dina" id="symptomname" style="margin-left: 10px;"/>

            <a href="javascript:;" id="searchA">搜索</a></p>
    </form>

    <div class="canbot"><a href="javascript:;" id = "batchGenerate">批量生成</a></div>
    <div id="diseaseOuterID">
        <table border="1" cellspacing="0" class="tablay">
            <thead>
            <tr style="border-left: 1px solid #ececec;">
                <th class="to_01">全部<input class="d-asrl" type="checkbox" id="thCheckbox" onclick="fullChecked(this)"/></th>
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
                foreach ($diseaseArr as $disease) {
                    ?>
                    <tr>
                        <td><input type="checkbox" value="<?php echo $disease['id']; ?>" data-name="checkbox" onclick="singleChecked(this)"/></td>
                        <td><?php echo $disease['id']; ?></td>
                        <td><a href=""><?php echo $disease['name']; ?></a></td>
                        <td><?php echo $disease['typical_symptom']; ?></td>
                        <td><?php echo $disease['inputtime']; ?></td>
                        <td>
                            <a href="" class="d-schr">生成</a>&nbsp;
                            <a href="" class="d-scee">预览</a>&nbsp;
                            <a href="" class="d-editor" onclick="updateDis(this)">编辑</a>&nbsp;
                            <a href="javascript:;" class="d-delet" onclick="deleteDis(this)">删除</a></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <div class="paget" id="paget">
            <?php echo $pageHTML; ?>
        </div>
    </div>
</div>

<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->

<script type="text/javascript" src="<?php echo Url::to('@domain/js/disease/index.js') ?>"></script>