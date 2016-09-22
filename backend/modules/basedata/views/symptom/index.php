<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'] = [
    [
        'label' => '基础数据',
        'url' => Url::to(['/basedata/']),
    ],
    [
        'label' => Html::encode($this->title),
        'url' => Url::to(['/basedata/symptom/']),
        'template' => "<a>{link}</a>",
        'class' => 'bolde'
    ],
];

//$labels = $models->attributeLabels();
?>


<div class="dis-bread">
    <?php
    echo Breadcrumbs::widget([
        'itemTemplate' => "<a>{link}</a>&gt;",
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>
</div>

<div class="dis-main">
    <div class="d-titr d-manar clearfix"><a href="<?php echo Url::to(['/basedata/symptom/add']);?>">添加症状</a><h3><?php echo Html::encode($this->title);?></h3></div>


    <form class="disin fosub" method="post" name="search">
        <input type="hidden" name="search" value="1">
        <p>
            <label>ID：</label><input type="text" id="symptomid" name="symptomid" value="" placeholder="症状id号">
            <label>一级部位：</label>
            <select class="level" name="class_level1" id="class_level1">
                <option value="0">请选择</option>
                <?php
                foreach ($relDisease['part'] as $k => $v) {
                    if($v['level'] == 1){
                    ?>
                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                    <?php
                    }
                }
                ?>
            </select>

            <label>二级部位：</label>
            <select name="class_level2" id="class_level2" class="level"></select>
        </p>
        <p>
            <label>症状名称：</label>
            <input type="text" id="symptomName" name="symptomName" value="" placeholder="症状名称">
            
            <label>操作人：</label><input type="input" id="username" name="username" placeholder="操作人" value="" style="margin-left: 12px; width: 185px;">
            <a href="javascript:void(0);" id="searchBtn">搜索</a>
        </p>
    </form>


    <div class="canbot"><a href="">批量生成</a></div>

    <table class="tablay" width="100%" align="center" id="list">
        <tr>
            <th class="ma_01">全部<input class="d-asrl" type="checkbox"/></th>
            <th class="ma_02">ID</th>
            <th class="ma_03">症状名称</th>
            <th class="ma_04">一级部位</th>
            <th class="ma_05">二级部位</th>
            <th class="ma_06">发布时间</th>
            <th class="ma_07">操作人</th>
            <!--th>pinyin</th>
            <th>pinyin_initial</th>
            <th>capital</th-->
            <th class="ma_08">操作</th>
        </tr>
        <tbody id="result">

        <?php
        foreach ($model as $v) {
            $part_level1_id = $v['part_level1'];
            $part_level2_id = $v['part_level2'];
//            var_dump($part_level1_id);exit;
            $part_level1_name = $part_level2_name = '--';
            if(!empty($part_level1_id)){
                $part_level1_name = $relDisease['part'][$part_level1_id]['name'];
            }
            if(!empty($part_level2_id)){
                $part_level2_name = $relDisease['part'][$part_level2_id]['name'];
            }
//            print_r($relDisease['part'][$partid]);
//            exit;
            ?>
            <tr>
                <td><label><input type="checkbox" name="ids[]" value="<?php echo $v['id']; ?>"></label></td>
                <td><?php echo $v['id']; ?></td>
                <td><?php echo $v['name']; ?></td>
                <td><?php echo $part_level1_name; ?></td>
                <td><?php echo $part_level2_name; ?></td>
                <td><?php echo date('Y-m-d H:i:s', $v['createtime']); ?></td>
                <td><?php echo $v['username']; ?></td>
                <!--td><?php echo $v['pinyin']; ?></td>
                <td><?php echo $v['pinyin_initial']; ?></td>
                <td><?php echo $v['capital']; ?></td-->
                <td>
                    <a href="<?php echo Url::to([ '/basedata/symptom/edit', 'id' => $v['id']]); ?>" class="d-schr">生成</a>
                    <a href="<?php echo Url::to([ '/basedata/symptom/edit', 'id' => $v['id']]); ?>" class="d-scee">查看</a>
                    <a href="<?php echo Url::to([ '/basedata/symptom/edit', 'id' => $v['id']]); ?>" class="d-editor">编辑</a>
                    <a href="javascript:void(0);" data-href="<?php echo Url::to([ '/basedata/symptom/delete', 'id' => $v['id']]); ?>" data-url="<?php echo Url::to([ 'basedata/symptom/delete']); ?>" data-id="<?php echo $v['id']; ?>" class="d-delet">删除</a>
                </td>
            </tr>
            <?php
        }
        ?>    
            <tr>
                <td colspan="11"></td>
            </tr>
        </tbody>
    </table>
    
<!--    <div>
        <a href="javascript:void(0);" id="selectAll">全选</a>
        <a href="javascript:void(0);" id="unSelect">全不选</a>
        <a href="javascript:void(0);" id="reverse">反选</a>
        <a href="javascript:void(0);" id="batCreate">批量生成</a>
    </div>-->
    
    <div class="paget">
<!--        <a href="" class="hko kos">&lt;&lt;</a>
        <a href="" class="curt">1</a>
        <a href="">2</a>
        <a href="">3</a>
        <a href="">4</a>
        <a href="">5</a>
        <span>...</span>
        <a href="">10</a>
        <a href="" class="hko">&gt;&gt;</a>-->
        <?php echo $page->view();?>
    </div>
</div>

<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->
<script>
part_level2_ajaxUrl = '<?php echo Url::to(['/basedata/symptom/ajax-part']); ?>';
search_ajaxUrl = '<?php echo Url::to(['/basedata/symptom/']);?>';
</script>
<script src="<?php echo Url::to('@domain/js/symptom/manage.js')?>"></script>
