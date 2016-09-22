<!-- 疾病简介 -->

<?php
$diseaseName = $disease['name'];
$this->title =  "${diseaseName}的病因_症状_治疗_饮食_护理_图片_疾病百科_久久健康网";
$this->metaTags = [
    'keywords' => "${diseaseName}的病因,${diseaseName}的症状,${diseaseName}治疗方法,${diseaseName}饮食,${diseaseName}图片",
    'description' => "久久健康网-疾病百科频道提供专业、全面的${diseaseName}的病因、${diseaseName}的症状、${diseaseName}治疗方法、${diseaseName}饮食、${diseaseName}图片等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！",
];
?>

<!-- 导航 Start -->
<?php echo $this->render('index_nav', ['disease' => $disease]); ?>
<!-- 导航 End -->

<div class="conter">
    <div class="disea fl">
        <div class="tost bshare spread graco"><h2><span><?php echo $disease['name']; ?></span>简介</h2>
            <p><?php echo str_replace(PHP_EOL,"</p><p style='text-indent:2em'>",$disease['description']); ?></p>

            <!-- 分享 Start -->
            <?php echo $this->render('share', ['title' => $disease['name']]); ?>
            <!-- 分享 End -->
        </div>

        <div class="tost nickn graco"><h2><span><?php echo $disease['name']; ?></span>基本知识</h2>
            <div class="protex clearfix" style="overflow:visible;"><p><span>是否属于医保：</span> 暂无 </p>
                <p>
                <span>别名：</span>
                <?php
                    if (isset($disease['alias_arr']) && !empty($disease['alias_arr'])) {
                        $len = 0;
                        $max = 20;
                        foreach ($disease['alias_arr'] as $alias){
                            $currentLen = $len + mb_strlen($alias, 'utf-8');
                            if ($currentLen > $max){
                                ?>
                                <a  title="<?php echo $alias; ?>">
                                    <?php echo \librarys\helpers\utils\String::cutString($alias, $max - $len, 0); ?>
                                </a>
                                <?php
                                break;
                            }else{
                                ?>
                                <a  title="<?php echo $alias; ?>"><?php echo $alias; ?></a>
                                <?php
                            }
                            $len = $currentLen;
                        }
                    }else {
                    ?>
                    暂无
                    <?php
                    }
                    ?>
                </p>
                <p><span>发病部位：</span>
                    <?php
                    if (isset($disease['part']) && !empty($disease['part'])) {
                        $len = 0;
                        $max = 14;
                        foreach ($disease['part'] as $part){
                            $currentLen = $len + mb_strlen($part['name'], 'utf-8');
                            if ($currentLen > $max){
                                ?>
                                <a href="/jbzz/<?php echo $part['pinyin']; ?>/" title="<?php echo $part['name']; ?>">
                                    <?php echo \librarys\helpers\utils\String::cutString($part['name'], $max - $len, 0); ?>
                                </a>
                                <?php
                                break;
                            }else{
                                ?>
                                <a href="/jbzz/<?php echo $part['pinyin']; ?>/" title="<?php echo $part['name']; ?>"><?php echo $part['name']; ?></a>
                                <?php
                            }
                            $len = $currentLen;
                        }
                    }
                    ?>
                </p>
                <p><span>传染性：</span><?php echo $disease['chuanranxing']; ?> </p>
                <p><span>传播途径：</span><?php echo $disease['chuanranfangshi']; ?></p>
                <p><span>多发人群：</span><?php echo $disease['yiganrenqun']; ?></p>


                <div class="unisy">
                    <p style="margin-bottom: 0px;">
                        <span>典型症状：</span>
                        <?php
                        if (isset($disease['tsymptom']) && !empty($disease['tsymptom'])) {
                            $len = 0;
                            $max = 11;
                            foreach ($disease['tsymptom'] as $symptom){
                                $currentLen = $len + mb_strlen($symptom['name'], 'utf-8');
                                if ($currentLen > $max){
                                    ?>
                                    <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/" title="<?php echo $symptom['name']; ?>">
                                        <?php echo \librarys\helpers\utils\String::cutString($symptom['name'], $max - $len, 0); ?>
                                    </a>
                                    <?php
                                    break;
                                }else{
                                    ?>
                                    <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/" title="<?php echo $symptom['name']; ?>"><?php echo $symptom['name']; ?></a>
                                    <?php
                                }
                                $len = $currentLen;
                            }
                        }
                        ?>
                        <a class="aind" href="">[更多]</a>
                    </p>
                    <div class="stat disn">
                        <?php
                        if (isset($disease['tsymptom']) && !empty($disease['tsymptom'])) {
                            foreach ($disease['tsymptom'] as $symptom){
                         ?>
                                <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/" title="<?php echo $symptom['name']; ?>"><?php echo $symptom['name']; ?></a>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="unisy">
                    <p style="margin-bottom: 0px;">
                        <span>相关疾病：</span>
                        <?php
                        if (isset($disease['reldis']) && !empty($disease['reldis'])) {
                            $len = 0;
                            $max = 11;
                            foreach ($disease['reldis'] as $reldisease){
                                $currentLen = $len + mb_strlen($reldisease['name'], 'utf-8');
                                if ($currentLen > $max){
                                    ?>
                                    <a href="/<?php echo $reldisease['pinyin_initial']; ?>/" title="<?php echo $reldisease['name']; ?>">
                                        <?php echo \librarys\helpers\utils\String::cutString($reldisease['name'], $max - $len, 0); ?>
                                    </a>
                                    <?php
                                    break;
                                }else{
                                    ?>
                                    <a href="/<?php echo $reldisease['pinyin_initial']; ?>/" title="<?php echo $reldisease['name']; ?>"><?php echo $reldisease['name']; ?></a>
                                    <?php
                                }
                                $len = $currentLen;
                            }
                        }
                        ?>
                        <a class="aind">[更多]</a>
                    </p>
                    <div class="stat disn">
                        <?php
                        if (isset($disease['reldis']) && !empty($disease['reldis'])) {
                            foreach ($disease['reldis'] as $reldisease){
                                ?>
                                <a href="/<?php echo $reldisease['pinyin_initial']; ?>/" title="<?php echo $reldisease['name']; ?>">
                                    <?php echo $reldisease['name']; ?>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tost nickn aknol graco"><h2><span><?php echo $disease['name']; ?></span>诊疗知识</h2>
            <p><span>就诊科室：</span>
                <?php
                if (isset($disease['department']) && !empty($disease['department'])) {
                    foreach ($disease['department'] as $department){
                        ?>
                        <a href="/jbzz/<?php echo $department['pinyin']; ?>/"><?php echo $department['name']; ?></a>
                        <?php
                    }
                }else {
               ?>
               暂无
               <?php  	
                }
                ?>
            </p>
            <p><span>治疗方法：</span><?php echo $disease['treatment']; ?></p>


            <div class="refl">
                <span>常用药品：</span>
                <div>
                    <?php
                    if (isset($disease['medicine']) && !empty($disease['medicine'])) {
                        foreach ($disease['medicine'] as $medicine){
                            ?>
                            <a ><?php echo $medicine; ?></a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <p class="wartip watips">（温馨提示：以上资料仅供参考，具体情况请向医生详细咨询）</p>

        <div class="rela_a a_labe">
            <div class="a_rea a_hop a_mar">
                <h2><b>猜你感兴趣</b></h2>
                <div class="aplces">
                    <?php echo $this->render('ads_cngxq'); ?>
                </div>
            </div>
        </div>
        </div>

    <!-- 右侧 Start -->
    <?php echo $this->render('index_right'); ?>
    <!-- 右侧 End -->
</div>


    <div class="clear"></div>
</div>

