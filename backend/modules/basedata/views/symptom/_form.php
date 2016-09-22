<?php
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use backend\models\Ueditor;

if($model!==false){
    $symptom = $model;
    $symptomContent = ArrayHelper::toArray($model->content);
}else{
    $symptom = [];
    $symptomContent = [];
}

//print_r($allSymptom['relatePart']);
//exit;
//print_r($relateSymptoms);
//exit;
?>


<style type="text/css">
/*.edito div label { width:7%; text-align:right;}*/
#selectedImages li img { border:1px solid #ccc; padding: 4px; cursor: pointer;}
#selectedImages li input { position:absolute; bottom: 10px; left: 9px; width: 20px; height:20px; margin-right: 0px; color: #009967; opacity: 0.8}
.selectImg { border: 5px solid #F00 !important; padding: 0px !important;}
.edito .swfBtn { background:#f1f1f1; border:1px solid #dedede; width:80px; height:26px; line-height:26px; text-align:center; color:#555; border-radius:2px; -webkit-border-radius:2px;}
.edito .uploadify-button-text { color: #555; background:none; margin: 0px; text-align: center; float:none;}
</style> 

<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/js/uploadify/uploadify.css')?>"/>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/uploadify/jquery.uploadify.min.js')?>"></script>

<form method="post" name="edit" enctype="multipart/form-data" action="" class="edito">

    <input type="hidden" name="symptomForm[id]" value="<?php echo $symptom ? $symptom['id'] : ''?>">
    <input type="hidden" name="symptomContentForm[id]" value="<?php echo $symptom ? $symptom['id'] : ''?>">
    <input type="hidden" name="symptomRelate[id]" value="<?php echo $symptom ? $symptom['id'] : ''?>">
    
    <div>
        <label><span>*</span>症状名称：</label>
        <input type="text" class="txco" required="true" id="title" name="symptomForm[name]" placeholder="症状名称" value="<?php echo $symptom ? $symptom['name'] : ''?>">
    </div>
    
    <div>
        <label><span>*</span>所属部位： </label>
        <select class="level infose" name="partRelate[part_level1]" id="class_level1">
            <option>请选择</option>
            <?php
            foreach($allSymptom['relSymptom']['part'] as $k=>$v){
                if($v['level'] == 1){
                ?>
                <option value="<?php echo $v['id'] ?>" <?php echo $v['id'] == $allSymptom['relatePart'][0]['id'] ? 'selected':'';?>><?php echo $v['name'] ?></option>
                <?php
                }
            }
            ?>
        </select>
        <label>二级部位：</label>
        <select class="level infose" id="class_level2" name="partRelate[part_level2]">
            <?php if(count($allSymptom['relatePart']) == 2){?>
            <option value="<?php echo $allSymptom['relatePart'][1]['id']?>"><?php echo $allSymptom['relatePart'][1]['name']?></option>
            <?php }else{?>
            <option>无二级部位</option>
            <?php }?>
        </select>
    
    </div>
    
    <div style="display:none;">
        <label><span>*</span>关 键 词：</label>
        <input type="text" class="txco" id="title" name="symptomForm[keywords]" placeholder="关键词" value="<?php echo $symptom ? $symptom['keywords'] : ''?>">
    </div>
    
    <div>
        
        <label><span>*</span>相关疾病：</label><a class="add admale d-pop-dow">添加</a><b class="lema">注：添加相关疾病内容</b>
        <input type="hidden" class="txco" required="true" id="disease_rel_hide" name="diseaseRelate[disease_rel]" value="">
    </div>
    <div class="hasad" id="rel_disease"><?php
//    print_r($allSymptom['relateDiseases']);exit;
    if( $allSymptom['relateDiseases'] !== 0 ){
        foreach($allSymptom['relateDiseases'] as $v){
    ?>
        <a id="<?php echo $v['id'];?>" href="javascript:void(0);"><?php echo $v['name'];?><b></b></a>
    <?php
        }
    }
    ?></div>
    
    
    <div>
        <label><span>*</span>相关症状：</label><a class="add admale d-pop-up">添加</a><b class="lema">注：添加相关症状内容</b>
        <input type="hidden" class="txco" required="true" id="symptom_rel_hide" name="symptomRelate[symptom_rel]" value="">
    </div>
    <div class="hasad" id="rel_symptom"><?php
    if( $allSymptom['relateSymptoms'] !== 0 ){
        foreach($allSymptom['relateSymptoms'] as $v){
    ?>
        <a id="<?php echo $v['id'];?>" href="javascript:void(0);"><?php echo $v['name'];?><b></b></a>
    <?php
        }
    }
    ?></div>
    
    <div class="scal">
        <label><span>*</span>疾病图集：</label>
        <input type="file" name="file_upload" id="file_upload" /><b class="conc" style="position:absolute; top:0px; left:185px;">注：选中图为头图，图片不能大于1M</b>
        <input type="hidden" value="" required="true" name="diseaseImage" id="diseaseImage">
        <ul class="imop" id="selectedImages">
                <?php
                if (isset($allSymptom['diseaseImage']) && !empty($allSymptom['diseaseImage'])) {
                        foreach ($allSymptom['diseaseImage'] as $image){
                                $name = strstr($image['name'], ".", true);
                ?>
                <li>
                    <div class="imgs">
                        <input type="checkbox" value="<?php echo $image['name'];?>"<?php if($image['weight']=='1'){
                            echo ' checked="checked"';
                        }else{
                            echo ' ';
                        }?> onclick="setImgWeight(this)">
                        <img src="<?php echo Url::to($allSymptom['imgPath'] . $image['name']);?>" onclick="thumbPreview(this)" alt="<?php echo $image['name'];?>"<?php if($image['weight']=='1'){
                            echo ' class="selectImg"';
                        }else{
                            echo '';
                        }?>>
                        <b id="<?php echo $name;?>" data-id="<?php echo $image['name'];?>" data-weight='<?php echo $image['weight'];?>' onclick="delimg(this)"></b>
                    </div>
                </li>
                <?php 		
                        }
                }
                ?>
        </ul>
        <div id="some_file_queue"></div>
        <div class="clear"></div>
    </div>
    
    <div>
         <label><span>*</span>概　　述：</label>
         <textarea class="txtar" id="description" required="true" name="symptomForm[description]"><?php echo  $symptom ? $symptom['description'] : ''?></textarea>
         <script id="description" name="symptomForm[description]" type="text/plain"><?php echo  $symptom ? $symptom['description'] : ''?></script>
    </div>
    
    <div>
         <label><span>*</span>原　　因：</label>
         <textarea class="txtar" id="cause" required="true" name="symptomContentForm[cause]"><?php echo  $symptomContent ? $symptomContent['cause'] : ''?></textarea>
         <script id="cause" name="symptomContentForm[cause]" type="text/plain"><?php echo  $symptomContent ? $symptomContent['cause'] : ''?></script>
    </div>
    
    <div>
         <label><span>*</span>检　　查：</label>
         <textarea class="txtar" id="examine" required="true" name="symptomContentForm[examine]"><?php echo  $symptomContent ? $symptomContent['examine'] : ''?></textarea>
         <script id="examine" name="symptomContentForm[examine]" type="text/plain"><?php echo  $symptomContent ? $symptomContent['examine'] : ''?></script>
    </div>
    
    <div>
         <label><span>*</span>鉴别诊断：</label>
         <textarea class="txtar" id="diagnose" required="true" name="symptomContentForm[diagnose]"><?php echo  $symptomContent ? $symptomContent['diagnose'] : ''?></textarea>
         <script id="diagnose" name="symptomContentForm[diagnose]" type="text/plain"><?php echo  $symptomContent ? $symptomContent['diagnose'] : ''?></script>
    </div>
    
    <div>
         <label><span>*</span>缓解方法：</label>
         <textarea class="txtar" id="relieve" required="true" name="symptomContentForm[relieve]"><?php echo  $symptomContent ? $symptomContent['relieve'] : ''?></textarea>
        <script id="relieve" name="symptomContentForm[relieve]" type="text/plain"><?php echo  $symptomContent ? $symptomContent['relieve'] : ''?></script>
    </div>
    
    <div>
         <label><span>*</span>宜吃饮食：</label>
<!--         <textarea class="txtar" id="goodfood" required="true" name="symptomContentForm[goodfood]"><?php echo  $symptomContent ? $symptomContent['goodfood'] : ''?></textarea>-->
         <textarea class="txtar" id="goodfood" required="true" name="symptomContentForm[goodfood]"><?php echo  $symptomContent ? $symptomContent['goodfood'] : ''?></textarea>
         <script id="goodfood" name="symptomContentForm[goodfood]" type="text/plain"><?php echo  $symptomContent ? $symptomContent['goodfood'] : ''?></script>
    </div>
    
    <div>
         <label><span>*</span>忌吃饮食：</label>
<!--         <textarea class="txtar" id="badfood" required="true" name="symptomContentForm[badfood]"></textarea>-->
         <textarea class="txtar" id="badfood" required="true" name="symptomContentForm[badfood]"><?php echo  $symptomContent ? $symptomContent['badfood'] : ''?></textarea>
         <script id="badfood" name="symptomContentForm[badfood]" type="text/plain"><?php echo  $symptomContent ? $symptomContent['badfood'] : ''?></script>
    </div>
    
    
    
    <div class="savea">
        <a href="javascript:void(0);">保存</a>
        <a href="javascript:void(0);" class="sagai">保存并生成</a>
    </div>

</form>
<style>
    /*主样式与编辑器样式冲突*/
    .edui-default div { margin-bottom: 0px !important;}
</style>
<script type="text/javascript" charset="utf-8" src="<?php echo Url::to('@domain/libs/ueditor/ueditor.config.js')?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Url::to('@domain/libs/ueditor/ueditor.all.min.js')?>"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo Url::to('@domain/libs/ueditor/lang/zh-cn/zh-cn.js')?>"></script>
<script type="text/javascript">
    //libs\ueditor\php\config.json修改配置
//    editors = ["description", "cause", "examine", "diagnose", "relieve", "goodfood", "badgood"];
//    for(i=0;i<editors.length;i++){
////        console.log(editors[i]);
//        var ue = UE.getEditor(editors[i],{
////            toolbars: [
////                        ['fullscreen', 'source', 'undo', 'redo', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
////                    ],
//            initialFrameWidth   : 900,
//            initialFrameHeight  : 300,
//        });
//    }

sid = '<?php echo session_id();?>';
</script>


<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->

<script type="text/javascript" src="<?php echo Url::to('@domain/js/symptom/upload.js')?>"></script>

<script>
img_upload_url = 'http://api.server.9939.com<?php echo Url::to(['/upload/index/','category'=>'symptom', 'sign'=>$allSymptom['sign']]);?>';    
img_delete_url = 'http://api.server.9939.com<?php echo Url::to(['/upload/delete/','category'=>'symptom', 'sign'=>$allSymptom['sign']]);?>';    
    
form_ajaxUrl = '<?php echo Url::to(['/basedata/symptom/ajax-part']);?>';
</script>
<script src="<?php echo Url::to('@domain/js/symptom/form.js')?>"></script>
<!--相关疾病弹出 开始-->
    <?php
    echo $this->render('rel_add_disease', [
        'allSymptom' => $allSymptom,
    ]);
    ?>
<!--相关疾病弹出 结束-->
    
<!--相关症状弹出 开始-->
    <?php
    echo $this->render('rel_add_symptom', [
        'allSymptom' => $allSymptom,
    ]);
    ?>
<!--相关症状弹出 结束-->



