<!--文章页 右侧部分-->

<div class="art_r">
    <a href=""><img src="/images/cloc.jpg" alt=""></a>
    <div class="build third nwid">
        <h4 class="gre-arrow intho expask">专家咨询</h4>
        <div class="third-block two-block third-doc mT18">
            
            <div class="lie clearfix">
                <div class="doc_pic  fl"><a href=""><img src="http://www.9939.com/9939/res/disease/v1/images/yisheng1.jpg"></a></div>
                <div class="doc_writ fl">
                    <p class="pagename">王强</p>
                    <p class="grat pagna12">主任医师 副教授</p>
                    <p class="pagna12">擅长:胸外科 <a href="http://ask.9939.com/Ask/">[详情]</a></p>
                    <p class="ruser_ques89"><a href="http://ask.9939.com/Ask/">向TA提问</a></p>
                </div>
            </div>
            
            <div class="lie clearfix">
                <div class="doc_pic  fl"><a href=""><img src="http://www.9939.com/9939/res/disease/v1/images/yisheng2.jpg"></a></div>
                <div class="doc_writ fl">
                    <p class="pagename">倪幼方</p>
                    <p class="grat pagna12">主任医师 副教授</p>
                    <p class="pagna12">擅长:各种心血管 <a href="http://ask.9939.com/Ask/">[详情]</a></p>
                    <p class="ruser_ques89"><a href="http://ask.9939.com/Ask/">向TA提问</a></p>
                </div>
            </div>
            
            <div class="lie clearfix nelid">
                <div class="doc_pic  fl"><a href=""><img src="http://www.9939.com/9939/res/disease/v1/images/yisheng3.jpg"></a></div>
                <div class="doc_writ fl">
                    <p class="pagename">程云阁</p>
                    <p class="grat pagna12">主任医师 副教授</p>
                    <p class="pagna12">擅长:胸腔镜 <a href="http://ask.9939.com/Ask/">[详情]</a></p>
                    <p class="ruser_ques89"><a href="http://ask.9939.com/Ask/">向TA提问</a></p>
                </div>
            </div>
            
        </div>
    </div>
    <div class="Rcolumn">
        <div class="tode Rank">
            <div class="tabqh">
                <a class="omline">最新文章</a>
                <a style="border-left:1px solid #e9e9e9">相关文章</a>
            </div>
            
            <div class="tabbox lodrea" style="display:block">
                <ul>
                    <?php
                    if (isset($lastestArticles) && !empty($lastestArticles)) {
                        foreach ($lastestArticles as $lkey => $lastestArticle){
                            if ($lkey > 9){
                                break;
                            }
                            $url = '/article/'.date("Y/md", $lastestArticle["inputtime"]).'/'.$lastestArticle['id'].'.shtml';
                            $style = '';
                            if ($lkey > 4){
                                $style = 'style = "color: black;"';
                            }
                    ?>
                            <li>
                                <span class="kmo5" <?php echo $style; ?>><?php echo $lkey + 1; ?></span>
                                <span>
                                    <a href="<?php echo $url; ?>">
                                        <?php echo \librarys\helpers\utils\String::cutString($lastestArticle['title'], 16); ?>
                                    </a>
                                </span>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="tabbox">
                <dl>
                <?php
                //如果是文章列表页：
                if (isset($isartlist)){
                    if (isset($lastestArticles) && !empty($lastestArticles)) {
                        $relArticles['list'] = array_splice($lastestArticles, 0, 10);
                    }
                }

                if (isset($relArticles['list']) && !empty($relArticles['list'])) {
                    if (!isset($isartlist)){
                        $tmp = array_splice($relArticles['list'], 0, 12);
                    }
                    $i=1;
                    foreach ($relArticles['list'] as $relArticle){
                        
                ?>
                    <li>
                        <?php if($i<=5){?>
                            <span class="kmo"><?=$i?></span>
                        <?php
                            }else{
                        ?>
                            <span class="kmo1"><?=$i?></span>
                        <?php }?>
                        <span><a href="<?php echo '/article/'.date("Y/md", $relArticle["inputtime"]).'/'.$relArticle['id'].'.shtml' ; ?>" title="<?php echo $relArticle['title']; ?>"><?php echo $relArticle['title']; ?></a></span>
                    </li>
                <?php
                    $i++;
                    }
                }
                ?>
                </dl>
            </div>
            
        </div>
        <div class="tode a_intr">
            <div class="lent a_topi">
                <a href="javascript:" class="a_curr" data-id="tab_like" style="border-left:none;">精彩图片</a><a href="javascript:" data-id="tab_like">热点聚焦</a><a href="javascript:" data-id="tab_like" style="border-right:none; width:99px;">趣闻推荐</a>
            </div>
            <div class="Bpic" id="div_tab_like">
                <div class="bpics" style="display:block">
                    <div style="overflow:hidden;">
                        <div class="l_ims">
                            <a href="http://qiqu.9939.com/a/20150728/2387.html?9939"><img src="http://www.9939.com/9939/res/disease/v1/images/jingcaitupian1.jpg" alt=""></a>
                            <div><a href="http://qiqu.9939.com/a/20150728/2387.html?9939">文艺兵的恶劣紧身裤</a></div>
                        </div>
                        <div class="l_ims">
                            <a href="http://qiqu.9939.com/a/20150728/2388.html?9939"><img src="http://www.9939.com/9939/res/disease/v1/images/jingcaitupian2.jpg" alt=""></a>
                            <div><a href="http://qiqu.9939.com/a/20150728/2388.html?9939">美丽少妇怕热 穿透视</a></div>
                        </div>
                    </div>
                    <div class="adpl">
                        <?php echo $this->render('detail_right_ad_02'); ?>
                    </div>

                </div>
                <div class="bpics">
                    <div style="overflow:hidden;">
                        <div class="l_ims">
                            <a href="http://qiqu.9939.com/a/20150729/weijiezhimi_199.html?9939"><img src="http://www.9939.com/9939/res/disease/v1/images/redianjujiao1.jpg" alt=""></a>
                            <div><a href="http://qiqu.9939.com/a/20150729/weijiezhimi_199.html?9939">解放军开山炸出百吨巨</a></div>
                        </div>
                        <div class="l_ims">
                            <a href="http://qiqu.9939.com/a/20150729/qiwenyishi_454.html?9939"><img src="http://www.9939.com/9939/res/disease/v1/images/redianjujiao2.jpg" alt=""></a>
                            <div><a href="http://qiqu.9939.com/a/20150729/qiwenyishi_454.html?9939">昆仑山脉古洞真龙现</a></div>
                        </div>
                    </div>
                    <div class="adpl">
                        <?php echo $this->render('detail_right_ad_02'); ?>
                    </div>

                </div>
                <div class="bpics">
                    <div style="overflow:hidden;">
                        <div class="l_ims">
                            <a href="http://qiqu.9939.com/a/20150729/2392.html?9939"><img src="http://www.9939.com/9939/res/disease/v1/images/quwentuijian1.jpg" alt=""></a>
                            <div><a href="http://qiqu.9939.com/a/20150729/2392.html?9939">如此美女竟然淹死了22</a></div>
                        </div>
                        <div class="l_ims">
                            <a href="http://qiqu.9939.com/a/20150729/weijiezhimi_200.html?9939"><img src="http://www.9939.com/9939/res/disease/v1/images/quwentuijian2.jpg" alt=""></a>
                            <div><a href="http://qiqu.9939.com/a/20150729/weijiezhimi_200.html?9939">千年古墓走出的活女尸</a></div>
                        </div>
                    </div>
                    <div class="adpl">
                        <?php echo $this->render('detail_right_ad_02'); ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="drelat pTd20 heain">
            <h4 class="lw5 dyh">常见用药</h4>
            <div class="drehos">
                
                <div class="more_hos mBto20">
                    <div class="drug_pic  mr10 cbord fl"><a href="http://yiyao.9939.com/zhfl/201009/20624.shtml">
                            <img src="http://www.9939.com/9939/res/disease/v1/images/yao1.jpg" alt="" title=""></a></div>
                    <div class="qrw159 fl"><h3><a href="http://yiyao.9939.com/zhfl/201009/20624.shtml">儿童回春颗粒</a></h3>
                        <p class="drug_pm0">[<b>功能主治</b>]清热解毒，透表豁痰。用于急性惊...<a
                                href="http://yiyao.9939.com/zhfl/201009/20624.shtml">详情</a></p></div>
                </div>
                <div class="more_hos mBto20">
                    <div class="drug_pic  mr10 cbord fl"><a href="http://yiyao.9939.com/zhfl/200812/10619.shtml">
                            <img src="http://www.9939.com/9939/res/disease/v1/images/yao2.jpg" alt="" title=""></a></div>
                    <div class="qrw159 fl"><h3><a href="http://yiyao.9939.com/zhfl/200812/10619.shtml">人参归脾丸</a></h3>
                        <p class="drug_pm0">[<b>功能主治</b>]用于气血不足。心悸。失眠。食少乏...<a
                                href="http://yiyao.9939.com/zhfl/200812/10619.shtml">详情</a></p></div>
                </div>
                <div class="more_hos mBto20">
                    <div class="drug_pic  mr10 cbord fl"><a href="http://yiyao.9939.com/zhfl/200812/10566.shtml">
                            <img src="http://www.9939.com/9939/res/disease/v1/images/yao3.jpg" alt="" title=""></a></div>
                    <div class="qrw159 fl"><h3><a href="http://yiyao.9939.com/zhfl/200812/10566.shtml">大败毒胶囊</a></h3>
                        <p class="drug_pm0">[<b>功能主治</b>]清血败毒。消肿止痛。用于脏腑毒热。...<a
                                href="http://yiyao.9939.com/zhfl/200812/10566.shtml">详情</a></p></div>
                </div>
                
            </div>
        </div>
        <div class="drelat pTd20 heain">
            <h4 class="lw5 dyh">推荐医院</h4>
            <div class="drehos">
                
                <div class="more_hos mBto20">
                    <div class="hos_rpic fl">
                        <a href="http://hospital.9939.com/hosp/272446/index.shtml"><img src="http://www.9939.com/9939/res/disease/v1/images/xiehe.jpg" alt="北京协和医院" title="北京协和医院"></a>
                    </div>
                    <div class="fl">
                        <h3><a href="http://hospital.9939.com/hosp/272446/index.shtml">北京协和医院</a></h3>
                        <p><span>三级甲等</span>/<span>综合医院</span>/<span>医保定点</span></p>
                        <p class="smap">北京市东城区帅府园1号</p>
                    </div>
                </div>
                
                <div class="more_hos mBto20">
                    <div class="hos_rpic fl">
                        <a href="http://hospital.9939.com/hosp/19867/index.shtml"><img src="http://www.9939.com/9939/res/disease/v1/images/junqu.jpg" alt="北京军区总医院" title="北京军区总医院"></a>
                    </div>
                    <div class="fl">
                        <h3><a href="http://hospital.9939.com/hosp/19867/index.shtml">北京军区总医院</a></h3>
                        <p><span>三级甲等</span>/<span>综合医院</span>/<span>医保定点</span></p>
                        <p class="smap">北京东城区东四十条南门仓5号</p>
                    </div>
                </div>
                
                <div class="more_hos mBto20">
                    <div class="hos_rpic fl">
                        <a href="http://hospital.9939.com/hosp/20251/index.shtml"><img src="http://www.9939.com/9939/res/disease/v1/images/jiefangjun.jpg" alt="北京解放军总医院" title="北京解放军总医院"></a>
                    </div>
                    <div class="fl">
                        <h3><a href="http://hospital.9939.com/hosp/20251/index.shtml">北京解放军总医院</a></h3>
                        <p><span>三级甲等</span>/<span>综合医院</span>/<span>医保定点</span></p>
                        <p class="smap">北京市海淀区西八里庄</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="drelat pTd20 heain">
            <h4 class="lw5 dyh intho"><a href="http://zt.9939.com/">更多>></a>精彩专题</h4>
            <div class="drehos">
                <div class="tabMop sty02">
                    <div class="ims2">
                        <a href="http://zt.9939.com/jsr/">
                            <img src="http://www.9939.com/9939/res/disease/v1/images/jingcaizhuanti.jpg" alt="">
                        </a>
                        <div class="intro"><a href="http://zt.9939.com/jsr/">“僵尸肉“你不知道的黑幕</a></div>
                    </div>
                    <ul class="spul spc a_artic a_nlis newa">
                        <li><a href="http://zt.9939.com/yyz/">关注抑郁症，你的情绪换了感冒吗</a></li>
                        <li><a href="http://zt.9939.com/kzfr/">如何健康坐飞机 空中飞人的保健之道</a></li>
                        <li><a href="http://zt.9939.com/xialongxia/">舌尖上的中国之美味小龙虾</a></li>
                        <li><a href="http://zt.9939.com/mxxd/">从明星涉毒 看毒品对身体的威海</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="drelat pTd20">
            <div class="build five">
                <h4 class="gre-arrow">猜你喜欢</h4>
                <div class="clumn mT18">
                    <script type="text/javascript">
                        var cpro_id="u2303421";
                        (window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",rsi0:"300",rsi1:"250",pat:"1",tn:"baiduCustNativeAD",rss1:"#FFFFFF",conBW:"0",adp:"1",ptt:"0",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",titSU:"0",tft:"0",tlt:"1",ptbg:"60",piw:"140",pih:"90",ptp:"1"}
                    </script>
                    <script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
                </div>
            </div>
        </div>
        <!--<div id="a_float"></div>-->

    </div>
    <div class="clear"></div>
</div>