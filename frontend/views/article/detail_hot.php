<!-- 文章页 热搜部分 -->

<div class="conet">

    <?php
    $model['currLetter'] = 'A';//拼音简写的第一个字母
    $model['randWords'] = $hotWords;
    echo $this->render('/include/foot_zimu', [
        'model' => $model
    ]);
    ?>
    <div class="wd_pd">
        <div class="wd_pd_z">
            <div class="bdisea">
                <a class="indexahover">常见疾病</a>
                <a>热门部位</a>
            </div>
            <div class="wd_qh shc">
                <div class="firin">
                    <a class="indexahover" href="/jbzz/jizhenke/">急诊科</a>
                    <a class="" href="/jbzz/neike/">内科</a>
                    <a class="" href="/jbzz/waike/">外科</a>
                    <a class="" href="/jbzz/fuchanke/">妇产科</a>
                    <a class="" href="/jbzz/erke/">儿科</a>
                    <a class="" href="/jbzz/nanke/">男科</a>
                    <a class="" href="/jbzz/pifuxingbingke/">皮肤性病科</a>
                    <a class="" href="/jbzz/wuguanke/">五官科</a>
                    <a class="" href="/jbzz/zhongyike/">中医科</a>
                    <a class="" href="/jbzz/zhongliuke/">肿瘤科</a>
                    <a class="" href="/jbzz/ganbing/">肝病</a>
                    <a class="" href="/jbzz/chuanranke/">传染科</a>
                    <a class="" href="/jbzz/xinlike/">心理科</a>
                    <a class="" href="/jbzz/jingshenke/">精神科</a>
                    <a class="" href="/jbzz/qitakeshi/">其他科室</a>
                    <a class="" href="/jbzz/yingyangke/">营养科</a>
                    <a class="" href="/jbzz/shengzhijiankang/">生殖健康</a>
                </div>
                <?php
                $dep1 = array(
                    '0' => 'jizhenke',
                    '1' => 'neike',
                    '2' => 'waike',
                    '3' => 'fuchanke',
                    '4' => 'erke',
                    '5' => 'nanke',
                    '6' => 'pifuxingbingke',
                    '7' => 'wuguanke',
                    '8' => 'zhongyike',
                    '9' => 'zhongliuke',
                    '10' => 'ganbing',
                    '11' => 'chuanranke',
                    '12' => 'xinlike',
                    '13' => 'jingshenke',
                    '14' => 'qitakeshi',
                    '15' => 'yingyangke',
                    '16' => 'shengzhijiankang',
                );
                ?>
                <div class="disesl">
                    <?php
                    $i = true;
                    foreach ($dep1 as $k => $level1_pinyin) {
                        if (isset($commonDisDep['department'][$level1_pinyin]) && is_array($commonDisDep['department'][$level1_pinyin])) {
                            $disn = $i ? '' : 'disn';
                            ?>
                            <div class="sepce <?php echo $disn; ?>">
                                <?php
                                foreach ($commonDisDep['department'][$level1_pinyin] as $kk => $level2) {
                                    echo '<a href="/jbzz/' . $level2['pinyin'] . '/" target="_blank" title="' . $level2['name'] . '">'.$level2['name'].'</a>';
                                }
                                ?>
                            </div>

                            <?php

                        }
                        $i = false;
                    }
                    ?>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="wd_qh disn">
                <div class="firin"><a class="indexahover" href="/jbzz/toubu/">头部</a>
                    <a class="" href="/jbzz/jingbu/">颈部</a>
                    <a class="" href="/jbzz/xiongbu/">胸部</a>
                    <a class="" href="/jbzz/fubu/">腹部</a>
                    <a class="" href="/jbzz/yaobu/">腰部</a>
                    <a class="" href="/jbzz/tunbu/">臀部</a>
                    <a class="" href="/jbzz/shangzhi/">上肢</a>
                    <a class="" href="/jbzz/xiazhi/">下肢</a>
                    <a class="" href="/jbzz/gu/">骨</a>
                    <a class="" href="/jbzz/huiyinbu/">会阴部</a>
                    <a class="" href="/jbzz/nanxingshengzhi/">男性生殖</a>
                    <a class="" href="/jbzz/nvxingshengzhi/">女性生殖</a>
                    <a class="" href="/jbzz/penqiang/">盆腔</a>
                    <a class="" href="/jbzz/quanshen/">全身</a>
                    <a class="" href="/jbzz/xinli/">心理</a>
                    <a class="" href="/jbzz/beibu/">背部</a>
                    <a class="" href="/jbzz/qita/">其他</a></div>
                <?php
                $part1 = array(
                    '0' => 'toubu',
                    '1' => 'jingbu',
                    '2' => 'xiongbu',
                    '3' => 'fubu',
                    '4' => 'yaobu',
                    '5' => 'tunbu',
                    '6' => 'shangzhi',
                    '7' => 'xiazhi',
                    '8' => 'gu',
                    '9' => 'huiyinbu',
                    '10' => 'nanxingshengzhi',
                    '11' => 'nvxingshengzhi',
                    '12' => 'penqiang',
                    '13' => 'quanshen',
                    '14' => 'xinli',
                    '15' => 'beibu',
                    '16' => 'qita',
                );
                ?>
                <div class="disesl">
                    <?php
                    $i = true;
                    foreach ($part1 as $k => $level1_pinyin) {
                        if (isset($commonDisDep['part'][$level1_pinyin]) && is_array($commonDisDep['part'][$level1_pinyin])) {
                            $disn = $i ? '' : 'disn';
                            ?>
                            <div class="sepce <?php echo $disn; ?>">
                                <?php
                                foreach ($commonDisDep['part'][$level1_pinyin] as $kk => $level2) {
                                    echo '<a href="/jbzz/' . $level2['pinyin'] . '/" target="_blank" title="' . $level2['name'] . '">'.$level2['name'].'</a>';
                                }
                                ?>
                            </div>
                            <?php
                        }
                        $i = false;
                    }
                    ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>