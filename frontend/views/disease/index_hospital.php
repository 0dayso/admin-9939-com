
<!-- 医院部分 -->

<div class="tost nickn reart eypa tocun">
    <h2 class="unkno">
        <div class="clmor">
            <!--<a href="">全国</a><a href="">广东</a><a href="">北京</a><a href="">上海</a><a class="mopla">更多地区</a>|-->
            <a href="http://hospital.9939.com/">更多>></a>
        </div>
        <span><?php echo $name; ?></span> 医院<b>直通2000多家知名医院！</b></h2>


    <div class="palce">
        <div class="provin">
            <!--<div class="hodor">
                <p>
                    <img src="/images/choe.gif">
                    <b>热门：</b><a>北京</a><a>上海</a><a>广州</a><a>杭州</a>
                </p>
                <dl>
                    <dt>请选择省份：</dt>
                    <dd><a>北京</a><a>上海</a><a>广东</a><a>江苏</a><a>湖南</a><a>山西</a></dd>
                    <dd><a>山东</a><a>湖北</a><a>浙江</a><a>天津</a><a>陕西</a><a>安徽</a></dd>
                    <dd><a>河南</a><a>四川</a><a>青海</a><a>辽宁</a><a>内蒙古</a><a>江西</a></dd>
                    <dd><a>黑龙江</a><a>河北</a><a>云南</a><a>吉林</a><a>贵州</a><a>广西</a></dd>
                    <dd><a>重庆</a><a>宁夏</a><a>甘肃</a><a>福建</a><a>海南</a><a>新疆</a></dd>
                    </dd></dl>
            </div>-->
        </div>
    </div>
</div>

<ul class="hospti">
    <?php
    require 'index_hospital_data.php';
    $randArr = [];
    while (count($randArr) != 6){
        $index = rand(0, 9);
        if (!in_array($index, $randArr)){
            $randArr[] = $index;
            echo $hospitals[$index];
        }
    }
    ?>
</ul>