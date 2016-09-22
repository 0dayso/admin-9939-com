<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$leftAsk = $data['leftAsk'];
$leftAskNoAnswer = $data['leftAskNoAnswer'];

$hospital = $data['rightHospital'];
$medicine = $data['rightMedicine'];
$doctors = $data['rightDoctors'];
?>
<!--第五屏 疾病问答 开始-->
<div class="content-one">
    <div class="peopl fl">
        <h2 class="dians"><a href="<?=Url::to("@ask")?>" class="morl">更多>></a><span></span><a href="" style="text-decoration:none; color:#333;">疾病问答</a></h2>
        <div class="docan">
            <div class="dotou fl">
                <div class="uldiv">
                    <div class="btndiv">
                        <a class="abtn aleft" href="#left"></a>
                        <a class="abtn aright" href="#right"></a>
                    </div>

                    <div class="scrollcontainer">
                        <ul class="person">
                            <?php
                            foreach($leftAsk as $k=>$v){
                                $qa = $v['qa'];
                                $doctor = $v['doctor'];
                                if(!empty($qa)){
                                    $askid = $qa['id'];
                                    $askTitle = $qa['ask'];
                                    
                                    $askUrl = Url::to('@ask/id/'.$qa['id']);
                                    $answerTime = date("Y-m-d H:i:s",$qa['addtime']);
                                    $answerContent = String::cutString($qa['answer'], 32, '...');
                                }
//                                print_r($doctor);
                                if(!empty($doctor)){
                                    $doctorName = isset($doctor['truename']) ? $doctor['truename'] : '';
                                    $doctorUrl = Url::to('@ask/asking/index?uid='.$doctor['uid']);
                                    $doctorAvator = Url::to('@community/upload/pic/'.$doctor['pic']);
                                }else{
                                    $doctorName = ' ';
                                    $doctorUrl = Url::to('@ask/Asking/');
                                    $doctorAvator = Url::to('@ask/images/default.jpg');
                                }
                                if(!empty($qa) && !empty($doctor)){
                            ?>
                            <li>
                                <h3><a href="<?=$doctorUrl?>" title="<?=$doctorName?>"><?=$doctorName?></a><span>医生回答 <?=$answerTime?></span></h3>
                                <dl>
                                    <dt><a href="<?=$askUrl?>"><?=$askTitle?></a></dt>
                                    <dd><?=$answerContent?></dd>
                                </dl>
                                <div><img src="<?=$doctorAvator?>" width="70" height="70" alt="<?=$doctorName?>" title="<?=$doctorName?>"></div>
                            </li>
                            <?php
                                }
                            }
                            ?>
                            
                        </ul>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
//            $(function(){
                $(".uldiv").Xslider({
                    unitdisplayed:1,
                    numtoMove:1,
                    speed:800,
                    dir:"V",
                    loop:"cycle",
                    autoscroll:4000,
                    scrollobjSize:Math.ceil($(".uldiv").find("li").length/1)*136/*横向滚动就是LI的宽度，竖向滚动就写LI的高度！（690是LI的宽度,滚动的是LI）*/
                })
//            })
            </script>           


            <div class="spnam fr">
                <ul class="akna">
                <?php
                $n=0;
//                print_r($leftAskNoAnswer);exit;
                foreach($leftAskNoAnswer as $k=>$v){
                    $keshiName = $v['keshiName'];
                    $keshiUrl = $v['keshiUrl'];
                    $askTitle = $v['askTitle'];
                    $askUrl = $v['askUrl'];
                    $askTime = $v['askTime'];
                ?>
                        <li>
                            <span class="dat"><?=$askTime?></span>
                            <div>
                                <span class="circ">[<a href="<?=$keshiUrl?>" title="<?=$keshiName?>"><?=$keshiName?></a>]</span>
                                <a href="<?=$askUrl?>" title="<?=$askTitle?>"><?=$askTitle?></a>
                            </div>
                        </li>
                <?php
                    if($n>0 && ($n+1) % 7 == 0){ echo '</ul><ul class="akna tiove">';}
                    $n++;
                }
                ?>
                </ul>
                
                <dl class="onla onadk">
                    <dt>在线提问<span>(百万医生免费为您做疾病解答)</span></dt>
                    <dd>
                        <form id="quick" name="quiz" method="post" action="http://ask.9939.com/Asking/index/" target="_blank" class="quiz" autocomplete="off">
                            <textarea id="quick_content" name="content" onfocus="javascript:if($('#quick_content').html()=='请输入您的问题标题(5/30)') $('#quick_content').html('');" placeholder="请输入您的问题标题(5/30)" rows="2"></textarea>
                            <a title="立即提问" onclick="return quick_ask()" target="_self"><img src="/images/frsu.png"></a>
                        </form>
                    </dd>
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
                </dl>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="expres fr" style="margin-top:0;">
        <div class="inqui">
            <div class="fasf">
                <a class="indexahover">医院速查</a>
                <a>医生速查</a>
                <a style="border-right:none;">药品速查</a>
            </div>
            <div class="hosfa">
                <ul class="hoin">
                    <?php
                    $hospitalImg = array_slice($hospital, 0, 4);
                    $hospitalNoImg = array_slice($hospital, 4, 12);
                    foreach($hospitalImg as $k=>$v){
                        $title = $v['title'];
                        $img = Url::to($v['img']);
                        $url = $v['url'];
                        $address = $v['address'];
                        $shortAddress = String::cutString($address, 12, '...');
                        $level = $v['level'];
                    ?>
                    <li>
                        <a href="<?=$url?>" title="<?=$title?>"><img src="<?=$img?>" alt="" title=""></a>
                        <h3><a href="<?=$url?>" title="<?=$title?>"><?=$title?></a></h3>
                        <p><?=$level?></p>
                        <p class="plas" title="<?=$address?>"><?=$shortAddress?></p>
                    </li>
                    <?php
                    }
                    ?>
                    
                </ul>
                <ul class="fafin">
                    <?php
                    foreach($hospitalNoImg as $k=>$v){
                        $title = $v['title'];
                        $shortTitle = String::cutString($title, 6, '...');
                        $url = $v['url'];
                        $level = $v['level'];
                        if(strpos($level, '/')){
                            $tmp = explode('/', $level);
                            $level = $tmp[0];
                        }else{
                            $level = $v['level'];
                        }
                    ?>
                    <li><a href="<?=$url?>" title="<?=$title?>"><?=$title?></a>|<span><?=$level?></span></li>
                    <?php
                    }
                    ?>
                </ul>
                <?php echo $this->render("inc_mid_ask_search");?>
            </div>
            <div class="hosfa disn">
                <ul class="confir">
            <?php
            foreach($doctors as $k=>$v){
                $truename = $v['truename'] ? : $v['nickname'];
            ?>
                    <li>
                        <a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>"><img src="<?php echo Url::to('@community/upload/pic/' . $v['pic']); ?>"></a>
                        <h3><a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>"><?php echo $truename; ?></a><span><?php echo $v['doc_keshi']; ?></span></h3>
                        <a href="<?php echo Url::to('@ask/asking/index?uid=' . $v['uid']); ?>" class="qusu">向TA提问</a>
                    </li>
            <?php
            }
            ?>
                </ul>
                <ul class="physi">
                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/32" title="内科">内科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/33" title="心血管内科">心血管内科</a></dd> 
                                <dd><a href="http://ask.9939.com/classid/69" title="神经内科">神经内科</a></dd> 
                                <dd><a href="http://ask.9939.com/classid/77" title="呼吸内科">呼吸内科</a></dd>
                        </dl></li>

                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/102" title="外科">外科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/103" title="骨科">骨科</a></dd> 
                                <dd><a href="http://ask.9939.com/classid/118" title="泌尿外科">泌尿外科</a></dd>  
                                <dd><a href="http://ask.9939.com/classid/149" title="肛肠科">肛肠科</a></dd>
                        </dl></li>

                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/220" title="男科">男科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/221" title="性功能科">性功能科</a></dd> 
                                <dd><a href="http://ask.9939.com/classid/232" title="前列腺科">前列腺科</a></dd>
                        </dl></li>

                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/193" title="妇产科">妇产科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/194" title="妇科">妇科</a></dd> 
                                <dd><a href="http://ask.9939.com/classid/208" title="产科">产科</a></dd> 
                                <dd><a href="http://ask.9939.com/classid/219" title="避孕流产">避孕流产</a></dd>
                        </dl></li>

                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/523" title="皮肤性病科">皮肤性病科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/339" title="皮肤科">皮肤科</a></dd>  
                                <dd><a href="http://ask.9939.com/classid/331" title="性病科">性病科</a></dd>
                        </dl></li>

                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/236" title="儿科">儿科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/237" title="小儿内科">小儿内科</a></dd>
                                <dd><a href="http://ask.9939.com/classid/256" title="小儿外科">小儿外科</a></dd>  
                                <dd><a href="http://ask.9939.com/classid/264" title="新生儿科">新生儿科</a></dd>
                        </dl></li>

                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/276" title="五官科">五官科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/277" title="眼科">眼科</a></dd>  
                                <dd><a href="http://ask.9939.com/classid/284" title="耳鼻喉科">耳鼻喉科</a></dd>
                                <dd><a href="http://ask.9939.com/classid/291" title="口腔科">口腔科</a></dd>
                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/428" title="中医科">中医科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/429" title="中医内科">中医内科</a></dd>
                                <dd><a href="http://ask.9939.com/classid/430" title="中医外科">中医外科</a></dd>
                                <dd><a href="http://ask.9939.com/classid/431" title="中医妇科">中医妇科</a></dd>
                        </dl></li>

                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/324" title="传染病科">传染病科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/325" title="肝病科">肝病科</a></dd>
                                <dd><a href="http://ask.9939.com/classid/364" title="寄生虫">寄生虫</a></dd>  
                                <dd><a href="http://ask.9939.com/classid/350" title="结核病">结核病</a></dd>
                        </dl></li>

                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/371" title="肿瘤科">肿瘤科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/375" title="肿瘤化疗">肿瘤化疗</a></dd>  
                                <dd><a href="http://ask.9939.com/classid/374" title="肿瘤放疗">肿瘤放疗</a></dd>
                                <dd><a href="http://ask.9939.com/classid/372" title="肿瘤介入">肿瘤介入</a></dd>
                        </dl></li>

                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/299" title="整形美容科">整形美容科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/315" title="全身">全身</a></dd>
                                <dd><a href="http://ask.9939.com/classid/307" title="头部">头部</a></dd>
                                <dd><a href="http://ask.9939.com/classid/302" title="皮肤">皮肤</a></dd>  
                        </dl></li>

                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/525" title="心理科">心理科</a></dt>
                                <dd><a href="http://ask.9939.com/classid/525" title="心理咨询">心理咨询</a></dd>
                                <dd><a href="http://ask.9939.com/classid/248" title="小儿心理">小儿心理</a></dd>
                                <dd><a href="http://ask.9939.com/classid/9" title="职业病">职业病</a></dd>
                        </dl></li>

                        <li><dl>
                                <dt><a href="http://ask.9939.com/classid/3" title="健康专区">健康专区</a></dt>
                                <dd><a href="http://ask.9939.com/classid/22" title="亚健康">亚健康</a></dd>  
                                <dd><a href="http://ask.9939.com/classid/11" title="母婴">母婴</a></dd> 
                                <dd><a href="http://ask.9939.com/classid/8" title="饮食营养">饮食营养</a></dd> 
                        </dl></li>
                </ul>
                <?php echo $this->render("inc_mid_ask_search");?>
            </div>
            <div class="hosfa disn">
                <ul class="donam">
                    <?php
                    foreach($medicine as $k=>$v){
                        $title = $v['title'];
                        $img = Url::to($v['img']);
                        $url = $v['url'];
                        $useful = $v['useful'];
                        $shortUseful = String::cutString($useful, 12, '...');
                        $address = $v['address'];
                    ?>
                    <li>
                        <a href="<?=$url?>" title="<?=$title?>"><img src="<?=$img?>" alt="<?=$title?>" title="<?=$title?>"></a>
                        <h3><a href="<?=$url?>" title="<?=$title?>"><?=$title?></a></h3><p><span>[功能主治]</span><?=$shortUseful?><a href="<?=$url?>">详情</a></p></li>
                    <?php
                    }
                    ?>
                </ul>
                <ul class="physi pains">
                    <li><dl>
                            <dt><a>男性常用药：</a></dt>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/3311.shtml" title="男宝胶囊">男宝胶囊</a></dd>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/6689.shtml" title="黄体酮胶丸">黄体酮胶丸</a></dd>
                            <dd><a href="http://yiyao.9939.com/bjp/200812/12765.shtml" title="东元牌维生素片">东元牌维生素片</a></dd>
                        </dl></li>
                    <li><dl>
                            <dt><a>女性常用药：</a></dt>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/8993.shtml" title="女金丸">女金丸</a></dd>
                            <dd><a href="http://yiyao.9939.com/zzy/200812/20211.shtml" title="女儿红叶">女儿红叶</a></dd>
                            <dd><a href="http://yiyao.9939.com/zzy/200812/2282.shtml" title="女宝胶囊">女宝胶囊</a></dd>
                        </dl></li>
                    <li><dl>
                            <dt><a>儿童常用药：</a></dt>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/3359.shtml" title="儿感清口服液">儿感清口服液</a></dd>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/9287.shtml" title="儿宝膏">儿宝膏</a></dd>
                            <dd><a href="http://yiyao.9939.com/zhfl/201009/20624.shtml" title="儿童回春颗粒">儿童回春颗粒</a></dd>
                        </dl></li>
                    <li><dl>
                            <dt><a>老人常用药：</a></dt>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/797.shtml" title="乳酸钙片">乳酸钙片</a></dd>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/1289.shtml" title="十三味红花丸">十三味红花丸</a></dd>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/2292.shtml" title="抗衰老片">抗衰老片</a></dd>
                        </dl></li>
                    <li><dl>
                            <dt><a>运动族常用药：</a></dt>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/4722.shtml" title="氯唑沙宗胶囊">氯唑沙宗胶囊</a></dd>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/7986.shtml" title="氯唑沙宗片">氯唑沙宗片</a></dd>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/8258.shtml" title="萘普生钠注射液">萘普生钠注射液</a></dd>
                        </dl></li>
                    <li><dl>
                            <dt><a>Office族常用药：</a></dt>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/3169.shtml" title="抗骨增生片">抗骨增生片</a></dd>
                            <dd><a href="http://yiyao.9939.com/zhfl/200812/3172.shtml" title="骨筋丸胶囊">骨筋丸胶囊</a></dd>
<!--                            <dd><a href="http://yiyao.9939.com/zhfl/200812/3800.shtml" title="正天丸">正天丸</a></dd>-->
                        </dl></li>
                </ul>
                <?php echo $this->render("inc_mid_ask_search");?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!--第五屏 疾病问答 结束-->