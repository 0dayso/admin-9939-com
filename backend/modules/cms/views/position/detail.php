
<!-- 广告位管理 首页 -->
<?php
use yii\helpers\Url;

$this->title = "查看广告位";
?>

<div class="dis-bread">
    <a href="/">首页</a>
    >
    <a href="<?php echo Url::toRoute('/cms/default/index'); ?>">内容管理</a>
    >
    <a href="<?php echo Url::toRoute('/cms/position/index'); ?>" class="bolde">广告位管理</a>
</div>

<div class="dis-main">
    <div class="d-titr">
        <a href="<?php echo Url::toRoute('/cms/position/index'); ?>">返回</a>
        <h3>查看广告位</h3>
    </div>

    <form class="edito" action="" method="post" id="form">
        <div>
            <label>
                <span>*</span>
                广告位名称：
            </label>
            <input type="text" class="txco" disabled="disabled" value="<?php echo $position['name']; ?>">
        </div>
        <div>
            <label>
                <span>*</span>
                标识代码&nbsp;：
            </label>
            <input type="text" class="txco" disabled="disabled" value="<?php echo $position['code']; ?>">
        </div>
        <div>
            <label>
                <span>*</span>
                宽&nbsp;&nbsp;&nbsp;&nbsp;：
            </label>
            <input type="text" class="txco" disabled="disabled" value="<?php echo $position['width']; ?>">
        </div>
        <div>
            <label>
                <span>*</span>
                高&nbsp;&nbsp;&nbsp;&nbsp;：
            </label>
            <input type="text" class="txco" disabled="disabled" value="<?php echo $position['height']; ?>">
        </div>
        <div>
            <label>
                <span>*</span>
                广告数量&nbsp;：
            </label>
            <input type="text" class="txco" disabled="disabled" value="<?php echo $position['items']; ?>">
        </div>
        <div>
            <label>
                备注&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;：
            </label>
            <textarea class="txtar" disabled="disabled"><?php echo $position['remark']; ?></textarea>
        </div>
    </form>
</div>

