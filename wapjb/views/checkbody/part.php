<?php
use yii\helpers\Url;
use librarys\helpers\utils\String;


?>
<?php
//print_r($model['allPartLevel2']);
//exit;
switch ($model['type']){
        //根据全部症状查询
        case 'lv2Part':
            foreach($model['allPartLevel2'] as $v){
    ?>
    <li><a href="javascript:void(0);" onclick="showSymptoms(this)" target="_self" data-partid='<?=$v['id']?>' title="<?=$v['name']?>"><?=$v['name']?></a></li>
    <?php
            }
        break;
    ?>
    
    
    
    
    <?php
        //根据二级部位展示症状
        case 'symptom':
            if(!empty($model['allSymptoms'])){
                foreach($model['allSymptoms'] as $v){
    ?>
    <a href="javascript:void(0);" onclick="showDisease('/zicha/jbzc_jg/?symptomid=<?=$v['id']?>')" target="_self" data-symptomid='<?=$v['id']?>' title="<?=$v['name']?>"><?=$v['name']?></a>
    <?php
                }
            }else{
                echo '<a href="javascript:void(0);">无记录</a>';
            }
        break;
    ?>
    
    
    
    
    <?php
        //根据选择的症状筛选出相关的疾病
        case 'disease':
//            print_r($model['disease']);
//            exit;
            echo '    	<ul class="ache">';
            foreach($model['disease'] as $vv){
                foreach($vv as $v){
                    if($v){
    ?>
    <li>
        <h3>
            <b class="ac_01">病</b>
            <p>
                <a href="/<?=$v['pinyin_initial']?>/jianjie/" target="_blank"><?=$v['name']?></a>
                <span>（别名：<?=$v['alias']?>）</span>
            </p>
        </h3>
        <div class="simg">
            <?php
            if(isset($v['img'])){
                $img = $v['img']['name'];
            }else{
                $img = '/images/ache.jpg';
            }
            ?>
            <a href="/<?=$v['pinyin_initial']?>/" title="<?=$v['name']?>"><img src="<?=$img?>" alt="<?=$v['name']?>"></a>
            <p>
                <?=String::cutString($v['description'], 45, '...')?>
                <a href="/<?=$v['pinyin_initial']?>/jianjie/"><span>...</span>查看更多</a>
            </p>
        </div>
        <div class="sprea">
            <a href="/<?=$v['pinyin_initial']?>/by/">病因</a>
            <a href="/<?=$v['pinyin_initial']?>/zz/">症状</a>
            <a href="/<?=$v['pinyin_initial']?>/lcjc/">检查</a>
            <a href="/<?=$v['pinyin_initial']?>/zl/">治疗</a>
        </div>
    </li>
    <?php
                    }else{
                        echo '<li>暂无数据</li>';
                    }
                }
            }
            echo '        </ul><div class="lasp">';
            echo $model['paging']->view();
            echo '        </div>';
        break;
    ?>
    
    
    
    
    <?php
        //关键词模糊查询
        case 'suggest':
//            print_r($model);
//            exit;
            if(count($model['allSymptoms']) > 0){
                foreach($model['allSymptoms'] as $v){
                    $title = $v['name'];
                    $shortTitle = String::cutString($v['name'], 7, '...');
    ?>
    <a href="javascript:void(0);" onclick="jumpUrl(this,1)" data-url='/zicha/jbzc_jg/?symptomid=<?=$v['id']?>' data-symptomid='<?=$v['id']?>' title="<?=$title?>"><?=$title?></a>
    <?php
                }
            }else{
                echo '0';
            }
        break;
    ?>
    
    
    
    <?php
        //关键词模糊查询
        case 'search':
//            print_r($model);
//            exit;
            if(count($model['allSymptoms']) > 0){
                echo '<li>';
                $i=1;
                foreach($model['allSymptoms'] as $v){
                    $title = $v['name'];
                    $shortTitle = String::cutString($v['name'], 7, '...');
    ?>
    <a href="javascript:void(0);" onclick="jumpUrl(this,1)" data-url='/zicha/jbzc_jg/?symptomid=<?=$v['id']?>' data-symptomid='<?=$v['id']?>' title="<?=$title?>"><?=$shortTitle?></a>
    <?php
                    if($i % 6 == 0 && count($model['allSymptoms']) % 6 !==0 ){echo '</li><li>';}
                    $i++;
                }
                echo '</li>';
            }else{
                echo '0';
            }
        break;
    ?>
<?php
}
?>
