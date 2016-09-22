
<!-- 广告位管理 首页 -->
<?php
use yii\helpers\Url;

$this->title = "广告效果";
?>

<div class="dis-bread">
    <a href="/">首页</a>
    >
    <a href="<?php echo Url::toRoute('/cms/default/index'); ?>">内容管理</a>
    >
    <a href="<?php echo Url::toRoute('/cms/admanage/stat'); ?>" class="bolde">广告效果</a>
</div>
<div class="dis-main">

    <div class="d-titr d-manar clearfix">
        <a href="<?php echo Url::toRoute('/cms/admanage/index'); ?>">返回</a>
        <h3>广告效果</h3>
    </div>

    <table border="1" cellspacing="0" class="tablay">
        <thead>
            <tr style="border-left: 1px solid #ececec;">
                <th class="to_01">广告名称</th>
                <th class="to_02">PV</th>
                <th class="to_03">UV</th>
                <th class="to_04">IP</th>
                <th class="to_05">时间</th>
            </tr>
        </thead>

        <tbody class="ddf">
        <tr>
            <td><?php echo $ad['archive_name']; ?></td>
            <td><?php echo $stat['pv']; ?></td>
            <td><?php echo $stat['uv']; ?></td>
            <td><?php echo $stat['ip']; ?></td>
            <td><?php echo $stat['updatetime_str']; ?></td>
        </tr>
        </tbody>
    </table>
</div>