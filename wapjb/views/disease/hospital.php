<?php

use yii\helpers\Url;

$this->title = $disease['name'] . '医院哪家好_' . $disease['name'] . '治疗哪里好_' . $disease['name'] . '医院_疾病百科_久久健康网';
$this->params['keywords'] = $disease['name'] . '医院哪家好,' . $disease['name'] . '治疗哪里好,' . $disease['name'] . '医院';
$this->params['description'] = '久久健康网-疾病百科频道提供专业、全面的' . $disease['name'] . '医院哪家好、' . $disease['name'] . '治疗哪里好、' . $disease['name'] . '病医院等疾病百科知识、查询疾病方便、快捷、深受网民喜爱！';
$this->params['name'] = $disease['name'];
?>
<?php echo $this->render('inc_nav', ['pinyin_initial' => $disease['pinyin_initial']]); ?>
<ul class="stati fihost">
    <li><a href="javascript:;"><img src="/images/bjx_01.jpg" alt=""></a><div><h3><a href="javascript:;">北京协和医院（东院区）</a></h3><p>三级甲等/综合医院</p><p>预约量<span>1052次</span></p></div><em></em></li>
    <li><a href="javascript:;"><img src="/images/bjx_02.jpg" alt=""></a><div><h3><a href="javascript:;">北京市仁和医院</a></h3><p>二级甲等/综合医院</p><p>预约量<span>1044次</span></p></div><em></em></li>
    <li><a href="javascript:;"><img src="/images/bjx_03.jpg" alt=""></a><div><h3><a href="javascript:;">武警北京市总队第二医院</a></h3><p>三级甲等/综合医院</p><p>预约量<span>993次</span></p></div><em></em></li>
    <li><a href="javascript:;"><img src="/images/bjx_04.jpg" alt=""></a><div><h3><a href="javascript:;">北京大学人民医院（西直门院区）</a></h3><p>三级甲等/综合医院</p><p>预约量<span>721次</span></p></div><em></em></li>
    <li><a href="javascript:;"><img src="/images/bjx_05.jpg" alt=""></a><div><h3><a href="javascript:;">北京市肛肠医院</a></h3><p>二级甲等/综合医院</p><p>预约量<span>708次</span></p></div><em></em></li>
    <li><a href="javascript:;"><img src="/images/bjx_06.jpg" alt=""></a><div><h3><a href="javascript:;">武警总医院</a></h3><p>三级甲等/综合医院</p><p>预约量<span>629次</span></p></div><em></em></li>
    <li><a href="javascript:;"><img src="/images/bjx_07.jpg" alt=""></a><div><h3><a href="javascript:;">北京回龙观医院</a></h3><p>三级甲等/综合医院</p><p>预约量<span>352次</span></p></div><em></em></li>
    <li><a href="javascript:;"><img src="/images/bjx_08.jpg" alt=""></a><div><h3><a href="javascript:;">北京民康医院</a></h3><p>二级甲等/综合医院</p><p>预约量<span>287次</span></p></div><em></em></li>
    <li><a href="javascript:;"><img src="/images/bjx_09.jpg" alt=""></a><div><h3><a href="javascript:;">北京市顺义区医院</a></h3><p>二级甲等/综合医院</p><p>预约量<span>197次</span></p></div><em></em></li>
    <li><a href="javascript:;"><img src="/images/bjx_10.jpg" alt=""></a><div><h3><a href="javascript:;">北京市房山区第一医院</a></h3><p>二级甲等/综合医院</p><p>预约量<span>53次</span></p></div><em></em></li>
</ul>

<!--<article class="metho charea fincou"><a href="http://www.baidu.com/"><b>全国</b><span></span></a><a><b>医院等级</b><span></span></a><a><b>医院类型</b><span></span></a></article>
<div class="oubra disn"></div>
<div class="nolim">
    <div class="brand"></div>
    <div class="brand disn"><a>不限</a><a>三级甲等</a><a>三级医院</a><a>二级医院</a><a>一级医院</a></div>
    <div class="brand disn"><a>不限</a><a>综合医院</a><a>眼科医院</a><a>儿童医院</a><a>综合医院</a><a>眼科医院</a><a>儿童医院</a></div>
</div>-->