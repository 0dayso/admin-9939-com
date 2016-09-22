<?php
use yii\helpers\Html;
use yii\helpers\Url;
use librarys\helpers\utils\String;

$focus = $data['focus'];
$focusDisease = $data['disease'];
$reportNews = $data['report'];
$zhuanti = $data['zhuanti'];
?>
<!--导航下 第一屏 开始-->
<div class="content-one nosla">
    <ul class="lefna fl">
        <li><span class="spi_01"></span>
            <dl>
                <dt><a href="/jbzz/toubu/" title="头部">头部</a></dt>
                <dd><a href="/jbzz/lunao/" title="颅脑">颅脑</a></dd>
                <dd><a href="/jbzz/yan/" title="眼">眼</a></dd>
                <dd><a href="/jbzz/bi/" title="鼻">鼻</a></dd>
            </dl></li>
        <li><span class="spi_02"></span>
            <dl>
                <dt><a href="/jbzz/jingbu/" title="颈部">颈部</a></dt>
                <dd><a href="/jbzz/qiguan/" title="气管">气管</a></dd>
                <dd><a href="/jbzz/jiazhuangxian/" title="甲状腺">甲状腺</a></dd>
            </dl>
        </li>
        <li><span class="spi_03"></span>
            <dl>
                <dt><a href="/jbzz/xiongbu/" title="胸部">胸部</a></dt>
                <dd><a href="/jbzz/rufang/" title="乳房">乳房</a></dd>
                <dd><a href="/jbzz/fei/" title="肺">肺</a></dd>
            </dl>
        </li>
        <li><span class="spi_04"></span>
            <dl>
                <dt><a href="/jbzz/fubu/" title="腹部">腹部</a></dt>
                <dd><a href="/jbzz/wei/" title="胃">胃</a></dd>
                <dd><a href="/jbzz/chang/" title="肠">肠</a></dd>
                <dd><a href="/jbzz/gan/" title="肝">肝</a></dd>
            </dl>
        </li>
        <li><span class="spi_05"></span>
            <dl>
                <dt><a href="/jbzz/yaobu/" title="腰部">腰部</a></dt>
                <dd><a href="/jbzz/shen/" title="肾">肾</a></dd>
                <dd><a href="/jbzz/shenshangxian/" title="肾上腺">肾上腺</a></dd>
            </dl>
        </li>
        <li><span class="spi_06"></span>
            <dl>
                <dt><a href="/jbzz/nanxingshengzhi/" title="男性生殖">男性生殖</a></dt>
                <dd><a href="/jbzz/yinjing/" title="阴茎">阴茎</a></dd>
                <dd><a href="/jbzz/gaowan/" title="睾丸">睾丸</a></dd>
            </dl>
        </li>
        <li><span class="spi_07"></span>
            <dl>
                <dt><a href="/jbzz/nvxingshengzhi/" title="女性生殖">女性生殖</a></dt>
                <dd><a href="/jbzz/luanchao/" title="卵巢">卵巢</a></dd>
                <dd><a href="/jbzz/zigong/" title="子宫">子宫</a></dd>
            </dl>
        </li>
        <li><span class="spi_08"></span>
            <dl>
                <dt><a href="/jbzz/quanshen/" title="全身">全身</a></dt>
                <dd><a href="/jbzz/pifu/" title="皮肤">皮肤</a></dd>
                <dd><a href="/jbzz/linba/" title="淋巴">淋巴</a></dd>
            </dl>
        </li>
        <li><span class="spi_09"></span>
            <dl>
                <dt><a href="/jbzz/shangzhi/" title="上肢">上肢</a></dt>
                <dd><a href="/jbzz/jianbu/" title="肩部">肩部</a></dd>
                <dd><a href="/jbzz/zhoubu/" title="肘部">肘部</a></dd>
            </dl>
        </li>
        <li><span class="spi_10"></span>
            <dl>
                <dt><a href="/jbzz/xiazhi/" title="下肢">下肢</a></dt>
                <dd><a href="/jbzz/xibu/" title="膝部">膝部</a></dd>
                <dd><a href="/jbzz/zubu/" title="足部">足部</a></dd>
            </dl>
        </li>
        <li><span class="spi_11"></span>
            <dl>
                <dt><a href="/jbzz/xinli/" title="心理">心理</a></dt>
            </dl>
        </li>
    </ul>
    <!--展示层-->
    <div class="slaye">
        <div class="sholay">
            <div class="brain fl">
                <h3><a href="/jbzz/toubu_t1/" title="头部疾病">更多</a>疾病</h3>
                <ul class="brainf">
                    <li>
                        <dl>
                            <dt><a href="/jbzz/lunao/" title="颅脑">颅脑</a></dt>
                            <dd><a href="/dx/" title="癫痫">癫痫</a>|</dd>
                            <dd><a href="/zf/" title="中风">中风</a>|</dd>
                            <dd><a href="/ptt/" title="偏头痛">偏头痛</a>|</dd>
                            <dd><a href="/nmy/" title="脑膜炎">脑膜炎</a>|</dd>
                            <dd><a href="/ngs/" title="脑梗塞">脑梗塞</a></dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><a href="/jbzz/yan/" title="眼">眼</a></dt>
                            <dd><a href="/sy/" title="沙眼">沙眼</a>|</dd>
                            <dd><a href="/bnz/" title="白内障">白内障</a>|</dd>
                            <dd><a href="/hyb/" title="红眼病">红眼病</a>|</dd>
                            <dd><a href="/jmy_9028/" title="结膜炎">结膜炎</a>|</dd>
                            <dd><a href="/jsy/" title="近视眼">近视眼</a></dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><a href="/jbzz/bi/" title="鼻">鼻</a></dt>
                            <dd><a href="/bdy/" title="鼻窦炎">鼻窦炎</a>|</dd>
                            <dd><a href="/jzb_2846/" title="酒渣鼻">酒渣鼻</a>|</dd>
                            <dd><a href="/gmxby/" title="过敏性鼻炎">过敏性鼻炎</a>|</dd>
                            <dd><a href="/bya/" title="鼻咽癌">鼻咽癌</a>|</dd>
                            <dd><a href="/bxr/" title="鼻息肉">鼻息肉</a></dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><a href="/jbzz/er/" title="耳">耳</a></dt>
                            <dd><a href="/el_3755/" title="耳聋">耳聋</a>|</dd>
                            <dd><a href="/em/" title="耳鸣">耳鸣</a>|</dd>
                            <dd><a href="/zey/" title="中耳炎">中耳炎</a>|</dd>
                            <dd><a href="/wedy/" title="外耳道炎">外耳道炎</a>|</dd>
                            <dd><a href="/wedyw/" title="外耳道异物">外耳道异物</a></dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><a href="/jbzz/mianbu/" title="面部">面部</a></dt>
                            <dd><a href="/mt/" title="面瘫">面瘫</a>|</dd>
                            <dd><a href="/pzxnz/" title="皮脂腺囊肿">皮脂腺囊肿</a>|</dd>
                            <dd><a href="/mjjl/" title="面肌痉挛">面肌痉挛</a>|</dd>
                            <dd><a href="/qb/" title="雀斑">雀斑</a>|</dd>
                            <dd><a href="/mjcc/" title="面肌抽搐">面肌抽搐</a></dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><a href="/jbzz/kou/" title="口">口</a></dt>
                            <dd><a href="/kqky/" title="口腔溃疡">口腔溃疡</a>|</dd>
                            <dd><a href="/yzb/" title="牙周病">牙周病</a>|</dd>
                            <dd><a href="/kqzmb/" title="口腔粘膜病">口腔粘膜病</a>|</dd>
                            <dd><a href="/kc/" title="口臭">口臭</a>|</dd>
                            <dd><a href="/ekc/" title="鹅口疮">鹅口疮</a></dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><a href="/jbzz/houlong/" title="咽喉">咽喉</a></dt>
                            <dd><a href="/btty/" title="扁桃体炎">扁桃体炎</a>|</dd>
                            <dd><a href="/ha/" title="喉癌">喉癌</a>|</dd>
                            <dd><a href="/xhr/" title="猩红热">猩红热</a>|</dd>
                            <dd><a href="/bttzwnz/" title="扁桃体周围脓肿">扁桃体周围脓肿</a>|</dd>
                            <dd><a href="/yy_9026/" title="咽炎">咽炎</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="brain fl">
                <h3><a href="/jbzz/toubu_t2/" title="头部症状">更多</a>症状</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/lunao/" title="颅脑">颅脑</a></dt>
                            <dd><a href="sjxtt" title="神经性头痛">神经性头痛</a>|</dd>
                            <dd><a href="/zhengzhuang/nqy/" title="脑缺氧">脑缺氧</a>|</dd>
                            <dd><a href="/zhengzhuang/sm_3980/" title="失眠">失眠</a>|</dd>
                            <dd><a href="/zhengzhuang/nxgjl/" title="脑血管痉挛">脑血管痉挛</a>|</dd>
                            <dd><a href="/zhengzhuang/lncx/" title="颅内出血">颅内出血</a></dd>
                        </dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/yan/" title="眼">眼</a></dt>
                            <dd><a href="/zhengzhuang/ypt/" title="眼皮跳">眼皮跳</a>|</dd>
                            <dd><a href="/zhengzhuang/yjfh_5583/" title="眼睛发红">眼睛发红</a>|</dd>
                            <dd><a href="/zhengzhuang/yh/" title="眼花">眼花</a>|</dd>
                            <dd><a href="yjfz" title="眼睑浮肿">眼睑浮肿</a>|</dd>
                            <dd><a href="/zhengzhuang/yktt/" title="眼眶疼痛">眼眶疼痛</a></dd>
                        </dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/bi/" title="鼻">鼻</a></dt>
                            <dd><a href="/zhengzhuang/bs/" title="鼻塞">鼻塞</a>|</dd>
                            <dd><a href="/zhengzhuang/lbt/" title="流鼻涕">流鼻涕</a>|</dd>
                            <dd><a href="/zhengzhuang/lbx/" title="流鼻血">流鼻血</a>|</dd>
                            <dd><a href="/zhengzhuang/bsd/" title="鼻屎多">鼻屎多</a>|</dd>
                            <dd><a href="/zhengzhuang/bqgzjjj/" title="鼻腔干燥及结痂">鼻腔干燥及结痂</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/er/" title="耳">耳</a></dt>
                            <dd><a href="/zhengzhuang/ehlbjzd/" title="耳后淋巴结肿大">耳后淋巴结肿大</a>|</dd>
                            <dd><a href="/zhengzhuang/sjxel/" title="神经性耳聋">神经性耳聋</a>|</dd>
                            <dd><a href="/zhengzhuang/et/" title="耳痛">耳痛</a>|</dd>
                            <dd><a href="/zhengzhuang/ey/" title="耳痒">耳痒</a>|</dd>
                            <dd><a href="/zhengzhuang/ehtt/" title="耳后疼痛">耳后疼痛</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/mianbu/" title="面部">面部</a></dt>
                            <dd><a href="/zhengzhuang/lscb/" title="脸上长斑">脸上长斑</a>|</dd>
                            <dd><a href="/zhengzhuang/xbcd/" title="下巴长痘">下巴长痘</a>|</dd>
                            <dd><a href="/zhengzhuang/mbfz/" title="面部浮肿">面部浮肿</a>|</dd>
                            <dd><a href="/zhengzhuang/lsfh_2523/" title="脸色发黄">脸色发黄</a>|</dd>
                            <dd><a href="/zhengzhuang/pxjj/" title="皮下结节">皮下结节</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/kou/" title="口">口</a></dt>
                            <dd><a href="/zhengzhuang/yycx/" title="牙龈出血">牙龈出血</a>|</dd>
                            <dd><a href="/zhengzhuang/yt/" title="牙疼">牙疼</a>|</dd>
                            <dd><a href="/zhengzhuang/kk/" title="口苦">口苦</a>|</dd>
                            <dd><a href="/zhengzhuang/stfh/" title="舌苔发黑">舌苔发黑</a>|</dd>
                            <dd><a href="/zhengzhuang/yyzz/" title="牙龈肿胀">牙龈肿胀</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/houlong/" title="咽喉">咽喉</a></dt>
                            <dd><a href="/zhengzhuang/gk/" title="干咳">干咳</a>|</dd>
                            <dd><a href="/zhengzhuang/kt/" title="咳痰">咳痰</a>|</dd>
                            <dd><a href="/zhengzhuang/kx/" title="咳血">咳血</a>|</dd>
                            <dd><a href="/zhengzhuang/hlt/" title="喉咙痛">喉咙痛</a>|</dd>
                            <dd><a href="/zhengzhuang/ybywg/" title="咽部异物感">咽部异物感</a></dd></dl></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="sholay" style="height:130px;">
            <div class="brain fl">
                <h3><a href="/jbzz/jingbu_t1/" title="颈部疾病">更多</a>疾病</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/qiguan/" title="气管">气管</a></dt>
                            <dd><a href="/zqgy/" title="支气管炎">支气管炎</a>|</dd>
                            <dd><a href="/zqgxc/" title="支气管哮喘">支气管哮喘</a>|</dd>
                            <dd><a href="/qgzl/" title="气管肿瘤">气管肿瘤</a>|</dd>
                            <dd><a href="/qggz_6662/" title="气管梗阻">气管梗阻</a>|</dd>
                            <dd><a href="/qgzqgyw/" title="气管支气管异物">气管支气管异物</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/jiazhuangxian/" title="甲状腺">甲状腺</a></dt>
                            <dd><a href="/jk/" title="甲亢">甲亢</a>|</dd>
                            <dd><a href="/jzxy/" title="甲状腺炎">甲状腺炎</a>|</dd>
                            <dd><a href="/jzxa/" title="甲状腺癌">甲状腺癌</a>|</dd>
                            <dd><a href="/jzxgnjt/" title="甲状腺功能减退">甲状腺功能减退</a>|</dd>
                            <dd><a href="/jjxjzxz/" title="结节性甲状腺肿">结节性甲状腺肿</a></dd></dl></li>
                </ul>
            </div>
            <div class="brain fl">
                <h3><a href="/jbzz/jingbu_t2/" title="颈部症状">更多</a>症状</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/qiguan/" title="气管">气管</a></dt>
                            <dd><a href="/zhengzhuang/cx_487/" title="喘息">喘息</a>|</dd>
                            <dd><a href="fg" title="发绀">发绀</a>|</dd>
                            <dd><a href="/zhengzhuang/ks/" title="咳嗽">咳嗽</a>|</dd>
                            <dd><a href="/zhengzhuang/hxjc/" title="呼吸急促">呼吸急促</a>|</dd>
                            <dd><a href="/zhengzhuang/xm_5277/" title="胸闷">胸闷</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/jiazhuangxian/" title="甲状腺">甲状腺</a></dt>
                            <dd><a href="/zhengzhuang/jzxjj/" title="甲状腺结节">甲状腺结节</a>|</dd>
                            <dd><a href="/zhengzhuang/xyjt/" title="性欲减退">性欲减退</a>|</dd>
                            <dd><a href="/zhengzhuang/tykn/" title="吞咽困难">吞咽困难</a>|</dd>
                            <dd><a href="/zhengzhuang/jxxjbzk/" title="进行性颈部肿块">进行性颈部肿块</a>|</dd>
                            <dd><a href="/zhengzhuang/jblbjzd/" title="颈部淋巴结肿大">颈部淋巴结肿大</a></dd></dl></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="sholay" style="height:370px;">
            <div class="brain fl">
                <h3><a href="/jbzz/xiongbu_t1/" title="胸部疾病">更多</a>疾病</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/rufang/" title="乳房">乳房</a></dt>
                            <dd><a href="/rxy/" title="乳腺炎">乳腺炎</a>|</dd>
                            <dd><a href="/rxzs/" title="乳腺增生">乳腺增生</a>|</dd>
                            <dd><a href="/rxa/" title="乳腺癌">乳腺癌</a>|</dd>
                            <dd><a href="/rfzk/" title="乳房肿块">乳房肿块</a>|</dd>
                            <dd><a href="/rfxwl/" title="乳房纤维瘤">乳房纤维瘤</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/fei/" title="肺">肺</a></dt>
                            <dd><a href="/xefy/" title="小儿肺炎">小儿肺炎</a>|</dd>
                            <dd><a href="/xc/" title="哮喘">哮喘</a>|</dd>
                            <dd><a href="/fa/" title="肺癌">肺癌</a>|</dd>
                            <dd><a href="/fjh/" title="肺结核">肺结核</a>|</dd>
                            <dd><a href="/brk/" title="百日咳">百日咳</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/xinzang/" title="心脏">心脏</a></dt>
                            <dd><a href="/fsxxzb/" title="风湿性心脏病">风湿性心脏病</a>|</dd>
                            <dd><a href="/xlsc/" title="心律失常">心律失常</a>|</dd>
                            <dd><a href="/xjy/" title="心肌炎">心肌炎</a>|</dd>
                            <dd><a href="/gxb/" title="冠心病">冠心病</a>|</dd>
                            <dd><a href="/xjt/" title="心绞痛">心绞痛</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/shiguan/" title="食管">食管</a></dt>
                            <dd><a href="/sgy/" title="食管炎">食管炎</a>|</dd>
                            <dd><a href="/sgxr/" title="食管息肉">食管息肉</a>|</dd>
                            <dd><a href="/sgnz/" title="食管囊肿">食管囊肿</a>|</dd>
                            <dd><a href="/wsgflb/" title="胃食管反流病">胃食管反流病</a>|</dd>
                            <dd><a href="/sgss/" title="食管损伤">食管损伤</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/geji/" title="膈肌">膈肌</a></dt>
                            <dd><a href="/gs/" title="膈疝">膈疝</a>|</dd>
                            <dd><a href="/gjmb/" title="膈肌麻痹">膈肌麻痹</a>|</dd>
                            <dd><a href="/enz/" title="呃逆症">呃逆症</a>|</dd>
                            <dd><a href="/gxtxqs/" title="膈先天性缺损">膈先天性缺损</a>|</dd>
                            <dd><a href="/gpd/" title="膈扑动">膈扑动</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/zongge/" title="纵膈">纵膈</a></dt>
                            <dd><a href="/zgzl/" title="纵隔肿瘤">纵隔肿瘤</a>|</dd>
                            <dd><a href="/zgs_8355/" title="纵隔疝">纵隔疝</a>|</dd>
                            <dd><a href="/xxnz_5149/" title="胸腺囊肿">胸腺囊肿</a>|</dd>
                            <dd><a href="/zgnz_8353/" title="纵隔囊肿">纵隔囊肿</a>|</dd>
                            <dd><a href="/jxzgy/" title="急性纵隔炎">急性纵隔炎</a></dd></dl></li>
                </ul>
            </div>
            <div class="brain fl">
                <h3><a href="/jbzz/xiongbu_t2/" title="胸部症状">更多</a>症状</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/rufang/" title="乳房">乳房</a></dt>
                            <dd><a href="/zhengzhuang/rfzk/" title="乳房肿块">乳房肿块</a>|</dd>
                            <dd><a href="/zhengzhuang/rzyj_3683/" title="乳汁郁结">乳汁郁结</a>|</dd>
                            <dd><a href="/zhengzhuang/rfyh/" title="乳房硬化">乳房硬化</a>|</dd>
                            <dd><a href="/zhengzhuang/jqqrft/" title="经期前乳房痛">经期前乳房痛</a>|</dd>
                            <dd><a href="/zhengzhuang/rfhzrt/" title="乳房红肿热痛">乳房红肿热痛</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/fei/" title="肺">肺</a></dt>
                            <dd><a href="/zhengzhuang/hxsj/" title="呼吸衰竭">呼吸衰竭</a>|</dd>
                            <dd><a href="/zhengzhuang/cx_487/" title="喘息">喘息</a>|</dd>
                            <dd><a href="/zhengzhuang/qd/" title="气短">气短</a>|</dd>
                            <dd><a href="/zhengzhuang/hxyc/" title="呼吸异常">呼吸异常</a>|</dd>
                            <dd><a href="/zhengzhuang/xmy/" title="哮鸣音">哮鸣音</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/xinzang/" title="心脏">心脏</a></dt>
                            <dd><a href="/zhengzhuang/ty_4520/" title="头晕">头晕</a>|</dd>
                            <dd><a href="/zhengzhuang/xm_5277/" title="胸闷">胸闷</a>|</dd>
                            <dd><a href="/zhengzhuang/xj/" title="心悸">心悸</a>|</dd>
                            <dd><a href="/zhengzhuang/xhqd/" title="心慌气短">心慌气短</a>|</dd>
                            <dd><a href="/zhengzhuang/jltt_2206/" title="剧烈头痛">剧烈头痛</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/shiguan/" title="食管">食管</a></dt>
                            <dd><a href="/zhengzhuang/ts_4540/" title="吐酸">吐酸</a>|</dd>
                            <dd><a href="/zhengzhuang/jskn/" title="进食困难">进食困难</a>|</dd>
                            <dd><a href="/zhengzhuang/gy/" title="梗噎">梗噎</a>|</dd>
                            <dd><a href="/zhengzhuang/ybyywg/" title="咽部有异物感">咽部有异物感</a>|</dd>
                            <dd><a href="/zhengzhuang/sx_3795/" title="烧心">烧心</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/geji/" title="膈肌">膈肌</a></dt>
                            <dd><a href="/zhengzhuang/dg/" title="打嗝">打嗝</a>|</dd>
                            <dd><a href="/zhengzhuang/gjqs/" title="膈肌缺损">膈肌缺损</a>|</dd>
                            <dd><a href="/zhengzhuang/xt_5294/" title="胸痛">胸痛</a>|</dd>
                            <dd><a href="/zhengzhuang/dyxz/" title="低氧血症">低氧血症</a>|</dd>
                            <dd><a href="/zhengzhuang/qj/" title="气急">气急</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/zongge/" title="纵膈">纵膈</a></dt>
                            <dd><a href="/zhengzhuang/xghtt/" title="胸骨后疼痛">胸骨后疼痛</a>|</dd>
                            <dd><a href="/zhengzhuang/pzczd/" title="皮质醇增多">皮质醇增多</a>|</dd>
                            <dd><a href="/zhengzhuang/tzx/" title="桶状胸">桶状胸</a>|</dd>
                            <dd><a href="/zhengzhuang/tykn/" title="吞咽困难">吞咽困难</a>|</dd>
                            <dd><a href="/zhengzhuang/xm_5277/" title="胸闷">胸闷</a></dd></dl></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="sholay">
            <div class="brain fl">
                <h3><a href="/jbzz/fubu_t1/" title="腹部疾病">更多</a>疾病</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/wei/" title="胃">胃</a></dt>
                            <dd><a href="/mxwy/" title="慢性胃炎">慢性胃炎</a>|</dd>
                            <dd><a href="/wky/" title="胃溃疡">胃溃疡</a>|</dd>
                            <dd><a href="/wa/" title="胃癌">胃癌</a>|</dd>
                            <dd><a href="/wsxwy/" title="萎缩性胃炎">萎缩性胃炎</a>|</dd>
                            <dd><a href="/wcdgnwl/" title="胃肠道功能紊乱">胃肠道功能紊乱</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/chang/" title="肠">肠</a></dt>
                            <dd><a href="/cgz/" title="肠梗阻">肠梗阻</a>|</dd>
                            <dd><a href="/cwy/" title="肠胃炎">肠胃炎</a>|</dd>
                            <dd><a href="/zca/" title="直肠癌">直肠癌</a>|</dd>
                            <dd><a href="/sezcky/" title="十二指肠溃疡">十二指肠溃疡</a>|</dd>
                            <dd><a href="/jca/" title="结肠癌">结肠癌</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/gan/" title="肝">肝</a></dt>
                            <dd><a href="/yg/" title="乙肝">乙肝</a>|</dd>
                            <dd><a href="/gyh/" title="肝硬化">肝硬化</a>|</dd>
                            <dd><a href="/zfg/" title="脂肪肝">脂肪肝</a>|</dd>
                            <dd><a href="/gy_8497/" title="肝炎">肝炎</a>|</dd>
                            <dd><a href="/ga/" title="肝癌">肝癌</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/dan/" title="胆">胆</a></dt>
                            <dd><a href="/dny/" title="胆囊炎">胆囊炎</a>|</dd>
                            <dd><a href="/djs/" title="胆结石">胆结石</a>|</dd>
                            <dd><a href="/dna/" title="胆囊癌">胆囊癌</a>|</dd>
                            <dd><a href="/dnxr/" title="胆囊息肉">胆囊息肉</a>|</dd>
                            <dd><a href="/gdsr/" title="肝胆湿热">肝胆湿热</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/pi/" title="脾">脾</a></dt>
                            <dd><a href="/pgnkj/" title="脾功能亢进">脾功能亢进</a>|</dd>
                            <dd><a href="/pnz/" title="脾囊肿">脾囊肿</a>|</dd>
                            <dd><a href="/ppl/" title="脾破裂">脾破裂</a>|</dd>
                            <dd><a href="/xepd/" title="小儿脾大">小儿脾大</a>|</dd>
                            <dd><a href="/pnz_6636/" title="脾脓肿">脾脓肿</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/lanwei/" title="阑尾">阑尾</a></dt>
                            <dd><a href="/lwy/" title="阑尾炎">阑尾炎</a>|</dd>
                            <dd><a href="/lwzl/" title="阑尾肿瘤">阑尾肿瘤</a>|</dd>
                            <dd><a href="/lwxa/" title="阑尾腺癌">阑尾腺癌</a>|</dd>
                            <dd><a href="/lwla/" title="阑尾类癌">阑尾类癌</a>|</dd>
                            <dd><a href="/jxlwy/" title="急性阑尾炎">急性阑尾炎</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/yixian/" title="胰腺">胰腺</a></dt>
                            <dd><a href="/yxy/" title="胰腺炎">胰腺炎</a>|</dd>
                            <dd><a href="/tnb/" title="糖尿病">糖尿病</a>|</dd>
                            <dd><a href="/yxa/" title="胰腺癌">胰腺癌</a>|</dd>
                            <dd><a href="/yxnz/" title="胰腺囊肿">胰腺囊肿</a>|</dd>
                            <dd><a href="/ydsl/" title="胰岛素瘤">胰岛素瘤</a></dd></dl></li>
<!--                    <li><dl>
                            <dt><a href="/jbzz/fumo/" title="腹膜">腹膜</a></dt>
                            <dd><a href="/fmy/" title="腹膜炎">腹膜炎</a>|</dd>
                            <dd><a href="/fmzl/" title="腹膜肿瘤">腹膜肿瘤</a>|</dd>
                            <dd><a href="/fmhs/" title="腹膜后疝">腹膜后疝</a>|</dd>
                            <dd><a href="/jhxfmy/" title="结核性腹膜炎">结核性腹膜炎</a>|</dd>
                            <dd><a href="/jxfmy/" title="急性腹膜炎">急性腹膜炎</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/changximo/" title="肠系膜">肠系膜</a></dt>
                            <dd><a href="/cxmzl/" title="肠系膜肿瘤">肠系膜肿瘤</a>|</dd>
                            <dd><a href="/wmy/" title="网膜炎">网膜炎</a>|</dd>
                            <dd><a href="/cxmnz/" title="肠系膜囊肿">肠系膜囊肿</a>|</dd>
                            <dd><a href="/cxmlbjy/" title="肠系膜淋巴结炎">肠系膜淋巴结炎</a>|</dd>
                            <dd><a href="/cxmzfy/" title="肠系膜脂肪炎">肠系膜脂肪炎</a></dd></dl></li>-->
                </ul>
            </div>
            <div class="brain fl">
                <h3><a href="/jbzz/fubu_t2/" title="腹部症状">更多</a>症状</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/wei/" title="胃">胃</a></dt>
                            <dd><a href="/zhengzhuang/dg/" title="打嗝">打嗝</a>|</dd>
                            <dd><a href="/zhengzhuang/sjxys/" title="神经性厌食">神经性厌食</a>|</dd>
                            <dd><a href="/zhengzhuang/ft_1121/" title="腹痛">腹痛</a>|</dd>
                            <dd><a href="/zhengzhuang/wbyt/" title="胃部隐痛">胃部隐痛</a>|</dd>
                            <dd><a href="/zhengzhuang/syjc/" title="食欲较差">食欲较差</a>|</dd>
                    </dl></li>

                    <li><dl>
                            <dt><a href="/jbzz/chang/" title="肠">肠</a></dt>
                            <dd><a href="/zhengzhuang/pbkn/" title="排便困难">排便困难</a>|</dd>
                            <dd><a href="/zhengzhuang/bx/" title="便血">便血</a>|</dd>
                            <dd><a href="/zhengzhuang/fs/" title="发烧">发烧</a>|</dd>
                            <dd><a href="/zhengzhuang/xxhdslcx/" title="下消化道少量出血">下消化道少量出血</a>|</dd>
                            <dd><a href="/zhengzhuang/fbzk_1097/" title="腹部肿块">腹部肿块</a>|</dd>
                    </dl></li>

                    <li><dl>
                            <dt><a href="/jbzz/gan/" title="肝">肝</a></dt>
                            <dd><a href="/zhengzhuang/ghm/" title="肝昏迷">肝昏迷</a>|</dd>
                            <dd><a href="/zhengzhuang/gzd/" title="肝肿大">肝肿大</a>|</dd>
                            <dd><a href="/zhengzhuang/mmgy/" title="门脉高压">门脉高压</a>|</dd>
                            <dd><a href="/zhengzhuang/syyc_4043/" title="食欲异常">食欲异常</a>|</dd>
                            <dd><a href="/zhengzhuang/zamzg/" title="转氨酶增高">转氨酶增高</a>|</dd>
                    </dl></li>

                    <li><dl>
                            <dt><a href="/jbzz/dan/" title="胆">胆</a></dt>
                            <dd><a href="/zhengzhuang/djt/" title="胆绞痛">胆绞痛</a>|</dd>
                            <dd><a href="/zhengzhuang/dnzd/" title="胆囊增大">胆囊增大</a>|</dd>
                            <dd><a href="/zhengzhuang/ex/" title="恶心">恶心</a>|</dd>
                            <dd><a href="/zhengzhuang/dhsgjs/" title="胆红素钙结石">胆红素钙结石</a>|</dd>
                            <dd><a href="/zhengzhuang/xrysh/" title="息肉样损害">息肉样损害</a>|</dd>
                    </dl></li>

                    <li><dl>
                            <dt><a href="/jbzz/pi/" title="脾">脾</a></dt>
                            <dd><a href="/zhengzhuang/px/" title="脾虚">脾虚</a>|</dd>
                            <dd><a href="/zhengzhuang/nc_2934/" title="尿赤">尿赤</a>|</dd>
                            <dd><a href="/zhengzhuang/feyt/" title="泛恶欲吐">泛恶欲吐</a>|</dd>
                            <dd><a href="/zhengzhuang/pzd/" title="脾肿大">脾肿大</a>|</dd>
                            <dd><a href="/zhengzhuang/fbzk_1097/" title="腹部肿块">腹部肿块</a>|</dd>
                    </dl></li>

                    <li><dl>
                            <dt><a href="/jbzz/lanwei/" title="阑尾">阑尾</a></dt>
                            <dd><a href="/zhengzhuang/ft_1121/" title="腹痛">腹痛</a>|</dd>
                            <dd><a href="/zhengzhuang/fs/" title="发烧">发烧</a>|</dd>
                            <dd><a href="/zhengzhuang/yxfyt/" title="右下腹压痛">右下腹压痛</a>|</dd>
                            <dd><a href="/zhengzhuang/xfjt/" title="下腹绞痛">下腹绞痛</a>|</dd>
                            <dd><a href="/zhengzhuang/lwnz/" title="阑尾脓肿">阑尾脓肿</a>|</dd>
                    </dl></li>

                    <li><dl>
                            <dt><a href="/jbzz/yixian/" title="胰腺">胰腺</a></dt>
                            <dd><a href="/zhengzhuang/sfbtt/" title="上腹部疼痛">上腹部疼痛</a>|</dd>
                            <dd><a href="/zhengzhuang/yyxft/" title="胰源性腹痛">胰源性腹痛</a>|</dd>
                            <dd><a href="/zhengzhuang/tn/" title="糖尿">糖尿</a>|</dd>
                            <dd><a href="/zhengzhuang/tfxysfjt/" title="突发性右上腹绞痛">突发性右上腹绞痛</a>|</dd>
                            <dd><a href="/zhengzhuang/dbsq/" title="大便色浅">大便色浅</a>|</dd>
                    </dl></li>

<!--                    <li><dl>
                            <dt><a href="/jbzz/fumo/" title="腹膜">腹膜</a></dt>
                            <dd><a href="/zhengzhuang/cxxtt/" title="持续性疼痛">持续性疼痛</a>|</dd>
                            <dd><a href="/zhengzhuang/fjjz/" title="腹肌紧张">腹肌紧张</a>|</dd>
                            <dd><a href="/zhengzhuang/fs_1120/" title="腹水">腹水</a>|</dd>
                            <dd><a href="/zhengzhuang/zfqq/" title="左腹屈曲">左腹屈曲</a>|</dd>
                            <dd><a href="/zhengzhuang/qpyww/" title="强迫仰卧位">强迫仰卧位</a>|</dd></dl></li>

                    <li><dl>
                            <dt><a href="/jbzz/changximo/" title="肠系膜">肠系膜</a></dt>
                            <dd><a href="/zhengzhuang/fz/" title="腹胀">腹胀</a>|</dd>
                            <dd><a href="/zhengzhuang/lbjcx/" title="淋巴结充血">淋巴结充血</a>|</dd>
                            <dd><a href="/zhengzhuang/ex/" title="恶心">恶心</a>|</dd>
                            <dd><a href="/zhengzhuang/sfbbk/" title="上腹部包块">上腹部包块</a>|</dd>
                            <dd><a href="/zhengzhuang/fbzk_1097/" title="腹部肿块">腹部肿块</a>|</dd>-->
                    </dl></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="sholay" style="height:200px;">
            <div class="brain fl">
                <h3><a href="/jbzz/yaobu_t1/" title="腰部疾病">更多</a>疾病</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/shen/" title="肾">肾</a></dt>
                            <dd><a href="/sjs_3686/" title="肾结石">肾结石</a>|</dd>
                            <dd><a href="/sjs/" title="肾积水">肾积水</a>|</dd>
                            <dd><a href="/ndz/" title="尿毒症">尿毒症</a>|</dd>
                            <dd><a href="/mxsy/" title="慢性肾炎">慢性肾炎</a>|</dd>
                            <dd><a href="/snz/" title="肾囊肿">肾囊肿</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/shenshangxian/" title="肾上腺">肾上腺</a></dt>
                            <dd><a href="/ssxwx/" title="肾上腺危象">肾上腺危象</a>|</dd>
                            <dd><a href="/ssxszd/" title="肾上腺素中毒">肾上腺素中毒</a>|</dd>
                            <dd><a href="/ssxywl/" title="肾上腺意外瘤">肾上腺意外瘤</a>|</dd>
                            <dd><a href="/ssxszzs/" title="肾上腺髓质增生">肾上腺髓质增生</a>|</dd>
                            <dd><a href="/sjmxbl/" title="神经母细胞瘤">神经母细胞瘤</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/shuniaoguan/" title="输尿管">输尿管</a></dt>
                            <dd><a href="/sngy/" title="输尿管炎">输尿管炎</a>|</dd>
                            <dd><a href="/sngjs/" title="输尿管结石">输尿管结石</a>|</dd>
                            <dd><a href="/xn/" title="血尿">血尿</a>|</dd>
                            <dd><a href="/xenlgr/" title="小儿尿路感染">小儿尿路感染</a>|</dd>
                            <dd><a href="/zjxnlgr/" title="真菌性尿路感染">真菌性尿路感染</a></dd></dl></li>
                </ul>
            </div>
            <div class="brain fl">
                <h3><a href="/jbzz/yaobu_t2/" title="腰部症状">更多</a>症状</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/shen/" title="肾">肾</a></dt>
                            <dd><a href="/zhengzhuang/sz_4249/" title="水肿">水肿</a>|</dd>
                            <dd><a href="/zhengzhuang/dn/" title="多尿">多尿</a>|</dd>
                            <dd><a href="/zhengzhuang/nj/" title="尿急">尿急</a>|</dd>
                            <dd><a href="/zhengzhuang/ndb/" title="尿蛋白">尿蛋白</a>|</dd>
                             <dd><a href="/zhengzhuang/nyx/" title="尿隐血">尿隐血</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/shenshangxian/" title="肾上腺">肾上腺</a></dt>
                            <dd><a href="/zhengzhuang/xjsgd/" title="雄激素过多">雄激素过多</a>|</dd>
                            <dd><a href="/zhengzhuang/pzgnjt/" title="皮质功能减退">皮质功能减退</a>|</dd>
                            <dd><a href="/zhengzhuang/ss_4083/" title="嗜睡">嗜睡</a>|</dd>
                            <dd><a href="/zhengzhuang/ssxzy/" title="肾上腺转移">肾上腺转移</a>|</dd>
                            <dd><a href="/zhengzhuang/nxh/" title="男性化">男性化</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/shuniaoguan/" title="输尿管">输尿管</a></dt>
                            <dd><a href="/zhengzhuang/dwyt/" title="低位腰痛">低位腰痛</a>|</dd>
                            <dd><a href="/zhengzhuang/nx/" title="尿血">尿血</a>|</dd>
                            <dd><a href="/zhengzhuang/np/" title="尿频">尿频</a>|</dd>
                            <dd><a href="/zhengzhuang/nn/" title="脓尿">脓尿</a>|</dd>
                             <dd><a href="/zhengzhuang/sqkjt/" title="肾区叩击痛">肾区叩击痛</a></dd></dl></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="sholay" style="height:310px;">
            <div class="brain fl">
                <h3><a href="/jbzz/nanxingshengzhi_t1/" title="男性生殖疾病">更多</a>疾病</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/qianliexian/" title="前列腺">前列腺</a></dt>
                            <dd><a href="/qlxy/" title="前列腺炎">前列腺炎</a>|</dd>
                            <dd><a href="/qlxa/" title="前列腺癌">前列腺癌</a>|</dd>
                            <dd><a href="/qlxjs/" title="前列腺结石">前列腺结石</a>|</dd>
                            <dd><a href="/qlxzs/" title="前列腺增生">前列腺增生</a>|</dd>
                            <dd><a href="/qlxnz/" title="前列腺囊肿">前列腺囊肿</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/gaowan/" title="睾丸">睾丸</a></dt>
                            <dd><a href="/gwa/" title="睾丸癌">睾丸癌</a>|</dd>
                            <dd><a href="/gwss/" title="睾丸损伤">睾丸损伤</a>|</dd>
                            <dd><a href="/gwy_3773/" title="睾丸炎">睾丸炎</a>|</dd>
                            <dd><a href="/fgy/" title="附睾炎">附睾炎</a>|</dd>
                            <dd><a href="/gwnz/" title="睾丸扭转">睾丸扭转</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/yinjing/" title="阴茎">阴茎</a></dt>
                            <dd><a href="/yw/" title="阳痿">阳痿</a>|</dd>
                            <dd><a href="/gty/" title="龟头炎">龟头炎</a>|</dd>
                            <dd><a href="/xyj/" title="小阴茎">小阴茎</a>|</dd>
                            <dd><a href="/bpgc/" title="包皮过长">包皮过长</a>|</dd>
                            <dd><a href="/yjycbq/" title="阴茎异常勃起">阴茎异常勃起</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/shujingguan/" title="输精管">输精管</a></dt>
                            <dd><a href="/sjgds/" title="输精管堵塞">输精管堵塞</a>|</dd>
                            <dd><a href="/sjgqr/" title="输精管缺如">输精管缺如</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/yinnang/" title="阴囊">阴囊</a></dt>
                            <dd><a href="/yny_9318/" title="阴囊炎">阴囊炎</a>|</dd>
                            <dd><a href="/yna/" title="阴囊癌">阴囊癌</a>|</dd>
                            <dd><a href="/ynsz/" title="阴囊湿疹">阴囊湿疹</a>|</dd>
                            <dd><a href="/qs_8669/" title="气疝">气疝</a>|</dd>
                            <dd><a href="/qmjy/" title="鞘膜积液">鞘膜积液</a></dd></dl></li>
                </ul>
            </div>
            <div class="brain fl">
                <h3><a href="/jbzz/nanxingshengzhi_t2/" title="男性生殖症状">更多</a>症状</h3>
                <ul class="brainf">
                     <li><dl>
                            <dt><a href="/jbzz/qianliexian/" title="前列腺">前列腺</a></dt>
                            <dd><a href="/zhengzhuang/ynzd/" title="夜尿增多">夜尿增多</a>|</dd>
                            <dd><a href="/zhengzhuang/nj/" title="尿急">尿急</a>|</dd>
                            <dd><a href="/zhengzhuang/np/" title="尿频">尿频</a>|</dd>
                            <dd><a href="/zhengzhuang/grhz/" title="高热寒战">高热寒战</a>|</dd>
                            <dd><a href="/zhengzhuang/ndszg/" title="尿道烧灼感">尿道烧灼感</a></dd></dl></li>
  
                     <li><dl>
                            <dt><a href="/jbzz/gaowan/" title="睾丸">睾丸</a></dt>
                            <dd><a href="/zhengzhuang/fgjs/" title="附睾结石">附睾结石</a>|</dd>
                            <dd><a href="/zhengzhuang/gwzt/" title="睾丸胀痛">睾丸胀痛</a>|</dd>
                            <dd><a href="/zhengzhuang/fgnz/" title="附睾囊肿">附睾囊肿</a>|</dd>
                            <dd><a href="/zhengzhuang/nxxft/" title="男性小腹痛">男性小腹痛</a>|</dd>
                            <dd><a href="/zhengzhuang/nxfmw/" title="脓性分泌物">脓性分泌物</a></dd></dl></li>

                     <li><dl>
                            <dt><a href="/jbzz/yinjing/" title="阴茎">阴茎</a></dt>
                            <dd><a href="/zhengzhuang/bpsz/" title="包皮水肿">包皮水肿</a>|</dd>
                            <dd><a href="/zhengzhuang/bpzl/" title="包皮粘连">包皮粘连</a>|</dd>
                            <dd><a href="/zhengzhuang/gtsy/" title="龟头瘙痒">龟头瘙痒</a>|</dd>
                            <dd><a href="/zhengzhuang/yjd_5844/" title="阴茎短">阴茎短</a>|</dd>
                            <dd><a href="/zhengzhuang/yjbqxky/" title="阴茎表浅性溃疡">阴茎表浅性溃疡</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/shujingguan/" title="输精管">输精管</a></dt>
                            <dd><a href="/zhengzhuang/sjt/" title="射精疼">射精疼</a>|</dd>
                            <dd><a href="/zhengzhuang/jzhld/" title="精子活力低">精子活力低</a>|</dd>
                            <dd><a href="/zhengzhuang/jys_2057/" title="精液少">精液少</a>|</dd>
                            <dd><a href="/zhengzhuang/sjgbc/" title="输精管变粗">输精管变粗</a>|</dd>
                            <dd><a href="/zhengzhuang/sjgds/" title="输精管堵塞">输精管堵塞</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/yinnang/" title="阴囊">阴囊</a></dt>
                            <dd><a href="/zhengzhuang/yncs/" title="阴囊潮湿">阴囊潮湿</a>|</dd>
                            <dd><a href="/zhengzhuang/ynsy/" title="阴囊瘙痒">阴囊瘙痒</a>|</dd>
                            <dd><a href="/zhengzhuang/ynzz/" title="阴囊肿胀">阴囊肿胀</a>|</dd>
                            <dd><a href="/zhengzhuang/pnbc/" title="排尿不畅">排尿不畅</a>|</dd>
                            <dd><a href="/zhengzhuang/jnsx/" title="精囊缩小">精囊缩小</a></dd></dl></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        
        <div class="sholay" style="height:315px;">
            <div class="brain fl">
                <h3><a href="/jbzz/nvxingshengzhi_t1/" title="女性生殖疾病">更多</a>疾病</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/luanchao/" title="卵巢">卵巢</a></dt>
                            <dd><a href="/lcnz/" title="卵巢囊肿">卵巢囊肿</a>|</dd>
                            <dd><a href="/lcpl/" title="卵巢破裂">卵巢破裂</a>|</dd>
                            <dd><a href="/lcy/" title="卵巢炎">卵巢炎</a>|</dd>
                            <dd><a href="/lca/" title="卵巢癌">卵巢癌</a>|</dd>
                            <dd><a href="/lczs/" title="卵巢早衰">卵巢早衰</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/zigong/" title="子宫">子宫</a></dt>
                            <dd><a href="/zgjl/" title="子宫肌瘤">子宫肌瘤</a>|</dd>
                            <dd><a href="/gjml/" title="宫颈糜烂">宫颈糜烂</a>|</dd>
                            <dd><a href="/gja/" title="宫颈癌">宫颈癌</a>|</dd>
                            <dd><a href="/zgnmywz/" title="子宫内膜异位症">子宫内膜异位症</a>|</dd>
                            <dd><a href="/zgnma/" title="子宫内膜癌">子宫内膜癌</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/shuluanguan/" title="输卵管">输卵管</a></dt>
                            <dd><a href="/slgy/" title="输卵管炎">输卵管炎</a>|</dd>
                            <dd><a href="/fjy/" title="附件炎">附件炎</a>|</dd>
                            <dd><a href="/slgaslz/" title="输卵管癌三联症">输卵管癌三联症</a>|</dd>
                            <dd><a href="/slgjs/" title="输卵管积水">输卵管积水</a>|</dd>
                            <dd><a href="/slgxby/" title="输卵管性不孕">输卵管性不孕</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/yindao/" title="阴道">阴道</a></dt>
                            <dd><a href="/ydy/" title="阴道炎">阴道炎</a>|</dd>
                            <dd><a href="/ydjl/" title="阴道痉挛">阴道痉挛</a>|</dd>
                            <dd><a href="/ydbb/" title="阴道白斑">阴道白斑</a>|</dd>
                            <dd><a href="/cnmbs/" title="处女膜闭锁">处女膜闭锁</a>|</dd>
                            <dd><a href="/mjxydy/" title="霉菌性阴道炎">霉菌性阴道炎</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/waiyin/" title="外阴">外阴</a></dt>
                            <dd><a href="/wyy/" title="外阴炎">外阴炎</a>|</dd>
                            <dd><a href="/wysy/" title="外阴瘙痒">外阴瘙痒</a>|</dd>
                            <dd><a href="/wysz/" title="外阴湿疹">外阴湿疹</a>|</dd>
                            <dd><a href="/wyky/" title="外阴溃疡">外阴溃疡</a>|</dd>
                            <dd><a href="/qtdxnz/" title="前庭大腺囊肿">前庭大腺囊肿</a></dd></dl></li>
                </ul>
            </div>
            <div class="brain fl">
                <h3><a href="/jbzz/nvxingshengzhi_t2/" title="女性生殖症状">更多</a>症状</h3>
                <ul class="brainf">
                     <li><dl>
                            <dt><a href="/jbzz/luanchao/" title="卵巢">卵巢</a></dt>
                            <dd><a href="/zhengzhuang/xfbbk/" title="下腹部包块">下腹部包块</a>|</dd>
                            <dd><a href="/zhengzhuang/xftt/" title="下腹疼痛">下腹疼痛</a>|</dd>
                            <dd><a href="/zhengzhuang/yjbd/" title="月经不调">月经不调</a>|</dd>
                            <dd><a href="/zhengzhuang/htpl/" title="黄体破裂">黄体破裂</a>|</dd>
                            <dd><a href="/zhengzhuang/jjhcx/" title="绝经后出血">绝经后出血</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/zigong/" title="子宫">子宫</a></dt>
                            <dd><a href="/zhengzhuang/bdzd/" title="白带增多">白带增多</a>|</dd>
                            <dd><a href="/zhengzhuang/nxxbd/" title="脓血性白带">脓血性白带</a>|</dd>
                            <dd><a href="/zhengzhuang/zgcx/" title="子宫出血">子宫出血</a>|</dd>
                            <dd><a href="/zhengzhuang/gjsz/" title="宫颈水肿">宫颈水肿</a>|</dd>
                            <dd><a href="/zhengzhuang/xjtt/" title="性交疼痛">性交疼痛</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/shuluanguan/" title="输卵管">输卵管</a></dt>
                            <dd><a href="/zhengzhuang/nxby_3044/" title="女性不孕">女性不孕</a>|</dd>
                            <dd><a href="/zhengzhuang/xfzt_4899/" title="下腹坠痛">下腹坠痛</a>|</dd>
                            <dd><a href="/zhengzhuang/pqbk/" title="盆腔包块">盆腔包块</a>|</dd>
                            <dd><a href="/zhengzhuang/jfxby/" title="继发性不孕">继发性不孕</a>|</dd>
                            <dd><a href="/zhengzhuang/yjld/" title="月经量多">月经量多</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/yindao/" title="阴道">阴道</a></dt>
                            <dd><a href="/zhengzhuang/bdzd/" title="白带增多">白带增多</a>|</dd>
                            <dd><a href="/zhengzhuang/nxxbd/" title="脓血性白带">脓血性白带</a>|</dd>
                            <dd><a href="/zhengzhuang/xjkn/" title="性交困难">性交困难</a>|</dd>
                            <dd><a href="/zhengzhuang/xfzz/" title="下腹坠胀">下腹坠胀</a>|</dd>
                             <dd><a href="/zhengzhuang/ydfmwzd/" title="阴道分泌物增多">阴道分泌物增多</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/waiyin/" title="外阴">外阴</a></dt>
                            <dd><a href="/zhengzhuang/hyky/" title="会阴溃疡">会阴溃疡</a>|</dd>
                            <dd><a href="/zhengzhuang/nt_2994/" title="尿痛">尿痛</a>|</dd>
                            <dd><a href="/zhengzhuang/wyxzg/" title="外阴下坠感">外阴下坠感</a>|</dd>
                            <dd><a href="/zhengzhuang/wyszcjg/" title="外阴烧灼刺激感">外阴烧灼刺激感</a>|</dd>
                            <dd><a href="/zhengzhuang/wypfzz/" title="外阴皮肤肿胀">外阴皮肤肿胀</a></dd></dl></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="sholay" style="height:380px;">
            <div class="brain fl">
                <h3><a href="/jbzz/quanshen_t1/" title="全身疾病">更多</a>疾病</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/pifu/" title="皮肤">皮肤</a></dt>
                            <dd><a href="/py_9029/" title="皮炎">皮炎</a>|</dd>
                            <dd><a href="/sz/" title="湿疹">湿疹</a>|</dd>
                            <dd><a href="/npx/" title="牛皮癣">牛皮癣</a>|</dd>
                            <dd><a href="/szqpz/" title="生殖器疱疹">生殖器疱疹</a>|</dd>
                            <dd><a href="/pfgm/" title="皮肤过敏">皮肤过敏</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/linba/" title="淋巴">淋巴</a></dt>
                            <dd><a href="/lba/" title="淋巴癌">淋巴癌</a>|</dd>
                            <dd><a href="/lbl/" title="淋巴瘤">淋巴瘤</a>|</dd>
                            <dd><a href="/jblbjjh/" title="颈部淋巴结结核">颈部淋巴结结核</a>|</dd>
                            <dd><a href="/mxlbjy/" title="慢性淋巴结炎">慢性淋巴结炎</a>|</dd>
                            <dd><a href="/lbsz/" title="淋巴水肿">淋巴水肿</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/xueyexueguan/" title="血液血管">血液血管</a></dt>
                            <dd><a href="/bxb/" title="白血病">白血病</a>|</dd>
                            <dd><a href="/xyb/" title="血友病">血友病</a>|</dd>
                            <dd><a href="/dzhpx/" title="地中海贫血">地中海贫血</a>|</dd>
                            <dd><a href="/dmyh/" title="动脉硬化">动脉硬化</a>|</dd>
                            <dd><a href="/zdml/" title="主动脉瘤">主动脉瘤</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/mianyixitong/" title="免疫系统">免疫系统</a></dt>
                            <dd><a href="/hblc/" title="红斑狼疮">红斑狼疮</a>|</dd>
                            <dd><a href="/gzzhz/" title="干燥综合征">干燥综合征</a>|</dd>
                            <dd><a href="/jjxhb/" title="结节性红斑">结节性红斑</a>|</dd>
                            <dd><a href="/zsmyxrxxpx/" title="自身免疫性溶血性贫血">自身免疫性溶血性贫血</a>|</dd>
                            <dd><a href="/hhjdzzb/" title="混合结缔组织病">混合结缔组织病</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/jirou/" title="肌肉">肌肉</a></dt>
                            <dd><a href="/zzjwl/" title="重症肌无力">重症肌无力</a>|</dd>
                            <dd><a href="/dfxjy/" title="多发性肌炎">多发性肌炎</a>|</dd>
                            <dd><a href="/jrjl/" title="肌肉痉挛">肌肉痉挛</a>|</dd>
                            <dd><a href="/zqxmb/" title="周期性麻痹">周期性麻痹</a>|</dd>
                            <dd><a href="/pjy/" title="皮肌炎">皮肌炎</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/zhouweishenjingxitong/" title="周围神经系统">周围神经系统</a></dt>
                            <dd><a href="/zwsjy/" title="周围神经炎">周围神经炎</a>|</dd>
                            <dd><a href="/scsjt/" title="三叉神经痛">三叉神经痛</a>|</dd>
                            <dd><a href="/lnb/" title="雷诺病">雷诺病</a>|</dd>
                            <dd><a href="/zwsjss/" title="周围神经损伤">周围神经损伤</a>|</dd>
                            <dd><a href="/zgsjt/" title="坐骨神经痛">坐骨神经痛</a></dd></dl></li>
                </ul>
            </div>
            <div class="brain fl">
                <h3><a href="/jbzz/quanshen_t2/" title="全身症状">更多</a>症状</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/pifu/" title="皮肤">皮肤</a></dt>
                            <dd><a href="/zhengzhuang/pfsy_3196/" title="皮肤瘙痒">皮肤瘙痒</a>|</dd>
                            <dd><a href="/zhengzhuang/lscb/" title="脸上长斑">脸上长斑</a>|</dd>
                            <dd><a href="/zhengzhuang/qz/" title="丘疹">丘疹</a>|</dd>
                            <dd><a href="/zhengzhuang/pfsdtt/" title="皮肤闪电疼痛">皮肤闪电疼痛</a>|</dd>
                            <dd><a href="/zhengzhuang/pffh/" title="皮肤发红">皮肤发红</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/linba/" title="淋巴">淋巴</a></dt>
                            <dd><a href="/zhengzhuang/lbjtt/" title="淋巴结疼痛">淋巴结疼痛</a>|</dd>
                            <dd><a href="/zhengzhuang/lbgyj/" title="淋巴管淤积">淋巴管淤积</a>|</dd>
                            <dd><a href="/zhengzhuang/lbzs/" title="淋巴增生">淋巴增生</a>|</dd>
                            <dd><a href="/zhengzhuang/lbjzd/" title="淋巴结肿大">淋巴结肿大</a>|</dd>
                            <dd><a href="/zhengzhuang/lbylc/" title="淋巴液流出">淋巴液流出</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/xueyexueguan/" title="血液血管">血液血管</a></dt>
                            <dd><a href="/zhengzhuang/cxxczr/" title="持续性弛张热">持续性弛张热</a>|</dd>
                            <dd><a href="/zhengzhuang/pfcxb/" title="皮肤出血斑">皮肤出血斑</a>|</dd>
                            <dd><a href="/zhengzhuang/tt/" title="头痛">头痛</a>|</dd>
                            <dd><a href="/zhengzhuang/xgzy/" title="血管杂音">血管杂音</a>|</dd>
                            <dd><a href="/zhengzhuang/qxxr/" title="气血虚弱">气血虚弱</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/mianyixitong/" title="免疫系统">免疫系统</a></dt>
                            <dd><a href="/zhengzhuang/hbjj/" title="红斑结节">红斑结节</a>|</dd>
                            <dd><a href="/zhengzhuang/bxbn/" title="白细胞尿">白细胞尿</a>|</dd>
                            <dd><a href="/zhengzhuang/bt/" title="斑秃">斑秃</a>|</dd>
                            <dd><a href="/zhengzhuang/gjtt/" title="关节疼痛">关节疼痛</a>|</dd>
                            <dd><a href="/zhengzhuang/mylxj/" title="免疫力下降">免疫力下降</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/jirou/" title="肌肉">肌肉</a></dt>
                            <dd><a href="/zhengzhuang/jrws/" title="肌肉萎缩">肌肉萎缩</a>|</dd>
                            <dd><a href="/zhengzhuang/jryt/" title="肌肉压痛">肌肉压痛</a>|</dd>
                            <dd><a href="/zhengzhuang/jbztcd/" title="局部肢体抽动">局部肢体抽动</a>|</dd>
                            <dd><a href="/zhengzhuang/hxkn/" title="呼吸困难">呼吸困难</a>|</dd>
                            <dd><a href="/zhengzhuang/jxxxs/" title="进行性消瘦">进行性消瘦</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/zhouweishenjingxitong/" title="周围神经系统">周围神经系统</a></dt>
                            <dd><a href="/zhengzhuang/jzljd/" title="肌张力减低">肌张力减低</a>|</dd>
                            <dd><a href="/zhengzhuang/cc_459/" title="抽搐">抽搐</a>|</dd>
                            <dd><a href="/zhengzhuang/pfcb/" title="皮肤苍白">皮肤苍白</a>|</dd>
                            <dd><a href="/zhengzhuang/gjza/" title="感觉障碍">感觉障碍</a>|</dd>
                            <dd><a href="/zhengzhuang/ybjzg/" title="腰部僵直感">腰部僵直感</a></dd></dl></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="sholay" style="height:315px; margin-top:116px;">
            <div class="brain fl">
                <h3><a href="/jbzz/shangzhi_t1/" title="上肢疾病">更多</a>疾病</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/jianbu/" title="肩部">肩部</a></dt>
                            <dd><a href="/jzy/" title="肩周炎">肩周炎</a>|</dd>
                            <dd><a href="/jxss/" title="肩袖损伤">肩袖损伤</a>|</dd>
                            <dd><a href="/jfxhny/" title="肩峰下滑囊炎">肩峰下滑囊炎</a>|</dd>
                            <dd><a href="/j_szhz/" title="肩-手综合征">肩-手综合征</a>|</dd>
                            <dd><a href="/jsgjtw/" title="肩锁关节脱位">肩锁关节脱位</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/shangbi/" title="上臂">上臂</a></dt>
                            <dd><a href="/bcsjss/" title="臂丛神经损伤">臂丛神经损伤</a>|</dd>
                            <dd><a href="/gdmss/" title="肱动脉损伤">肱动脉损伤</a>|</dd>
                            <dd><a href="/ytz/" title="伊藤痣">伊藤痣</a>|</dd>
                            <dd><a href="/ggnsky/" title="肱骨内上髁炎">肱骨内上髁炎</a>|</dd>
                            <dd><a href="/mmxyexwlb/" title="弥漫性婴儿纤维瘤病">弥漫性婴儿纤维瘤病</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/zhoubu/" title="肘部">肘部</a></dt>
                            <dd><a href="/zgzhz/" title="肘管综合征">肘管综合征</a>|</dd>
                            <dd><a href="/zwf/" title="肘外翻">肘外翻</a>|</dd>
                            <dd><a href="/zgjqz/" title="肘关节强直">肘关节强直</a>|</dd>
                            <dd><a href="/zgjjh/" title="肘关节结核">肘关节结核</a>|</dd>
                            <dd><a href="/csxzgjy/" title="创伤性肘关节炎">创伤性肘关节炎</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/qianbi/" title="前臂">前臂</a></dt>
                            <dd><a href="/rgzhz/" title="桡管综合征">桡管综合征</a>|</dd>
                            <dd><a href="/rsjmb/" title="桡神经麻痹">桡神经麻痹</a>|</dd>
                            <dd><a href="/ygtw/" title="月骨脱位">月骨脱位</a>|</dd>
                            <dd><a href="/cgzhz/" title="尺管综合征">尺管综合征</a>|</dd>
                            <dd><a href="/cgggz/" title="尺骨干骨折">尺骨干骨折</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/shoubu/" title="手部">手部</a></dt>
                            <dd><a href="/hzj/" title="灰指甲">灰指甲</a>|</dd>
                            <dd><a href="/jgy/" title="甲沟炎">甲沟炎</a>|</dd>
                            <dd><a href="/jqy/" title="腱鞘炎">腱鞘炎</a>|</dd>
                            <dd><a href="/cjz/" title="脆甲症">脆甲症</a>|</dd>
                            <dd><a href="/szx/" title="手足癣">手足癣</a></dd></dl></li>
                </ul>
            </div>
            <div class="brain fl">
                <h3><a href="/jbzz/shangzhi_t2/" title="上肢症状">更多</a>症状</h3>
                <ul class="brainf">
                     <li><dl>
                            <dt><a href="/jbzz/jianbu/" title="肩部">肩部</a></dt>
                            <dd><a href="/zhengzhuang/jt_1870/" title="肩痛">肩痛</a>|</dd>
                            <dd><a href="/zhengzhuang/gjls/" title="关节挛缩">关节挛缩</a>|</dd>
                            <dd><a href="/zhengzhuang/gzss/" title="骨质疏松">骨质疏松</a>|</dd>
                            <dd><a href="/zhengzhuang/jgjhdsx/" title="肩关节活动受限">肩关节活动受限</a>|</dd>
                            <dd><a href="/zhengzhuang/nj_3014/" title="凝肩">凝肩</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/shangbi/" title="上臂">上臂</a></dt>
                            <dd><a href="/zhengzhuang/szcchxmb/" title="上肢呈迟缓性麻痹">上肢呈迟缓性麻痹</a>|</dd>
                            <dd><a href="/zhengzhuang/bz/" title="斑疹">斑疹</a>|</dd>
                            <dd><a href="/zhengzhuang/wl/" title="无力">无力</a>|</dd>
                            <dd><a href="/zhengzhuang/jrws/" title="肌肉萎缩">肌肉萎缩</a>|</dd>
                            <dd><a href="/zhengzhuang/sjgss/" title="神经根损伤">神经根损伤</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/zhoubu/" title="肘部">肘部</a></dt>
                            <dd><a href="/zhengzhuang/gjqz/" title="关节强直">关节强直</a>|</dd>
                            <dd><a href="/zhengzhuang/gzph/" title="骨质破坏">骨质破坏</a>|</dd>
                            <dd><a href="/zhengzhuang/gjzz/" title="关节肿胀">关节肿胀</a>|</dd>
                            <dd><a href="/zhengzhuang/gjjbct/" title="关节局部刺痛">关节局部刺痛</a>|</dd>
                            <dd><a href="/zhengzhuang/gjtt/" title="关节疼痛">关节疼痛</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/qianbi/" title="前臂">前臂</a></dt>
                            <dd><a href="/zhengzhuang/snjws/" title="手内肌萎缩">手内肌萎缩</a>|</dd>
                            <dd><a href="/zhengzhuang/jzljd/" title="肌张力减低">肌张力减低</a>|</dd>
                            <dd><a href="/zhengzhuang/dt_750/" title="钝痛">钝痛</a>|</dd>
                            <dd><a href="/zhengzhuang/jrws/" title="肌肉萎缩">肌肉萎缩</a>|</dd>
                            <dd><a href="/zhengzhuang/pxxz/" title="皮下血肿">皮下血肿</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/shoubu/" title="手部">手部</a></dt>
                            <dd><a href="/zhengzhuang/zjys/" title="指甲易碎">指甲易碎</a>|</dd>
                            <dd><a href="/zhengzhuang/jsag/" title="甲身凹沟">甲身凹沟</a>|</dd>
                            <dd><a href="/zhengzhuang/gjzd/" title="关节肿大">关节肿大</a>|</dd>
                            <dd><a href="/zhengzhuang/jzjnc/" title="脚趾甲内长">脚趾甲内长</a>|</dd>
                            <dd><a href="/zhengzhuang/bpjh/" title="表皮角化">表皮角化</a></dd></dl></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="sholay" style="height:250px; margin-top:181px;">
            <div class="brain fl">
                <h3><a href="/jbzz/xiazhi_t1/" title="下肢疾病">更多</a>疾病</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/datui/" title="大腿">大腿</a></dt>
                            <dd><a href="/zgsjss/" title="坐骨神经损伤">坐骨神经损伤</a>|</dd>
                            <dd><a href="/zgsjt/" title="坐骨神经痛">坐骨神经痛</a>|</dd>
                            <dd><a href="/ggths/" title="股骨头坏死">股骨头坏死</a>|</dd>
                            <dd><a href="/gdmss_5703/" title="股动脉损伤">股动脉损伤</a>|</dd>
                            <dd><a href="/gdml/" title="股动脉瘤">股动脉瘤</a></dd></dl></li>

                    <li><dl>
                            <dt><a href="/jbzz/xiaotui/" title="小腿">小腿</a></dt>
                            <dd><a href="/jfggz/" title="胫腓骨骨折">胫腓骨骨折</a>|</dd>
                            <dd><a href="/yzxzd/" title="淤滞性紫癜">淤滞性紫癜</a>|</dd>
                            <dd><a href="/js/" title="肌疝">肌疝</a>|</dd>
                            <dd><a href="/xtdmss/" title="小腿动脉损伤">小腿动脉损伤</a>|</dd>
                            <dd><a href="/jqnysz/" title="胫前黏液水肿">胫前黏液水肿</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/xibu/" title="膝部">膝部</a></dt>
                            <dd><a href="/xgjjh/" title="膝关节结核">膝关节结核</a>|</dd>
                            <dd><a href="/szrdss/" title="十字韧带损伤">十字韧带损伤</a>|</dd>
                            <dd><a href="/bybss/" title="半月板损伤">半月板损伤</a>|</dd>
                            <dd><a href="/bjdl/" title="髌腱断裂">髌腱断裂</a>|</dd>
                            <dd><a href="/bgrhz/" title="髌骨软化症">髌骨软化症</a></dd></dl></li>
                    <li><dl>
                            <dt><a href="/jbzz/zubu/" title="足部">足部</a></dt>
                            <dd><a href="/jq/" title="脚气">脚气</a>|</dd>
                            <dd><a href="/szx/" title="手足癣">手足癣</a>|</dd>
                            <dd><a href="/zy/" title="跖疣">跖疣</a>|</dd>
                            <dd><a href="/tnbz/" title="糖尿病足">糖尿病足</a>|</dd>
                            <dd><a href="/bpz/" title="扁平足">扁平足</a></dd></dl></li>
                </ul>
            </div>
            <div class="brain fl">
                <h3><a href="/jbzz/xiazhi_t2/" title="下肢症状">更多</a>症状</h3>
                <ul class="brainf">
                     <li><dl>
                            <dt><a href="/jbzz/datui/" title="大腿">大腿</a></dt>
                            <dd><a href="/zhengzhuang/bbst/" title="背部酸痛">背部酸痛</a>|</dd>
                            <dd><a href="/zhengzhuang/dmcx/" title="动脉出血">动脉出血</a>|</dd>
                            <dd><a href="/zhengzhuang/jxxbx/" title="间歇性跛行">间歇性跛行</a>|</dd>
                            <dd><a href="/zhengzhuang/dtjrws/" title="大腿肌肉萎缩">大腿肌肉萎缩</a>|</dd>
                            <dd><a href="/zhengzhuang/kgjt/" title="髋关节痛">髋关节痛</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/xiaotui/" title="小腿">小腿</a></dt>
                            <dd><a href="/zhengzhuang/xtst/" title="小腿酸痛">小腿酸痛</a>|</dd>
                            <dd><a href="/zhengzhuang/jgtt/" title="胫骨疼痛">胫骨疼痛</a>|</dd>
                            <dd><a href="/zhengzhuang/ky_2403/" title="溃疡">溃疡</a>|</dd>
                            <dd><a href="/zhengzhuang/sz_4249/" title="水肿">水肿</a>|</dd>
                            <dd><a href="/zhengzhuang/nyfmkj/" title="黏液分泌亢进">黏液分泌亢进</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/xibu/" title="膝部">膝部</a></dt>
                            <dd><a href="/zhengzhuang/gjjy/" title="关节积液">关节积液</a>|</dd>
                            <dd><a href="/zhengzhuang/jltt/" title="剧烈疼痛">剧烈疼痛</a>|</dd>
                            <dd><a href="/zhengzhuang/gjzz/" title="关节肿胀">关节肿胀</a>|</dd>
                            <dd><a href="/zhengzhuang/sxza/" title="伸膝障碍">伸膝障碍</a>|</dd>
                            <dd><a href="/zhengzhuang/drt/" title="打软腿">打软腿</a></dd></dl></li>
                     <li><dl>
                            <dt><a href="/jbzz/zubu/" title="足部">足部</a></dt>
                            <dd><a href="/zhengzhuang/sy/" title="瘙痒">瘙痒</a>|</dd>
                            <dd><a href="/zhengzhuang/zdky_6406/" title="足底溃疡">足底溃疡</a>|</dd>
                            <dd><a href="/zhengzhuang/gxz/" title="弓形足">弓形足</a>|</dd>
                            <dd><a href="/zhengzhuang/chyc/" title="出汗异常">出汗异常</a>|</dd>
                            <dd><a href="/zhengzhuang/bzjbt/" title="八字脚步态">八字脚步态</a></dd></dl></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="sholay" style="height:70px; margin-top:361px;">
            <div class="brain fl">
                <h3><a href="/jbzz/xinli_t1/" title="心理疾病">更多</a>疾病</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/xinli/" title="心理">心理</a></dt>
                            <dd><a href="/smz/" title="失眠症">失眠症</a>|</dd>
                            <dd><a href="/jlz/" title="焦虑症">焦虑症</a>|</dd>
                            <dd><a href="/zbz/" title="自闭症">自闭症</a>|</dd>
                            <dd><a href="/qpz/" title="强迫症">强迫症</a>|</dd>
                            <dd><a href="/yyz/" title="抑郁症">抑郁症</a></dd></dl></li>
                </ul>
            </div>
            <div class="brain fl">
                <h3><a href="/jbzz/xinli_t2/" title="心理症状">更多</a>症状</h3>
                <ul class="brainf">
                    <li><dl>
                            <dt><a href="/jbzz/xinli/" title="心理">心理</a></dt>
                            <dd><a href="/zhengzhuang/rskn/" title="入睡困难">入睡困难</a>|</dd>
                            <dd><a href="/zhengzhuang/qxdl/" title="情绪低落">情绪低落</a>|</dd>
                            <dd><a href="/zhengzhuang/jl/" title="焦虑">焦虑</a>|</dd>
                            <dd><a href="/zhengzhuang/dsymg/" title="对声音敏感">对声音敏感</a>|</dd>
                            <dd><a href="/zhengzhuang/fl/" title="乏力">乏力</a></dd></dl></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <!--ends-->
    <div class="extal fl">
        <div class="corop"><span>合作栏目</span>
            <a href="/dx/" title="癫痫治疗方法">癫痫治疗方法</a>
            <a href="/xesz/" title="小儿湿疹">小儿湿疹</a>
            <a href="/sm_6866/" title="治疗失眠">治疗失眠</a>
            <a href="/zx/" title="早泄怎么办">早泄怎么办</a>
            <a href="/jk/" title="甲亢早期症状">甲亢早期症状</a>
        </div>
        <?php echo $this->render("inc_mid_focus",[
                'focus' => $focus
            ]);
        ?>
        <div class="concen"><img src="/images/mocen.png"></div>
        <ul class="symfo">
            <?php
            foreach($focusDisease['最受关注1'] as $k=>$vv){
                $diseaseTitle = $vv['name'];
                $diseaseShortTitle = String::cutString($diseaseTitle, 7, '...');
                $url = Url::to("@jb_domain/{$vv['pinyin_initial']}/");
            ?>
            <li><a href="<?=$url?>" title="<?=$diseaseTitle?>"><?=$diseaseTitle?></a></li>
            <?php
            }
            ?>
        </ul>
        <ul class="cancer">
            <?php
            foreach($focusDisease['最受关注2'] as $k=>$vv){
                $diseaseTitle = $vv['name'];
                $diseaseShortTitle = String::cutString($diseaseTitle, 7, '...');
                $url = Url::to("@jb_domain/{$vv['pinyin_initial']}/");
            ?>
            <li><a href="<?=$url?>" title="<?=$diseaseTitle?>"><?=$diseaseTitle?></a></li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div class="expres fr">
        <div class="conpa">
            <h3 class="dise">疫情播报</h3>
            <?php
            $reportNewTitle = $reportNews['title'];
            $reportNewUrl = $reportNews['url'];
            $reportNewDesciption = $reportNews['desciption'];
            $reportNewShortDesciption = String::cutString($reportNewDesciption, 50, '...');
            ?>
            <h4 class="tosym"><a href="<?=$reportNewUrl?>"><?=$reportNewTitle?></a></h4>
            <p class="virus"><?=$reportNewShortDesciption?><a href="<?=$reportNewUrl?>" title="<?=$reportNewTitle?>">[详细]</a></p>
        </div>
        <div class="conpa cabtop">
            <h3 class="dise">疾病专题</h3>
            <ul class="spsym">
                <?php
                foreach($zhuanti as $k=>$vv){
                    $diseaseTitle = $vv[0];
                    $diseaseShortTitle = String::cutString($diseaseTitle, 7, '...');
                    $url = Url::to($vv[1]);
                ?>
                <li><a href="<?=$url?>" title="<?=$diseaseTitle?>"><?=$diseaseTitle?></a></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!--导航下 第一屏 结束-->