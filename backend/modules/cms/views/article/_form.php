<?php
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use backend\models\Ueditor;

if($model['article']!==false){
    $article = $model['article']['info'];
    $disease = $model['article']['disease'];
//    $articleContent = ArrayHelper::toArray($model->content);
}else{
    $article = [];
    $disease = [];
//    $articleContent = [];
}

//print_r($model['article']);
//exit;
//print_r($relateSymptoms);
//exit;
?>
<style type="text/css">
/*.edito div label { width:7%; text-align:right;}*/
#selectedImages li img { border:1px solid #ccc; padding: 4px; cursor: pointer;}
#selectedImages li input { position:absolute; bottom: 10px; left: 9px; width: 20px; height:20px; margin-right: 0px; color: #009967; opacity: 0.8}
.selectImg { border: 5px solid #F00 !important; padding: 0px !important;}
.edito input[type="text"] { width:420px;}
.edito .swfBtn { background:#f1f1f1; border:1px solid #dedede; width:80px; height:26px; line-height:26px; text-align:center; color:#555; border-radius:2px; -webkit-border-radius:2px;}
.edito .uploadify-button-text { color: #555; background:none; margin: 0px; text-align: center; float:none;}
</style> 

<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/js/uploadify/uploadify.css')?>"/>

<form class="edito" name="edit" enctype="multipart/form-data" action="" method="post">
    <input type="hidden" name="articleForm[id]" value="<?php echo $article ? $article['id'] : ''?>">
    
    <div>
        <label><span>*</span>文章标题：</label>
        <input type="text" class="txco" required="true" id="title" name="articleForm[title]" placeholder="文章标题" value="<?php echo $article ? $article['title'] : ''?>">
    </div>
    <div>
        <label><span>*</span>所属疾病：</label>
        <a class="add admale d-pop-dow">添加</a>
        <input type="hidden" class="txco" required="true" id="disease_rel_hide" name="diseaseRelate[disease_rel]" value="">
    </div>
    <div class="hasad" id="rel_disease">
        <?php
        if ($disease !== 0) {
            foreach ($disease as $v) {
                ?>
                <a id="<?php echo $v['id']; ?>" href="javascript:void(0);"><?php echo $v['name']; ?><b></b></a>
                <?php
            }
        }
        ?>
    </div>
    <div class="visla clearfix">
        <label><span>*</span>文章分类：</label>
        <select class="level levc" id="type" name="articleForm[type]">
            <option value="0">请选择分类</option>
            <?php
            foreach($model['articleType'] as $k=>$v){
                if($article){
                    $select = $article['type'] == $k ? 'selected' : '';
                }else{
                    $select = '';
                }
                echo "<option value=\"{$k}\" {$select}>{$v}</option>\n";
            }
            ?>
        </select>
    </div>
    <div>
        <label><span>*</span>来　　源：</label>
        <input type="text" class="txco" required="true" id="copyfrom" name="articleForm[copyfrom]" placeholder="来源" value="<?php echo $article ? $article['copyfrom'] : ''?>">
    </div>
    <div>
        <label><span>*</span>作　　者：</label>
        <input type="text" class="txco" required="true" id="author" name="articleForm[author]" placeholder="作者" value="<?php echo $article ? $article['author'] : ''?>">
    </div>
    <div>
        <label><span>　</span>关 健 字：</label>
        <input type="text" class="txco" id="keywords" name="articleForm[keywords]" placeholder="关健字" value="<?php echo $article ? $article['keywords'] : ''?>">
        <b>注：关键字之间用空格分开</b>
    </div>
    
    
    <div class="scal">
        <label><span>　</span>缩 略 图：</label>
        <input type="file" name="file_upload" id="file_upload" /><b class="conc" style="position:absolute; top:0px; left:185px;">注：选中图为头图，图片不能大于1M</b>
        <input type="hidden" value="0" name="diseaseImage" id="diseaseImage"><!--默认值为0表示可以允许不上传缩略图-->
        <ul class="imop" id="selectedImages">
                <?php
//                print_r($model['diseaseImage']);
//                exit;
                if (isset($model['diseaseImage']) && !empty($model['diseaseImage'])) {
                        foreach ($model['diseaseImage'] as $image){
                                $name = strstr($image['name'], ".", true);
                ?>
                <li>
                        <input type="checkbox" value="<?php echo $image['name'];?>"<?php if($image['weight']=='1'){
                            echo ' checked="checked"';
                        }else{
                            echo ' ';
                        }?> onclick="setImgWeight(this)">
                        
                        <img src="<?php echo Url::to($model['imgPath'] . $image['name']);?>" onclick="thumbPreview(this)" alt="<?php echo $image['name'];?>"<?php if($image['weight']=='1'){
                            echo ' class="selectImg"';
                        }else{
                            echo '';
                        }?>>
                        
                        <b id="<?php echo $name;?>" data-id="<?php echo $image['name'];?>" data-weight='<?php echo $image['weight'];?>' onclick="delimg(this)"></b>
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
        <label><span>*</span>文章摘要：</label>
        <textarea class="txtar" required="true" id="description" name="articleForm[description]"><?php echo  $article ? $article['description'] : ''?></textarea>
    </div>
    <div>
        <label><span>*</span>文章内容：</label>
        <script id="content" name="articleForm[content]" type="text/plain"><?php echo  $article ? $article['content'] : ''?></script>
    </div>    
    
    <div class="savea saag">
        <a href="javascript:void(0);">保存</a>
    </div>
</form>

<!--相关疾病弹出 开始-->
<?php
echo $this->render('rel_add_disease', [
    'allArticle' => $model['allArticle'],
]);
?>
<!--相关疾病弹出 结束-->

<style>
    .edui-editor { margin-left: 12px;}/*对齐*/
    .edui-default div { margin-bottom: 0px !important;}/*主样式与编辑器样式冲突*/
</style>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/uploadify/jquery.uploadify.min.js')?>"></script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/cms/article/upload.js')?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Url::to('@domain/libs/ueditor/ueditor.config.js')?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Url::to('@domain/libs/ueditor/ueditor.all.min.js')?>"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo Url::to('@domain/libs/ueditor/lang/zh-cn/zh-cn.js')?>"></script>

<!-- 弹出提示框部分 Start -->
<link rel="stylesheet" type="text/css" href="<?php echo Url::to('@domain/css/jquery.dialogbox.css')?>">
<div id="dialog"></div>
<script src="<?php echo Url::to('@domain/js/jquery.dialogBox.js')?>"></script>
<!-- 弹出提示框部分 End -->

<script type="text/javascript">
        //libs\ueditor\php\config.json修改配置
    editors = ["content"];
    for(i=0;i<editors.length;i++){
//        console.log(editors[i]);
        var ue = UE.getEditor(editors[i],{
//            toolbars: [
//                        ['fullscreen', 'source', 'undo', 'redo', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
//                    ],
            initialFrameWidth   : 770,
            initialFrameHeight  : 300,
        });
    }

//    img_upload_url = '<?php echo Url::to(['/upload/index/','category'=>'article']);?>';
//    img_delete_url = '<?php echo Url::to(['/upload/delete/','category'=>'article']);?>';

img_upload_url = 'http://api.server.9939.com<?php echo Url::to(['/upload/index/','category'=>'article', 'sign'=>$model['sign']]);?>';    
img_delete_url = 'http://api.server.9939.com<?php echo Url::to(['/upload/delete/','category'=>'article', 'sign'=>$model['sign']]);?>';  
    
    form_ajaxUrl = '<?php echo Url::to(['/basedata/symptom/ajax-part']);?>';
</script>
<script type="text/javascript" src="<?php echo Url::to('@domain/js/cms/article/form.js')?>"></script>