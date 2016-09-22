<?php

use yii\helpers\Url;

$this->title = $disease['name'] . '医院哪家好_' . $disease['name'] . '治疗哪里好_' . $disease['name'] . '医院_疾病百科_久久健康网';
$this->metaTags['keywords'] = $disease['name'] . '医院哪家好,' . $disease['name'] . '治疗哪里好,' . $disease['name'] . '医院';
$this->metaTags['description'] = '久久健康网-疾病百科频道提供专业、全面的' . $disease['name'] . '医院哪家好、' . $disease['name'] . '治疗哪里好、' . $disease['name'] . '病医院等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
?>
<?php
echo $this->render('index_nav', [
    'disease' => $disease,
]);
?>    


<div class="art_wra" style="margin:0 auto;">
    <div class="art_l">
        <div class="lopag seedoc clearfix"><div class="choar fl"><span>河北</span><span>石家庄</span></div><div class="sepla fl">切换地区</div><div class="city disnon"><p><img src="/images/choe.gif">热门：<a>北京</a><a>上海</a><a>广州</a><a>杭州</a></p><dl><dt>请选择省份：</dt>
                    <dd><a>北京</a><a>上海</a><a>广东</a><a>江苏</a><a>湖南</a><a>山西</a></dd>
                    <dd><a>山东</a><a>湖北</a><a>浙江</a><a>天津</a><a>陕西</a><a>安徽</a></dd>
                    <dd><a>河南</a><a>四川</a><a>青海</a><a>辽宁</a><a>内蒙古</a><a>江西</a></dd>
                    <dd><a>黑龙江</a><a>河北</a><a>云南</a><a>吉林</a><a>贵州</a><a>广西</a></dd>
                    <dd><a>重庆</a><a>宁夏</a><a>甘肃</a><a>福建</a><a>海南</a><a>新疆</a></dd></dd></dl></div>
            <!--省市-->
            <div class="city disnon"><p><img src="/images/choe.gif">热门：<a>北京</a><a>上海</a><a>广州</a><a>杭州</a></p><dl><dt><b>返回重选省份</b>您当前选择省份：<span>河北</span></dt>
                    <dd><a>不限</a><a>石家庄</a><a>唐山</a><a>秦皇岛</a><a>邯郸</a><a>邢台邢台</a></dd>
                    <dd><a>保定</a><a>张家口</a><a>承德</a><a>沧州</a><a>廊坊</a><a>衡水</a></dd></dl></div>
            <a href="" class="guid">就诊指南</a>
        </div>
        <div class="filtrate resetsy" id="cond">
            <div class="condition recodit clearfix"><a href="" class="chose fr cor666">重置筛选条件</a><b class="nostle cor666 fl">您已选择：</b>
                <div class="selected fl"><span>等级：<i>二级医院</i><a href=""></a></span><span>类型：<i>综合医院</i><a href=""></a></span></div></div>
            <div class="one-floor part remed clearfix" style="z-index: 3">
                <b class="mT10 fl">医院等级：</b><span class="mT10 cor666 fl">不限</span>
                <div class="allwords">
                    <div class="part-list  clearfix fl" id="part-list1">
                        <div class="smeo cur_on"><a href="" target="_self">三级甲等</a></div>
                        <div class="smeo"><a href="" target="_self">三级医院</a></div>
                        <div class="smeo"><a href="" target="_self">二级医院</a></div><div class="smeo"><a href="" target="_self">一级医院</a></div>
                    </div>
                    <div class="clear"></div>

                </div>
            </div>
            <div class="two-floor part remed clearfix" style="z-index:2; border-bottom:none;">
                <b class="mT10 fl">医院类型：</b><span class="mT10  cor666 fl">不限</span>
                <div class="allwords">
                    <div class="part-list clearfix fl" id="part-list2">
                        <div class="smeo cur_on"><a href="" target="_self">综合医院</a></div>
                        <div class="smeo"><a href="" target="_self">眼科医院</a></div>
                        <div class="smeo"><a href="" target="_self">儿童医院</a></div><div class="smeo"><a href="" target="_self">妇产科医院</a></div><div class="smeo"><a href="" target="_self">肿瘤医院</a></div><div class="smeo"><a href="" target="_self">耳鼻喉科医院</a></div><div class="smeo"><a href="" target="_self">耳鼻喉科医院</a></div><div class="smeo"><a href="" target="_self">耳鼻喉科医院</a></div><div class="smeo"><a href="" target="_self">耳鼻喉科医院</a></div><div class="smeo"><a href="" target="_self">耳鼻喉科医院</a></div><div class="smeo"><a href="" target="_self">耳鼻喉科医院</a></div>
                        <a class="point_more" href="javascript:void(0)" target="_self" title="展开/收起"></a>
                    </div>
                </div>
            </div>

        </div>
        <div class="rank"><a>综合</a>共找到<span>118</span>种药品</div>
        <!--静态数据-->
        <ul class="hanpo">
            <li><div class="hace_01 fl"><a href="http://hospital.9939.com/hosp/272446/index.shtml"><img src="/images/bjx_01.jpg" alt="" title=""></a></div><div class="hace_02 fl"><h3><a href="http://hospital.9939.com/hosp/272446/index.shtml">北京协和医院（东院区）</a><span><a href="" class="han_01">挂号</a><a href="" class="han_02">加号</a></span></h3><p class="addr_01">三级甲等/综合医院</p><p class="addr_02">北京协和医院地址共有两个，分为东院和西院，协和医院东院位于北京市东城区帅府园1号</p></div><div class="hace_03 fl"><p>推荐医生<span>1100</span>位</p><p>累计<span>1052</span>次预约</p></div></li>
            <li><div class="hace_01 fl"><a href="http://hospital.9939.com/hosp/19925/index.shtml"><img src="/images/bjx_02.jpg" alt="" title=""></a></div><div class="hace_02 hagr fl"><h3><a href="http://hospital.9939.com/hosp/19925/index.shtml">北京大学人民医院（西直门院区）</a><span><a href="" class="han_01">挂号</a><a href="" class="han_02">加号</a></span></h3><p class="addr_01">三级甲等/综合医院</p><p class="addr_02">北京市西城区西直门南大街11号</p></div><div class="hace_03 fl"><p>推荐医生<span>1028</span>位</p><p>累计<span>1044</span>次预约</p></div></li>
            <li><div class="hace_01 fl"><a href="http://hospital.9939.com/hosp/20461/index.shtml"><img src="/images/bjx_03.jpg" alt="" title=""></a></div><div class="hace_02 fl"><h3><a href="http://hospital.9939.com/hosp/20461/index.shtml">北京仁和医院</a><span><a href="" class="han_01">挂号</a><a href="" class="han_02">加号</a></span></h3><p class="addr_01">二级甲等/综合医院</p><p class="addr_02">北京市大兴区兴丰大街1号</p></div><div class="hace_03 fl"><p>推荐医生<span>1007</span>位</p><p>累计<span>993</span>次预约</p></div></li>
            <li><div class="hace_01 fl"><a href="http://hospital.9939.com/hosp/20362/index.shtml"><img src="/images/bjx_04.jpg" alt="" title=""></a></div><div class="hace_02 fl"><h3><a href="http://hospital.9939.com/hosp/20362/index.shtml">武警总医院</a><span><a href="" class="han_01">挂号</a><a href="" class="han_02">加号</a></span></h3><p class="addr_01">三级甲等/综合医院</p><p class="addr_02">北京市海淀区永定路69号</p></div><div class="hace_03 fl"><p>推荐医生<span>976</span>位</p><p>累计<span>721</span>次预约</p></div></li>
            <li><div class="hace_01 fl"><a href="http://hospital.9939.com/hosp/19879/index.shtml"><img src="/images/bjx_05.jpg" alt="" title=""></a></div><div class="hace_02 fl"><h3><a href="http://hospital.9939.com/hosp/19879/index.shtml">武警北京市总队第二医院</a><span><a href="" class="han_01">挂号</a><a href="" class="han_02">加号</a></span></h3><p class="addr_01">三级甲等/综合医院</p><p class="addr_02">北京市西城区月坛北街丁3号</p></div><div class="hace_03 fl"><p>推荐医生<span>914</span>位</p><p>累计<span>708</span>次预约</p></div></li>
            <li><div class="hace_01 fl"><a href="http://hospital.9939.com/hosp/19931/index.shtml"><img src="/images/bjx_06.jpg" alt="" title=""></a></div><div class="hace_02 fl"><h3><a href="http://hospital.9939.com/hosp/19931/index.shtml">北京市肛肠医院</a><span><a href="" class="han_01">挂号</a><a href="" class="han_02">加号</a></span></h3><p class="addr_01">二级甲等/综合医院</p><p class="addr_02">北京市西城区德外大街16号</p></div><div class="hace_03 fl"><p>推荐医生<span>835</span>位</p><p>累计<span>629</span>次预约</p></div></li>
            <li><div class="hace_01 fl"><a href="http://hospital.9939.com/hosp/20425/index.shtml"><img src="/images/bjx_07.jpg" alt="" title=""></a></div><div class="hace_02 fl"><h3><a href="http://hospital.9939.com/hosp/20425/index.shtml">北京回龙观医院</a><span><a href="" class="han_01">挂号</a><a href="" class="han_02">加号</a></span></h3><p class="addr_01">三级甲等/综合医院</p><p class="addr_02">北京昌平回龙观镇派出所对面，万润家园东侧</p></div><div class="hace_03 fl"><p>推荐医生<span>794</span>位</p><p>累计<span>352</span>次预约</p></div></li>
            <li><div class="hace_01 fl"><a href="http://hospital.9939.com/hosp/20430/index.shtml"><img src="/images/bjx_08.jpg" alt="" title=""></a></div><div class="hace_02 fl"><h3><a href="http://hospital.9939.com/hosp/20430/index.shtml">北京民康医院</a><span><a href="" class="han_01">挂号</a><a href="" class="han_02">加号</a></span></h3><p class="addr_01">二级甲等/综合医院</p><p class="addr_02">沙河镇民园小区</p></div><div class="hace_03 fl"><p>推荐医生<span>561</span>位</p><p>累计<span>287</span>次预约</p></div></li>
            <li><div class="hace_01 fl"><a href="http://hospital.9939.com/hosp/20413/index.shtml"><img src="/images/bjx_09.jpg" alt="" title=""></a></div><div class="hace_02 fl"><h3><a href="http://hospital.9939.com/hosp/20413/index.shtml">北京市顺义区医院</a><span><a href="" class="han_01">挂号</a><a href="" class="han_02">加号</a></span></h3><p class="addr_01">二级甲等/综合医院</p><p class="addr_02">北京市顺义区近郊光明南街3号</p></div><div class="hace_03 fl"><p>推荐医生<span>493</span>位</p><p>累计<span>197</span>次预约</p></div></li>
            <li><div class="hace_01 fl"><a href="http://hospital.9939.com/hosp/20385/index.shtml"><img src="/images/bjx_10.jpg" alt="" title=""></a></div><div class="hace_02 fl"><h3><a href="http://hospital.9939.com/hosp/20385/index.shtml">北京市房山区第一医院</a><span><a href="" class="han_01">挂号</a><a href="" class="han_02">加号</a></span></h3><p class="addr_01">二级甲等/综合医院</p><p class="addr_02">北京市房山区房窑路6号</p></div><div class="hace_03 fl"><p>推荐医生<span>392</span>位</p><p>累计<span>53</span>次预约</p></div></li>
        </ul>
        <!--静态数据-->


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

