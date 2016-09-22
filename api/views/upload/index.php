<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$action = Url::to(['/upload/demo/','category'=>'symptom']);
?>
<div class="article-form">
    <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data">
        <input type="file" name="file_upload" id="file_upload" />
        <ul class="imop" id="selectedImages">
        </ul>
        <div id="some_file_queue"></div>
        <input type="submit" value="send" style="border: 1px solid #ccc;">
    </form>
    
    
</div>
