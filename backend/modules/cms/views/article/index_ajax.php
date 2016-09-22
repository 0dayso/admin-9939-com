<?php
use yii\helpers\Html;
use yii\helpers\Url;

if(count($model['articles'])>0){
?>
            <?php
                $articleStatus = [
                    '11' => '未发布',
                    '99' => '已发布',
                    '0' => '回收站',
                ];
                foreach ($model['articles'] as $v) { 
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
                        <a href="javascript:void(0);" onclick="delInfo(this)" data-href="<?php echo Url::to([ '/cms/article/set-article', 'id' => $v['info']['id']]); ?>" data-url="<?php echo Url::to([ '/cms/article/set-article']); ?>" data-id="<?php echo $v['info']['id']; ?>" class="d-delet">删除</a>
                    </td>
                </tr> 
            <?php
            }
            ?>
            <tr>
                <td colspan="9">
                <div class="paget">
<!--                    <a href="" class="hko kos">&lt;&lt;</a><a href="" class="curt">1</a><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a><span>...</span><a href="">10</a><a href="" class="hko">&gt;&gt;</a>-->
                    <?php echo $model['paging']->view();?>
                </div>
                </td>
            </tr>
<?php
}else{
?>
        <tr>
            <td colspan="9" align="center">根据条件暂时还查不到数据</td>
        </tr>
<?php
}
?>