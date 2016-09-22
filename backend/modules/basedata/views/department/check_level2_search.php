<?php
 use yii\helpers\Url;
?>
<table border="1" cellspacing="0" class="decon"> 
        <thead>
            <tr style="border-left: 1px solid #ececec;"> 
                <th class="de_01">全部<input  class="d-asrl" type="checkbox" id="select_all" /></th> 
                <th class="de_02">ID</th>
                <th class="de_03">科室疾病</th> 
                <th class="de_04">操 作</th>                                 
            </tr> 
        </thead>
        <tbody class="ddf">
            <?php
            if ($disease) {
                foreach ($disease as $key => $val) {
                    ?>
                    <tr>
                        <td><input type="checkbox" name="checkbox[]"/></td>
                        <td><?php echo $val['id']; ?></td>
                        <td><?php echo $val['name']; ?></td>
                        <td>
                            <a href="javascript:;" class="d-delet" name="<?php echo $val['name']; ?>" id="<?php echo $val['id']; ?>">删&nbsp;除</a>
                        </td>
                    </tr>
                    <?php
                }
            }else{
                ?>
               <tr>
                   <td colspan="4" style="text-align:'center';">无内容</td>
               </tr>
                    <?php
            }
            ?>
        </tbody>
    </table>
    <div class="paget">
        <?php echo $page_html->view();?>
    </div>