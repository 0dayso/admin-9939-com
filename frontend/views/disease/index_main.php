
<style>
    .niname li p {
        float: left;
        font-size: 14px;
        height: 100%;
        line-height: 38px;
        width: 50%;
    }
</style>

<!-- 首页 疾病信息 部分 -->
<div class="art_wra" style="margin:0 auto;">
    <div class="art_l">
        <div class="widsp">
            <a href="/<?php echo $disease['pinyin_initial']; ?>/tuji/">
                <img src="<?php echo $disease['thumb']; ?>" alt="<?php echo $disease['name']; ?>" title="<?php echo $disease['name']; ?>">
            </a>
            <b><?php echo $disease['name']; ?></b>
            <p><?php echo \librarys\helpers\utils\String::cutString($disease['description'], 135); ?>
                <a href="/<?php echo $disease['pinyin_initial']; ?>/jianjie/" target="_blank">[详细]</a>
            </p>
            <div class="moim"><a href="/<?php echo $disease['pinyin_initial']; ?>/tuji/">更多图集</a></div>
        </div>

        <!-- 基本信息 Start -->
        <ul class="niname">
            <li>
                <p title="<?php echo $disease['alias']; ?>">
                    <span>别名：</span>
                    <?php
                    if (isset($disease['alias_arr']) && !empty($disease['alias_arr'])) {
                        $len = 0;
                        $max = 20;
                        foreach ($disease['alias_arr'] as $alias){
                            $currentLen = $len + mb_strlen($alias, 'utf-8');
                            if ($currentLen > $max){
                                ?>
                                <a  title="<?php echo $alias; ?>" style="cursor: default">
                                    <?php echo \librarys\helpers\utils\String::cutString($alias, $max - $len, 0); ?>
                                </a>
                                <?php
                                break;
                            }else{
                                ?>
                                <a  title="<?php echo $alias; ?>" style="cursor: default"><?php echo $alias; ?></a>
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
                <p><span>是否属于医保：</span> 暂无 </p>
            </li>
            <li>
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
                <p><span>挂号科室：</span>
                    <?php
                    if (isset($disease['department']) && !empty($disease['department'])) {
                        foreach ($disease['department'] as $department){
                    ?>
                            <a href="/jbzz/<?php echo $department['pinyin']; ?>/"><?php echo $department['name']; ?></a>
                    <?php
                        }
                    }
                    ?>
                </p>
            </li>
            <li><p><span>传染方式：</span><?php echo $disease['chuanranfangshi']; ?></p>
                <p><span>易感人群：</span><?php echo $disease['yiganrenqun']; ?></p></li>
            <li>
                <p><span>典型症状：</span>
                    <?php
                    if (isset($disease['tsymptom']) && !empty($disease['tsymptom'])) {
                        $len = 0;
                        $max = 12;
                        foreach ($disease['tsymptom'] as $symptom){
                            $currentLen = $len + mb_strlen($symptom['name'], 'utf-8');
                            if ($currentLen > $max){
                                ?>
                                <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/" title="<?php echo $symptom['name']; ?>">
                                    <?php echo \librarys\helpers\utils\String::cutString($symptom['name'], $max - $len, 0); ?>
                                </a>...
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
                    <a href="/<?php echo $disease['pinyin_initial']; ?>/zz/" class="tain">[详细]</a>
                </p>
                <p><span>治疗方法：</span><?php echo $disease['treatment']; ?></p>
            </li>
            <li><p><span>临床检查：</span><?php echo \librarys\helpers\utils\String::cutString($disease['inspect'], 18); ?><a href="/<?php echo $disease['pinyin_initial']; ?>/lcjc/" class="tain">[详细]</a></p>
                <p><span>常用药品：</span>

                    <?php
                    if (isset($disease['medicine']) && !empty($disease['medicine'])) {
                        $len = 0;
                        $max = 20;
                        foreach ($disease['medicine'] as $medicine){
                            $currentLen = $len + mb_strlen($medicine, 'utf-8');
                            if ($currentLen > $max){
                                ?>
                                <a  title="<?php echo $medicine; ?>" style="cursor: default">
                                    <?php echo \librarys\helpers\utils\String::cutString($medicine, $max - $len, 0); ?>
                                </a>
                                <?php
                                break;
                            }else{
                                ?>
                                <a  title="<?php echo $medicine; ?>" style="cursor: default"><?php echo $medicine; ?></a>
                                <?php
                            }
                            $len = $currentLen;
                        }
                    }
                    ?>
            </li>
        </ul>
        <!-- 基本信息 End -->

        <div class="adbp">
            <!-- 第一个广告位 Start -->
            <?php echo $this->render('index_ads_01'); ?>
            <!-- 第一个广告位 End -->
        </div>
        <div class="finare">
            <img src="/images/funare.png" class="syhi">
            <ul class="shona">
                <li><a href="/<?php echo $disease['pinyin_initial']; ?>/jzzn/"><img src="/images/gui_01.png"></a><a href="/<?php echo $disease['pinyin_initial']; ?>/jzzn/">就诊指南</a></li>
                <li><a href="/zicha/jbzc/"><img src="/images/gui_02.png"></a><a href="/zicha/jbzc/">症状自查</a></li>
                <li><a href="/<?php echo $disease['pinyin_initial']; ?>/yy/"><img src="/images/gui_03.png"></a><a href="/<?php echo $disease['pinyin_initial']; ?>/yy/">查找医院</a></li>
                <li><a href="/<?php echo $disease['pinyin_initial']; ?>/ys/"><img src="/images/gui_04.png"></a><a href="/<?php echo $disease['pinyin_initial']; ?>/ys/">查找医生</a></li>
                <li><a href="/<?php echo $disease['pinyin_initial']; ?>/yaopin/"><img src="/images/gui_05.png"></a><a href="/<?php echo $disease['pinyin_initial']; ?>/yaopin/">查找药品</a></li>
                <li><a href="<?php echo \yii\helpers\Url::to('@ask/Asking/index/');?>"><img src="/images/gui_06.png"></a><a href="<?php echo \yii\helpers\Url::to('@ask/Asking/index/');?>">免费问医</a></li>
            </ul>
        </div>
        <div class="tost nickn reart"><h2><a href="/<?php echo $disease['pinyin_initial']; ?>/zz/" class="amor">更多>></a><span><?php echo $disease['name']; ?></span>症状和表现</h2>
            <div class="cuchei">

                <p><span>症状：</span>
                    <?php
                    if (isset($symptoms) && !empty($symptoms)) {
                        foreach ($symptoms as $symptom){
                            ?>
                            <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/"><?php echo $symptom['name']; ?></a>
                            <?php
                        }
                    }
                    ?>
                </p>
                <p><span>表现：</span>
                    <?php
                    if (isset($disease['symptom']) && !empty($disease['symptom'])) {
                        ?>
                        <?php echo \librarys\helpers\utils\String::cutString($disease['symptom'], 150); ?>
                        <a href="/<?php echo $disease['pinyin_initial']; ?>/zz/">[详情]</a>
                        <?php
                    }
                    ?>
                </p>
            </div>
        </div>

        <ul class="direl explai">
            <?php
            if (isset($symptoms) && !empty($symptoms)) {
                foreach ($symptoms as $skey => $symptom){
                    ?>
                    <li>
                        <h3><?php echo $symptom['name']; ?></h3>
                        <p>
                            <b>解释：</b><?php echo \librarys\helpers\utils\String::cutString($symptom['description'], 50); ?>
                            <a href="/zhengzhuang/<?php echo $symptom['pinyin_initial']; ?>/">[详情]</a>
                        </p>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>

        <!-- 疾病自测部分 暂时隐去 -->
        <?php /*echo $this->render('index_selftest'); */?>

        <div class="tost nickn reart">
            <h2>
                <a href="/<?php echo $disease['pinyin_initial']; ?>/article_list.shtml" class="amor" target = "_blank">更多>></a>
                <span><?php echo $disease['name']; ?></span>全面解读
            </h2>
        </div>
        <ul class="cause">
            <?php
            if (isset($allReads) && !empty($allReads)) {
                foreach ($allReads as $allReadKey => $allRead){
            ?>
                    <li>
                        <dl>
                            <dt><?php echo $allReadKey; ?></dt>
                            <?php
                            if (isset($allRead) && !empty($allRead)) {
                                foreach ($allRead as $read){
                            ?>
                                    <dd>
                                        <a href="<?php echo $read['url']; ?>" title="<?php echo $read['title']; ?>"><?php echo $read['title']; ?></a>
                                    </dd>
                            <?php
                                }
                            }
                            ?>
                        </dl>
                    </li>
            <?php
                }
            }
            ?>
        </ul>
        <div class="tost nickn reart">
            <h2>
                <a href="<?php echo \yii\helpers\Url::to('@ask/classid/' . $v2snsKeshiID); ?>" class="amor">更多>></a>
                <span><?php echo $disease['name']; ?></span>患者关注的问题
            </h2>
            <ul class="hoque">
                <?php
                if (isset($asks['list']) && !empty($asks['list'])) {
                    foreach ($asks['list'] as $outerKey => $outerAsk){
                ?>
                        <li>
                            <dl>
                                <dt>
                                    <a href="<?php echo \yii\helpers\Url::to('@ask/id/' . $outerAsk['ask']['id']); ?>" title="<?php echo $outerAsk['ask']['title']; ?>">
                                        <?php
                                        if (isset($outerAsk['ask']) && !empty($outerAsk['ask'])) {
                                            ?>
                                            <?php echo $outerAsk['ask']['title']; ?>
                                            <?php
                                        }
                                        ?>
                                    </a>
                                </dt>
                                <dd>
                                    <?php
                                    if (isset($outerAsk['answer']) && !empty($outerAsk['answer'])) {
                                        echo \librarys\helpers\utils\String::cutString($outerAsk['answer']['content'], 32);
                                    }else{
                                        echo \librarys\helpers\utils\String::cutString($outerAsk['answer']['suggest'], 32);
                                    }
                                    ?>
                                    <a href="<?php echo \yii\helpers\Url::to('@ask/id/' . $outerAsk['ask']['id']); ?>">[详情]</a>
                                </dd>
                            </dl>
                        </li>
                <?php
                    }
                }
                ?>
                <li>
                    <dl class="onla newan">
                        <dt>在线提问<span>(百万医生免费为您做疾病解答)</span></dt>
                        <dd>
                            <form id="quick" name="quiz" method="post" action="http://ask.9939.com/Asking/index/" target="_blank" class="quiz" autocomplete="off">
                                <textarea id="quick_content" name="content" onfocus="javascript:if($('#quick_content').html()=='把您的问题描述一下') $('#quick_content').html('');" placeholder="请输入您的问题标题(5/30)" rows="2"></textarea>
                                <a href="javascript:void(0)" title="立即提问" onclick="return quick_ask()"><img src="/images/reas.png"></a>
                            </form>
                            <script>
                                function quick_ask(){
                                    if($("#quick_content").val()=="") {
                                        alert("请输入内容");
                                        $("#quick_content").focus();
                                        return false;
                                    } else if($("#quick_content").val()=="输入您的问题") {
                                        alert("请输入内容");
                                        $("#quick_content").focus();
                                        return false;
                                    } else if($("#quick_content").val().length<10 || $("#quick_content").val().length>500) {
                                        alert("内容字数要在：10-500 之间");
                                        $("#quick_content").focus();
                                        return false;
                                    }
                                    $("#quick").submit();
                                }
                            </script>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>

        <!-- 医生部分 Start -->
        <?php echo $this->render('index_doctor', ['doctors' => $doctors, 'name' => $disease['name']]); ?>
        <!-- 医生部分 End -->

        <!-- 医院部分 Start -->
        <?php echo $this->render('index_hospital', ['name' => $disease['name']]); ?>
        <!-- 医院部分 End -->

        <!-- 用药部分 Start -->
        <?php /*echo $this->render('index_drug'); */?>
        <!-- 用药部分 End -->

        <!--热门疾病-->
        <div class="rela_a a_labe">
            <div class="a_rea a_hop a_mar">
                <h2><b>猜你感兴趣</b></h2>
                <div class="aplces">
                    <?php echo $this->render('ads_cngxq'); ?>
                </div>
            </div>
        </div>

    </div>

    <!-- 首页右侧部分 Start -->
    <?php echo $this->render('index_right'); ?>
    <!-- 首页右侧部分 End -->

</div>