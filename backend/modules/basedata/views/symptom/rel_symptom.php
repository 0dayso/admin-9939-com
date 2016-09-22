<div class="modal-body" id="allSymptom">
    <?php
    foreach($model as $v){
    ?>
    <a data-id="<?php echo $v['id'];?>" class="btn btn-info btn-sm" style="margin:5px;"><?php echo $v['name'];?></a>
    <?php
    }
    ?>
</div>