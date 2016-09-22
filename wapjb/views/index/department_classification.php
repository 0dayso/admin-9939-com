<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<h2><a href="/jbzz/keshi/">更多<span>></span></a>科室分类</h2>
<!--科室分类-->
<ul class="classfi">
    <?php
    if (!empty($department_classification)) {
        foreach ($department_classification as $k => $v) {
            $dis_str = '';
            $a_tags = '';
            foreach ($v['disease'] as $kk => $vv) {
                $dis_str .= $vv['name'].',';
                $a_tags .= '<a href="' . Url::to('/' . $vv['pinyin_initial'] . '/') . '">' . $vv['name'] . '</a>';
            }
            $dis_str = trim($dis_str);
            ?>
            <li>
                <h3><?php echo $midDepartmentMap[$k]['0']; ?></h3>
                <p><?php echo $dis_str; ?></p>
                <span></span>
                <div class="sepc disn clearfix">
                    <?php echo $a_tags; ?>
                    <a href="<?php echo $midDepartmentMap[$k]['1']; ?>">更多…</a>
                    <span></span>
                </div>
            </li>

            <?php
        }
    }
    ?>
</ul>

