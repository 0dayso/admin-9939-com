<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;
$doctors_top = $data['doctors_top'];
$doctors_bottom = $data['doctors_bottom'];
$part_disease = $data['part_disease'];
?>
<!--第四屏 按部位查疾病 结束-->
<div class="content-one">
    <div class="peopl fl">
        <h2 class="dians bopl"><a href="http://qt.server.9939.com/jbzz/" class="morl">更多>></a><span></span>按部位查找</h2>
        <div class="bocla">
            <div class="perge fl">
                <a class="lefsy decur">男 性</a><a class="lewom">女 性</a><a class="risy decur">正 面</a><a class="bacb">背 面</a>

                <div class="mafron total">
                    <div class="head shocon"><img src="/images/head.png"></div>
                    <div class="breast dinone"><img src="/images/breast.png"></div>
                    <div class="should dinone"><img src="/images/should.png"></div>
                    <div class="waist dinone"><img src="/images/waist.png"></div>
                    <div class="undwe dinone"><img src="/images/undwe.png"></div>
                    <div class="leg dinone"><img src="/images/leg.png"></div>
                    <span class="thread"></span>
                </div>

                <div class="manbe total disn">
                    <div class="verte"><img src="/images/verte.png"></div>
                    <div class="neck dinone"><img src="/images/neck.png"></div>
                    <div class="breast dinone"><img src="/images/breast.png"></div>
                    <div class="cavity dinone"><img src="/images/cavity.png"></div>
                    <div class="bwais dinone"><img src="/images/bwais.png"></div>
                    <!--<div class="haunch dinone"><img src="/images/haunch.png"></div>-->
                    <!--<div class="phsyc dinone"><img src="/images/phsyc.png"></div>-->
                    <div class="whba dinone"><img src="/images/whob.png"></div>
                    <span class="thread"></span>
                </div>

                <div class="womfr total disn">
                    <div class="whead"><img src="/images/whead.png"></div>
                    <div class="wbreas dinone"><img src="/images/wbreas.png"></div>
                    <div class="wshould dinone"><img src="/images/wshould.png"></div>
                    <div class="wwaist dinone"><img src="/images/wwaist.png"></div>
                    <div class="wundwe dinone"><img src="/images/wundwe.png"></div>
                    <div class="wleg dinone"><img src="/images/wleg.png"></div>
                    <span class="thread"></span>
                </div>


                <div class="wombe total disn">
                    <div class="verte"><img src="/images/verte.png"></div>
                    <div class="wneck dinone"><img src="/images/wneck.png"></div>
                    <div class="wbrea dinone"><img src="/images/wbrea.png"></div>
                    <div class="cavi dinone"><img src="/images/cavi.png"></div>
                    <div class="bwais dinone" style="left:85px;"><img src="/images/bwais.png" width="56" height="21"></div>
                    <div class="haunch dinone"><img src="/images/haunch.png"></div>
                    <div class="wombeh dinone"><img src="/images/wombeh.png"></div>
                    <span class="thread"></span>
                </div>


            </div>
            <?php
            $n=0;
            foreach($part_disease as $sexKey=>$sexVal){
                foreach($sexVal as $frondBackKey=>$frondBackVal){
                    echo "<!--{$sexKey}{$frondBackKey} begin-->\n";
                    if($sexKey == '男性'){
                        $cls = $frondBackKey == '正面' ? 'mabod' : 'mabeh disn';
                    }else if($sexKey == '女性'){
                        $cls = $frondBackKey == '正面' ? 'wobod disn' : 'wobeh disn';
                    }
            ?>
            <div class="<?=$cls?>">
                <?php
                $i = 0;
                foreach($frondBackVal as $partKey=>$partVal){
                    $cls2 = $i==0 ?  'hurt' : 'hurt disn';
                ?>
                <!--<?=$partKey?> begin-->
                    <div class="<?=$cls2?>"><!--121212-->
                        <div class="headi fl">
                            <dl>
                                <dt><span><?=$partKey?></span>疾病</dt>
                                <?php
                                foreach($partVal['disease'] as $k=>$v){
                                    $name = $v['name'];
                                    $url = Url::to("@jb_domain/{$v['pinyin_initial']}/");
                                ?>
                                <dd><a href="<?=$url?>" title="<?=$name?>"><?=$name?></a></dd>
                                <?php
                                }
                                ?>
                            </dl>
                            <a href="<?=$partVal['diseaseUrl']?>" class="molin">更多>></a>
                        </div>
                        <div class="headi fl">
                            <dl>
                                <dt><span><?=$partKey?></span>症状</dt>
                                <?php
                                foreach($partVal['symptom'] as $k=>$v){
                                    $name = $v['name'];
                                    $url = Url::to("@jb_domain/zhengzhuang/{$v['pinyin_initial']}/");
                                ?>
                                <dd><a href="<?=$url?>" title="<?=$name?>"><?=$name?></a></dd>
                                <?php
                                }
                                ?>
                            </dl>
                            <a href="<?=$partVal['symptomUrl']?>" class="molin">更多>></a>

                        </div>
                    </div>
                <!--<?=$partKey?> end-->
                <?php
                    $i++;
                }
                ?>
            </div>
            <?php
                    echo "<!--{$sexKey}{$frondBackKey} end-->\n";
                }
                $n++;
            }
            ?>
            
            <div class="clear"></div>
        </div>
    </div>
    <div class="expres riclu fr" id="fsD1">
        <div class="drelat pTd20 nesty" style="margin:0;" id="D1pic1">
            <h4 class="lw5 dyh">专家在线</h4>
            <?php
            $worktime = [
                "每周一三五   9：00—18：00",
                "每周一二四  9：00—18：00",
                "每周六日 10：00—22：00"
            ];
            foreach($doctors_top as $k=>$v){
                $truename = $v['truename'] ? : $v['nickname'];
            ?>
            <div class="expert fcon" style="display: none;">
                <div class="lie mdT15">
                    <div class="clearfix">
                        <div class="doc_pic  doc_pom fl"><a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>"><img src="<?php echo Url::to('@community/upload/pic/' . $v['pic']); ?>"></a></div>
                        <div class="doc_writ doc_w166  fl">
                            <p class="pagename pagna14"><?php echo $truename; ?></p>
                            <p class="grat"><?php echo $v['doc_keshi']; ?></p>
                            <p class="ruser_ques89"><a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>">向TA提问</a></p>
                        </div>
                    </div>
                    <p class="clock"><?=$worktime[$k]?></p>
                </div>
            </div>
            <?php
            }
            ?>
            
            <div class="D1fBt" id="D1fBt">  
                <span class="prev"><</span>
                <a href="javascript:void(0)"></a>  
                <a href="javascript:void(0)"></a>  
                <a href="javascript:void(0)" class="current"></a> 
                <span class="next">></span>
            </div> 
            <div class="expert">
            <?php
            foreach($doctors_bottom as $k=>$v){
                $truename = $v['truename'] ? : $v['nickname'];
            ?>
                <div class="lie mdT20 clearfix">
                    <div class="doc_pic doc_pom fl"><a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>"><img src="<?php echo Url::to('@community/upload/pic/' . $v['pic']); ?>"></a></div>
                    <div class="doc_writ doc_w166  fl">
                        <p class="pagename pagna14"><?=$truename?></p>
                        <p class="grat"><?=$v['doc_keshi']?></p>
                        <p class="ruser_ques89"><a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>">向TA提问</a></p>
                    </div>
                </div>
            <?php
            }
            ?>    
            </div> 
        </div>
    </div>
    <!--专家滚动-->
    <script type="text/javascript">
        Qfast.add('widgets', { path: "<?php echo Url::to("@jb_domain");?>/js/terminator2.2.min.js", type: "js", requires: ['fx'] });  
        Qfast(false, 'widgets', function () {
            K.tabs({
                id: 'fsD1',   
                conId: "D1pic1",  
                tabId:"D1fBt",  
                tabTn:"a",
                conCn: '.fcon',   
                auto: 1,  
                effect: 'fade',   
                eType: 'click',
                pageBt:true,
                bns: ['.prev', '.next'],                      
                interval: 3000  
            }) 
        })  
    </script>
    <div class="clear"></div>
</div>
<!--第四屏 按部位查疾病 结束-->