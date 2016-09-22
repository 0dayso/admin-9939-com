<?php
use yii\helpers\Url;

$this->title = $disease['name'] . '专家挂号_权威' . $disease['name'] . '医生、专家_疾病百科_久久健康网';
$this->metaTags['keywords'] = $disease['name'] . '专家挂号,权威' . $disease['name'] . '医生,' . $disease['name'] . '专家';
$this->metaTags['description'] = '久久健康网-疾病百科频道提供专业、全面的' . $disease['name'] . '专家挂号、权威' . $disease['name'] . '医生、' . $disease['name'] . '专家等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
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
            <div class="selected fl"><span>科室：<i>妇产科</i><a href=""></a></span><span>医院：<i>丰台医院北院</i><a href=""></a></span><span>职称：<i>主任医师</i><a href=""></a></span></div></div>
              <div class="one-floor part remed clearfix" style="z-index: 3">
                 <b class="mT10 fl">科室筛选：</b><span class="mT10 cor666 fl">不限</span>
                   <div class="allwords">
                     <div class="part-list  clearfix fl" id="part-list1">
                      <div class="smeo cur_on"><a href="" target="_self">内科</a></div>
                   <div class="smeo"><a href="" target="_self">外科</a></div>
                      <div class="smeo"><a href="" target="_self">儿科</a></div><div class="smeo"><a href="" target="_self">妇产科</a></div>
                      <div class="smeo"><a href="" target="_self">男科</a></div><div class="smeo"><a href="" target="_self">皮肤性病科</a></div>
                      <div class="smeo"><a href="" target="_self">五官科</a></div><div class="smeo"><a href="" target="_self">中医科</a></div>
                      <div class="smeo"><a href="" target="_self">传染科</a></div>
                     <div class="smeo"><a href="" target="_self">肿瘤科</a></div>
                      <div class="smeo"><a href="" target="_self">五官科</a></div><div class="smeo"><a href="" target="_self">中医科</a></div>   
                      <div class="smeo"><a href="" target="_self">儿科</a></div> <div  class="smeo"><a href="" target="_self">五官科</a></div>
                      <div class="smeo"><a href="" target="_self">男科</a></div> <div class="smeo"><a href="" target="_self">皮肤性病科</a></div>
                     <a class="point_more" href="javascript:void(0)" target="_self" title="展开/收起"></a>
                 </div>
                   <div class="clear"></div>
                     
                    </div>
                 </div>
                 <div class="two-floor part remed clearfix" style="z-index:2">
               <b class="mT10 fl">医院筛选：</b><span class="mT10  cor666 fl">不限</span>
              <div class="allwords">
                <div class="part-list clearfix fl" id="part-list2">
                    <div class="smeo cur_on"><a href="" target="_self">丰台医院北院</a></div>
                    <div class="smeo"><a href="" target="_self">中国人民解放军附属医院</a></div>
                    <div class="smeo"><a href="" target="_self">丰台医院北院</a></div><div class="smeo"><a href="" target="_self">中国人民解放军附属医院</a></div><div class="smeo"><a href="" target="_self">中国人民解放军附属医院</a></div><div class="smeo"><a href="" target="_self">中国人民解放军附属医院</a></div><div class="smeo"><a href="" target="_self">中国人民解放军附属医院</a></div><div class="smeo"><a href="" target="_self">中国人民解放军附属医院</a></div><div class="smeo"><a href="" target="_self">中国人民解放军附属医院</a></div>
                    <a class="point_more" href="javascript:void(0)" target="_self" title="展开/收起"></a>
                  </div>
              </div>
               </div>
              <div class="two-floor part remed clearfix" style="z-index:2; border-bottom:none;">
               <b class="mT10 fl">医生职称：</b><span class="mT10  cor666 fl">不限</span>
              <div class="allwords">
                <div class="part-list clearfix fl" id="part-list2">
                    <div class="smeo cur_on"><a href="" target="_self">主任医师</a></div>
                    <div class="smeo"><a href="" target="_self">副主任医师</a></div>
                    <div class="smeo"><a href="" target="_self">主治医师</a></div>
                  </div>
              </div>
               </div>
                 
               
      </div>
      <div class="rank"><a>综合</a>共找到<span>118</span>种药品</div>
    <!--静态数据-->
    <ul class="exnic">
        <li><div class="hos_01 fl"><a href="http://ask.9939.com/Asking/index/"><img src="/images/doj_01.jpg" alt="" title=""></a></div><div class="hos_02 fl"><h3><a href="http://ask.9939.com/Asking/index/">王强</a><span>主任医师</span></h3><p><span>上海远大心胸医院</span>胸外科</p><p class="hlas">擅长：漏斗胸、手汗症、岩棉潮红、肺大疱、肺癌等胸腔镜下微创治疗。</p></div><div class="hos_03 fl"><a href="" class="num_04">在线问诊</a><a href="" class="num_01">挂号预约</a><a href="" class="num_02">加号预约</a><a href="" class="num_03">电话咨询</a></div></li>
        <li><div class="hos_01 fl"><a href="http://ask.9939.com/Asking/index/"><img src="/images/doj_02.jpg" alt="" title=""></a></div><div class="hos_02 fl"><h3><a href="http://ask.9939.com/Asking/index/">倪幼方</a><span>主任医师</span></h3><p><span>上海远大心胸医院</span>心内科</p><p class="hlas">擅长：各种心血管疾病的诊断和治疗，对心绞痛、心律失常、心力衰竭的药物治疗有较深入研究，尤其在冠心病的诊断治疗方案的判定、药物治疗的个体方案制定及介入治疗和心脏外科手术前后的处理等方面具有丰富的临床经验。</p></div><div class="hos_03 hos_04 fl"><a href="" class="num_04">在线问诊</a><a href="" class="num_01">挂号预约</a><a href="" class="num_02">加号预约</a><a href="" class="num_03">电话咨询</a></div></li>
        <li><div class="hos_01 fl"><a href="http://ask.9939.com/Asking/index/"><img src="/images/doj_03.jpg" alt="" title=""></a></div><div class="hos_02 fl"><h3><a href="http://ask.9939.com/Asking/index/">程云阁</a><span>主任医师</span></h3><p><span>上海远大心胸医院</span>腔镜心脏科</p><p class="hlas">擅长：胸腔镜下微创治疗各种心血管疾病，包括胸腔镜下心脏瓣膜病微创治疗、胸腔镜下房颤迷宫手术、胸腔镜下房缺修补术、胸腔镜下室缺修补术、3D胸腔镜下微创治疗心脏病等。</p></div><div class="hos_03 fl"><a href="" class="num_04">在线问诊</a><a href="" class="num_01">挂号预约</a><a href="" class="num_02">加号预约</a><a href="" class="num_03">电话咨询</a></div></li>
        <li><div class="hos_01 fl"><a ><img src="/images/doj_04.jpg" alt="" title=""></a></div><div class="hos_02 fl"><h3><a>肖明第</a><span>主任医师</span></h3><p><span>上海远大心胸医院</span>心外科</p><p class="hlas">擅长冠心病、瓣膜病、先天性心脏病、大血管和心脏移植，是我国冠脉外科奠基人之一。</p></div><div class="hos_03 fl"><a href="" class="num_04">在线问诊</a><a href="" class="num_01">挂号预约</a><a href="" class="num_02">加号预约</a><a href="" class="num_03">电话咨询</a></div></li>
        <li><div class="hos_01 fl"><a href="http://yisheng.9939.com/doc/272321.shtml"><img src="/images/doj_05.jpg" alt="" title=""></a></div><div class="hos_02 fl"><h3><a href="http://yisheng.9939.com/doc/272321.shtml">高尚风</a><span>主任医师</span></h3><p><span>西安交通大学医学院第一附属医院</span>妇科</p><p class="hlas">擅长：妇科肿瘤、妇科疑难杂症、妇产科微创治疗（如宫腔镜）</p></div><div class="hos_03 fl"><a href="" class="num_04">在线问诊</a><a href="" class="num_01">挂号预约</a><a href="" class="num_02">加号预约</a><a href="" class="num_03">电话咨询</a></div></li>
        <li><div class="hos_01 fl"><a href="http://yisheng.9939.com/doc/272209.shtml"><img src="/images/doj_06.jpg" alt="" title=""></a></div><div class="hos_02 fl"><h3><a href="http://yisheng.9939.com/doc/272209.shtml">丁樱</a><span>主任医师</span></h3><p><span>河南中医学院第一附属医院</span>急诊科</p><p class="hlas">擅长：中西医结合治疗过敏性紫癜及紫癜性肾炎、难治性肾病、狼疮、乙肝肾、IgA肾病、血尿、蛋白尿、遗尿及类风湿病等小儿常见病及多种疑难病的诊疗经验丰富。</p></div><div class="hos_03 fl"><a href="" class="num_04">在线问诊</a><a href="" class="num_01">挂号预约</a><a href="" class="num_02">加号预约</a><a href="" class="num_03">电话咨询</a></div></li>
        <li><div class="hos_01 fl"><a href="http://yisheng.9939.com/doc/272320.shtml"><img src="/images/doj_07.jpg" alt="" title=""></a></div><div class="hos_02 fl"><h3><a href="http://yisheng.9939.com/doc/272320.shtml">王锦玲</a><span>主任医师</span></h3><p><span>第四军医大学第一附属医院</span>耳鼻咽喉科</p><p class="hlas">擅长：专业特长为临床聋病的诊治及致聋机理和防治研究；面神经疾病的诊治及面神经损伤、再生和调控机制研究；前庭疾病眩晕的诊治及前庭毛细胞损伤修复和代偿机理研究；以及本专科疑难病诊治。</p></div><div class="hos_03 fl"><a href="" class="num_04">在线问诊</a><a href="" class="num_01">挂号预约</a><a href="" class="num_02">加号预约</a><a href="" class="num_03">电话咨询</a></div></li>
        <li><div class="hos_01 fl"><a href="http://yisheng.9939.com/doc/272095.shtml"><img src="/images/doj_10.jpg" alt="" title=""></a></div><div class="hos_02 fl"><h3><a href="http://yisheng.9939.com/doc/272095.shtml">姚斌</a><span>副主任医师</span></h3><p><span>南昌大学上饶医院</span>急诊科</p><p class="hlas">擅长擅长于西医骨科及脑外科</p></div><div class="hos_03 fl"><a href="" class="num_04">在线问诊</a><a href="" class="num_01">挂号预约</a><a href="" class="num_02">加号预约</a><a href="" class="num_03">电话咨询</a></div></li>
        <li><div class="hos_01 fl"><a href="http://yisheng.9939.com/doc/272316.shtml"><img src="/images/doj_08.jpg" alt="" title=""></a></div><div class="hos_02 fl"><h3><a href="http://yisheng.9939.com/doc/272316.shtml">吴桂清</a><span>主任医师</span></h3><p><span>陕西省人民医院</span>急诊科</p><p class="hlas">擅长：妊娠期糖尿病筛查、胰岛素个体化治疗；妊娠期肝病、指导母婴乙肝阻断方式；早发型妊娠期高血压疾病延长孕周治疗；前置胎盘,瘢痕子宫,凶险性前置胎盘复杂性产科手术。</p></div><div class="hos_03 fl"><a href="" class="num_04">在线问诊</a><a href="" class="num_01">挂号预约</a><a href="" class="num_02">加号预约</a><a href="" class="num_03">电话咨询</a></div></li>
        <li><div class="hos_01 fl"><a href="http://yisheng.9939.com/doc/47029.shtml"><img src="/images/doj_09.jpg" alt="" title=""></a></div><div class="hos_02 fl"><h3><a href="http://yisheng.9939.com/doc/47029.shtml">刘洪臣</a><span>主任医师</span></h3><p><span>解放军总医院</span>口腔科</p><p class="hlas">擅长：牙体保存、人工种植牙修复，牙列缺损与缺失口腔颌面部缺损修复、颞下颌关节紊乱病矫治和老年口腔病防治。</p></div><div class="hos_03 fl"><a href="" class="num_04">在线问诊</a><a href="" class="num_01">挂号预约</a><a href="" class="num_02">加号预约</a><a href="" class="num_03">电话咨询</a></div></li>
    </ul>
    <!--静态数据-->
    
    <!--<div class="paget paint"><a href="">首页</a><a href=""><<</a><a href="" class="cust">1</a><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a><span>...</span><a href="">10</a><a href="">>></a><input type="text" placeholder="10"><a href="">跳转</a><a href="">尾页</a></div>-->
     
    <!--猜你感兴趣-->
    <div class="rela_a a_labe">
        <div class="a_rea a_hop a_mar">
            <h2><b>猜你感兴趣</b></h2>
            <div class="aplces">
                <?php echo $this->render('/ads/common/ads_interest'); ?>
            </div>
        </div>
    </div>
    <!--猜你感兴趣-->
    
  </div>
    <!--右侧-->
    <?php
    echo $this->render('index_right');
    ?>
    <!--右侧-->
 
</div>

