<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'] = [
    [
        'label' => '内容管理',
        'url' => Url::to(['/cms/']),
    ],
    [
        'label' => Html::encode($this->title),
        'url' => Url::to(['/cms/article/index/']),
        'template' => "<a>{link}</a>",
        'class' => 'bolde'
    ],
];


//$labels = $models->attributeLabels();
?>
<script>
    search_ajaxUrl = '<?php echo Url::to(['/cms/article/index-ajax/']);?>';
</script>
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/js/datetimepicker/jquery.datetimepicker.css')?>" />
<div class="dis-bread">
    <?php
    echo Breadcrumbs::widget([
        'itemTemplate' => "<a>{link}</a>&gt;",
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>
</div>
<div class="dis-main">
<!--    <div class="d-titr d-manar"><a href="<?php echo Url::to(['/cms/article/index/']);?>">返回</a><h3>疾病资讯 -- <?php echo Html::encode($this->title);?></h3></div>-->
    
    <div class="d-titr d-manar"><a href="<?php echo Url::to(['/cms/article/add/']);?>">添加</a>疾病资讯 -- <?php echo Html::encode($this->title);?></div>

    
    <form class="disin" action="" method="post">
        <p>
            <label>ID：</label><input type="text" name="articleid" id="articleid" placeholder="文章id，精确查询" value="">
            <label>文章标题：</label><input type="text" name="title" id="title" placeholder="文章标题，模糊查询" value="" class="txle">
            <label>疾病名称：</label><input type="text" name="diseasename" placeholder="所属疾病名称，模糊查询" id="diseasename" value="">
        </p>
        <p>
            <label>发布时间：</label><input type="text" name="inputtime_begin" id="inputtime_begin" placeholder="发布起始时间" value="<?php //echo date("Y-m-d H:i:s");?>" class="mh_date">
            <span>至</span><input type="text" name="inputtime_end" id="inputtime_end" placeholder="发布截止时间" value="<?php //echo date("Y-m-d H:i:s",(time()+120));?>" class="mh_date">
            <label>发布人：</label><input type="text" name="username" id="username" placeholder="发布人用户名，精确查询" value="">
            <input type="hidden" name="status" id="status" value="11">
            <input type="hidden" name="type" id="type" value="unshow">
            <a href="javascript:void(0);" class="resres" id="searchBtn">搜索</a>
<!--            <a href="javascript:window.location.reload();" class="resres">重置</a>-->
        </p>
    </form>
    
    <div class="confi">
        <div class="discov fl">
            <a class="mo" onclick="changeTab(this);" data-status="11" data-type="unshow" data-cache="0" style="display:none;">未发布</a>
            <a class="cusde" onclick="changeTab(this);" data-status="99" data-type="show" data-cache="0">已发布</a>
            <a href="<?php echo Url::to(['/cms/article/recycle/']);?>" class="mo">回收站</a>
        </div>
        <div class="totde fr">
            <a href="javascript:void(0);" data-action="<?php echo Url::to([ '/cms/article/set-article']); ?>" id="batDelete">批量删除</a>
<!--            <a href="javascript:void(0);" id="batCheck">批量审核</a>-->
        </div>
    </div>
    
    <div class="isshi" style="display:none;">
        <table  border="1" cellspacing="0" class="d-cell-bos tablay"> 
            <thead>
                <tr style="border-left: 1px solid #ececec;"> 
                    <th class="til_01">全部<input class="d-asrl" value="unshow_result" type="checkbox" onclick="checkAll();"/></th> 
                    <th class="til_02">ID</th>
                    <th class="til_03">文章标题 </th> 
                    <th class="til_04">归属疾病</th>
                    <th class="til_05">发布人</th>  
                    <th class="til_06">发布时间</th>
                    <th class="til_07">点击量</th>
                    <th class="til_08">状态</th> 
                    <th class="til_09">操 作</th>                                 
                </tr> 
            </thead>
            
            <tbody class="ddf" id="unshow_result">
            <?php
                $articleStatus = [
                    '11' => '未发布',
                    '99' => '已发布',
                    '0' => '回收站',
                ];
            if(isset($model['unshow']['disease'])){
                foreach ($model['unshow'] as $v) { 
                    $diseaseNameTmp = '';
                    if(count($v['disease']) > 0){
                        foreach ($v['disease'] as $vv){
                            $diseaseNameTmp[] = "<a data-id='{$vv['diseaseid']}'>{$vv['name']}</a>";
                        }
                        $diseaseTag = implode(',', $diseaseNameTmp);
                    }else{
                        $diseaseTag = '';
                    }
            ?>
                <tr id="line<?php echo $v['info']['id']; ?>"> 
                    <td><input name="articleid[]" id="articleid" type="checkbox" value="<?php echo $v['info']['id']; ?>"/></td>
                    <td><?php echo $v['info']['id']; ?></td> 
                    <td><?php echo $v['info']['title']; ?></td> 
                    <td><?php echo $diseaseTag; ?></td>
                    <td><?php echo $v['info']['username']; ?></td>
                    <td><?php echo date("Y-m-d H:i:s", $v['info']['inputtime']); ?></td>
                    <td><?php echo $v['info']['click']; ?></td>
                    <td><?php echo $articleStatus[$v['info']['status']]; ?></td>
                    <td>
                        <a href="" class="d-schr">生成</a>&nbsp; 
                        <a href="<?php echo Yii::getAlias("@jb_domain").'/article/'.date("Y/md", $v['info']["inputtime"]).'/'.$v['info']['id'].'.shtml';?>" class="d-scee" target="new">预览</a>&nbsp;
                        <a href="<?php echo Url::to([ '/cms/article/edit/', 'id' => $v['info']['id']]); ?>" class="d-editor">编辑</a>&nbsp;
                        <a href="javascript:void(0);" id="action<?php echo $v['info']['id']; ?>" onclick="delInfo(this)" data-href="<?php echo Url::to([ '/cms/article/set-article', 'id' => $v['info']['id']]); ?>" data-url="<?php echo Url::to([ '/cms/article/set-article']); ?>" data-id="<?php echo $v['info']['id']; ?>" class="d-delet">删除</a>
                    </td>
                </tr> 
            <?php
            }
            ?>
            
            <tr>
                <td colspan="9">
                    <div class="paget">
<!--                        <a href="" class="hko kos">&lt;&lt;</a><a href="" class="curt">1</a><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a><span>...</span><a href="">10</a><a href="" class="hko">&gt;&gt;</a>-->
                        <?php echo $model['paging']->view();?>
                    </div>
                </td>
            </tr>
            
            <?php
            }else{
                echo '<tr>            <td colspan="9" align="center">根据条件暂时还查不到数据</td>        </tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
    
    
    
    
    
    <div class="isshi">
        <table border="1" cellspacing="0" class="d-cell-bos tablay"> 
            <thead>
                <tr style="border-left: 1px solid #ececec;"> 
                    <th class="til_01">全部<input class="d-asrl" type="checkbox" value="show_result" onclick="checkAll(this);"/></th> 
                    <th class="til_02">ID</th>
                    <th class="til_03">文章标题 </th> 
                    <th class="til_04">归属疾病</th>
                    <th class="til_05">发布人</th>  
                    <th class="til_06">发布时间</th>
                    <th class="til_07">点击量</th>
                    <th class="til_08">状态</th> 
                    <th class="til_09">操 作</th>                                 
                </tr> 
            </thead>
            <tbody class="ddf" id="show_result">
            </tbody>
        </table>
    </div>
<!--时间日期控件-->
<script src="<?php echo Url::to('@domain/js/datetimepicker/jquery.datetimepicker.js')?>"></script>
<script src="<?php echo Url::to('@domain/js/cms/article/manage.js')?>"></script>
<!--时间日期控件-->

<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->

<script>
    $(".discov a.cusde").click();
</script>