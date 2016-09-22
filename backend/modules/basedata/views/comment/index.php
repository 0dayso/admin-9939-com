<?php
use yii\helpers\Url;
$this->title = "评价管理";
?>

<div class="dis-bread">
    <a href="/">首页</a>>
    <a href="/basedata/default/index">基础数据</a>>
    <a href="/basedata/comment/index" class="bolde">评价管理</a>
</div>

<div class="dis-main">
    <div class="d-titr d-manar">
        <a href="/basedata/comment/add">新建等级</a>
        <h3>评价管理 — 评价管理列表</h3></div>
    <table border="1" cellspacing="0" class="tablay sugged">
        <thead>
            <tr style="border-left: 1px solid #ececec;">
                <th>全部<input type="checkbox" class="d-asrl"/></th>
                <th>编号</th>
                <th>评价等级</th>
                <th class="pr_01">评价内容</th>
                <th>添加时间</th>
                <th>添加人</th>
                <th>操 作</th>
            </tr>
        </thead>

        <tbody class="ddf">
        <?php
            foreach ($comments as $key => $comment){
        ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $comment['id']; ?>"/></td>
                    <td><?php echo $comment['id']; ?></td>
                    <td><?php echo $comment['name']; ?></td>
                    <td><?php echo $comment['content']; ?></td>
                    <td><?php echo $comment['addtime']; ?></td>
                    <td><?php echo $comment['username']; ?></td>
                    <td>
                        <a href="/basedata/comment/edit?id=<?php echo $comment['id']; ?>" class="d-gray">编辑</a>
                    </td>
                </tr>
        <?php
            }
        ?>
        </tbody>
    </table>

    <div class="paget">
        <?php echo $pageHTML; ?>
    </div>
</div>