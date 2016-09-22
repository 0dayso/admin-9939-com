<?php
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
?>
<div class="qbwrt qbwrt_shn" style="display:none;">
    <div class="d-list-form">
        <div class="d-titr  d-grew">
            <a href="javascript:void(0);" class="d-errtu"><img src="<?php echo Url::to("@domain/images/d-wor.png");?>"/></a>
            <h3>添加相关疾病内容</h3>
        </div>
        
        
        
        <form class="disin fosub infc" method="post" name="search">
            <input type="hidden" name="search" value="1">
            <input type="hidden" name="symptomid" value="<?php // echo $relDisease['symptomid'];?>">
            <label>一级科室：</label>
            <select class="level" name="class_level1" id="class_level1">
                <option>请选择</option>
                <?php
                foreach($allArticle['department'] as $k=>$v){
                ?>
                <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                <?php
                }
                ?>
            </select>
            
            
            <label>二级科室：</label>
<!--            <select class="level" multiple id="class_level2" name="class_level2" size="2">-->
            <select class="level" id="class_level2" name="class_level2">
            </select>
                
            <a href="javascript:void(0);" id="searchBtn">搜索</a>
        </form>
        
        <table width="990" border="1" cellspacing="0">
            <thead class="ells-four">
            <tr>
                <th></th>
                <th>序号</th>
                <th>id</th>
                <th>疾病名称 </th>
            </tr>
            </thead>
            <tbody class="ddf" id="disease_list">
        
            </tbody>
        </table>
        
        
        <div class="d-kodrl">
            <a href="javascript:void(0);" class="d-save-elec">保存选择</a>
            <a href="javascript:void(0);" class="d-sr-elec">取消选择</a>
        </div>
    </div>
    
        
</div>

<script>
rel_disease_department_level2_ajaxUrl = '<?php echo Url::to(['/cms/article/ajax-department']);?>';
rel_disease_search_ajaxUrl = '<?php echo Url::to(['/cms/article/ajax-add-relate-disease']);?>';
</script>
<script src="<?php echo Url::to('@domain/js/cms/article/dialog_rel_disease.js')?>"></script>