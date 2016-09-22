<?php

use yii\helpers\Url;

$this->title = $disease['name'] . '用药_' . $disease['name'] . '吃什么药好_' . $disease['name'] . '用药禁忌_疾病百科_久久健康网';
$this->metaTags['keywords'] = $disease['name'] . '用药,' . $disease['name'] . '吃什么药好,' . $disease['name'] . '用药禁忌';
$this->metaTags['description'] = '久久健康网-疾病百科频道提供专业、全面的' . $disease['name'] . '用药、' . $disease['name'] . '吃什么药好、' . $disease['name'] . '用药禁忌等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
?>

<?php
echo $this->render('index_nav', [
    'disease' => $disease,
    ]);
?>

<div class="art_wra" style="margin:0 auto;">
    <div class="art_l">
        <div class="filtrate resetsy" id="cond">
            <div class="condition recodit clearfix"><a href="" class="chose fr cor666">重置筛选条件</a><b class="nostle cor666 fl">筛选条件：</b>
                <div class="selected fl"><span>品牌：<i>益佰</i><a href=""></a></span><span>医保：<i>非医保</i><a href=""></a></span><span>处方：<i>非处方</i><a href=""></a></span><span>类型：<i>中药</i><a href=""></a></span></div></div>
            <div class="one-floor part remed clearfix" style="z-index: 3">
                <b class="mT10 fl">药品品牌：</b><span class="mT10 cor666 fl">不限</span>
                <div class="allwords">
                    <div class="part-list  clearfix fl" id="part-list1">
                        <div class="smeo cur_on"><a href="" target="_self">益佰</a></div>
                        <div class="smeo"><a href="" target="_self">同仁堂</a></div>
                        <div class="smeo"><a href="" target="_self">同仁堂</a></div><div class="smeo"><a href="" target="_self">同仁堂</a></div>
                        <div class="smeo"><a href="" target="_self">康德平同仁堂</a></div><div class="smeo"><a href="" target="_self">同仁堂</a></div>
                        <div class="smeo"><a href="" target="_self">益佰</a></div><div class="smeo"><a href="" target="_self">同仁堂</a></div>
                        <div class="smeo"><a href="" target="_self">益佰</a></div>
                        <div class="smeo"><a href="" target="_self">益佰</a></div>
                        <div class="smeo"><a href="" target="_self">益佰</a></div><div class="smeo"><a href="" target="_self">益佰</a></div>   
                        <div class="smeo"><a href="" target="_self">益佰</a></div> <div  class="smeo"><a href="" target="_self">益佰</a></div>
                        <div class="smeo"><a href="" target="_self">康德平同仁堂</a></div> <div class="smeo"><a href="" target="_self">同仁堂</a></div>
                        <a class="point_more" href="javascript:void(0)" target="_self" title="展开/收起"></a>
                    </div>
                    <div class="clear"></div>

                </div>
            </div>
            <div class="two-floor part remed clearfix" style="z-index:2">
                <b class="mT10 fl">是否医保：</b><span class="mT10  cor666 fl">不限</span>
                <div class="allwords">
                    <div class="part-list clearfix fl" id="part-list2">
                        <div class="smeo cur_on"><a href="" target="_self">医保</a></div>
                        <div class="smeo"><a href="" target="_self">非医保</a></div>

                    </div>
                </div>
            </div>
            <div class="two-floor part remed clearfix" style="z-index:2">
                <b class="mT10 fl">是否处方：</b><span class="mT10  cor666 fl">不限</span>
                <div class="allwords">
                    <div class="part-list clearfix fl" id="part-list2">
                        <div class="smeo cur_on"><a href="" target="_self">处方</a></div>
                        <div class="smeo"><a href="" target="_self">非处方</a></div>

                    </div>
                </div>
            </div>
            <div class="two-floor part remed clearfix" style="z-index:2; border-bottom:none;">
                <b class="mT10 fl">药品类型：</b><span class="mT10  cor666 fl">不限</span>
                <div class="allwords">
                    <div class="part-list clearfix fl" id="part-list2">
                        <div class="smeo cur_on"><a href="" target="_self">中药</a></div>
                        <div class="smeo"><a href="" target="_self">西药</a></div><div  class="smeo"><a href="" target="_self">中成药</a></div>

                    </div>
                </div>
            </div>  

        </div>

        <div class="rank"><a>综合</a>共找到<span>118</span>种药品</div>

        <!-- 静态内容 start-->
        <div class="drugb"><div><img src="/images/bus.jpg"><h4>暂无</h4><p>药品内容正在路上~</p></div></div>
<!--        <ul class="drupro">
            <li><a href="http://yiyao.9939.com/zhfl/200812/8993.shtml"><img src="/images/nvj_01.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/8993.shtml">女金丸</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">益气养血，理气活血，止痛。本品用于气血两虚、气滞血瘀所致的月经不调，症见月经提前、月经错后、月经量多、神疲乏力、行经腹痛。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">北京同仁堂股份有限公司同仁堂制药厂</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/200812/3602.shtml"><img src="/images/nvj_02.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/3602.shtml">妇女痛经丸</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">活血，调经，止痛。用于气血凝滞，小腹胀疼，经期腹痛。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">北京同仁堂科技发展股份有限公司制药厂</p></div></div></li>
            <li><a href="http://yiyao.9939.com/bjp/200812/13926.shtml"><img src="/images/nvj_03.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/bjp/200812/13926.shtml">昂立1号R优菌多颗粒（女士型）</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">调节肠道菌群、改善皮肤水份</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">上海交大昂立股份有限公司</p></div></div></li>
            <li><a href="http://yiyao.9939.com/bjp/200812/14473.shtml"><img src="/images/nvj_04.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/bjp/200812/14473.shtml">汤臣倍健牌多种维生素片（男士）</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">均衡补充男性所需的多种维生素、矿物质。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">广东汤臣倍健生物科技股份有限公司</p></div></div></li>
            <li><a href="http://yiyao.9939.com/bjp/200812/14084.shtml"><img src="/images/nvj_05.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/bjp/200812/14084.shtml">黄金搭档牌多种维生素片(男士型)</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">补充多种维生素及矿物质</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">无锡健特药业有限公司 上海黄金搭档生物科技有限公司无锡分公司</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/200812/3359.shtml"><img src="/images/nvj_06.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/3359.shtml">儿童清肺口服液</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">用于面赤身热，咳嗽，痰多，咽痛。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">北京同仁堂股份有限公司同仁堂制药厂</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/200812/9287.shtml"><img src="/images/nvj_07.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/9287.shtml">儿宝膏</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">用于小儿面黄体弱，纳呆厌食、脾虚久泻，精神不振，口干燥渴，盗汗。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">宁波四明制药有限公司</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/200812/10064.shtml"><img src="/images/nvj_08.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/10064.shtml">儿感清口服液</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">解表清热，宣肺化痰。用于小儿外感风寒、肺胃蕴热证，症见：发热恶寒，鼻塞流涕，咳嗽有痰，咽喉肿痛，口渴。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">北京同仁堂股份有限公司同仁堂制药厂</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/201009/20944.shtml"><img src="/images/nvj_09.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/201009/20944.shtml">百夜星</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">本品适用于敏感细菌引起的轻中度感染：包括下呼吸道感染：慢性支气管炎急性发作,支气管扩张伴感染, 急性支气管炎,肺炎等。腹腔胆道, 肠道，伤寒等感染，皮肤软组织感染,其它感染：如副鼻窦炎，中耳炎，眼睑炎。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">赤峰维康生化制药有限公司</p></div></div></li>
            <li><a href="http://yiyao.9939.com/zhfl/200812/9377.shtml"><img src="/images/nvj_10.jpg" alt="" title=""></a><h3><a href="http://yiyao.9939.com/zhfl/200812/9377.shtml">二十六味通经散</a><span>保</span></h3><div class="func"><div class="fun_01 fl"><p class="fico"><span>[功能主治]</span></p><p class="fico_02">止血散瘀，调经活血。用于“木布病”引起的胃肠溃疡出血、肝血增盛、胸背疼痛、月经不调、闭经以及经血逆行引起的小腹胀满疼痛，血瘀症瘕。</p></div><div class="fun_02 fl"><p class="fico"><span>[生产厂商]</span></p><p class="fico_02">西藏雄巴拉曲神水藏药厂</p></div></div></li>
        </ul>-->
        <!-- 静态内容 end-->

<!--<div class="paget paint"><a href="">首页</a><a href=""><<</a><a href="" class="cust">1</a><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a><span>...</span><a href="">10</a><a href="">>></a><input type="text" placeholder="10"><a href="">跳转</a><a href="">尾页</a></div>-->

        <!-- 猜你感兴趣 start-->
        <div class="rela_a a_labe">
            <div class="a_rea a_hop a_mar">
                <h2><b>猜你感兴趣</b></h2>
                <div class="aplces">
                    <?php echo $this->render('/ads/common/ads_interest'); ?>
                </div>
            </div>
        </div>
        <!-- 猜你感兴趣 end-->

    </div>
    <!--右侧-->
    <?php
    echo $this->render('index_right');
    ?>
    <!--右侧-->

</div>

<script type="text/javascript">
    window.onload = function ()
    {
        var tag = document.getElementById("catetab").children
        var content = document.getElementById("tagContent").children
        content[0].style.display = "block";
        var len = tag.length;
        for (var i = 0; i < len; i++)
        {
            tag[i].index = i;
            tag[i].onclick = function ()
            {
                for (var n = 0; n < len; n++)
                {
                    tag[n].className = "";
                    content[n].style.display = "none";
                }   //首先将全部的div隐藏
                tag[this.index].className = "current";
                content[this.index].style.display = "block";
            }
        }

    }
</script>


