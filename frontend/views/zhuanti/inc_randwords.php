<?php
$letter = $randwords['letter'];
$letter_list = $randwords['letter_list'];
$randwords = $randwords['randwords'];
?>
<div class="wrapper">
    <div class="letter-switch lett-tab leume mT25 line clearfix">
        <?php
        foreach ($letter_list as $k => $v) {
//                        $class_name = ($v['selected']==1? 'class="nols"':'');
            $class_name = ($letter == $k) ? 'class="currm move"' : 'class="currm"';
            $letter_url = sprintf('%s%s/',$URL->letterurl,$k);
            ?>
            <a switc="<?php echo $k; ?>"  href="<?php echo $letter_url; ?>" <?php echo $class_name; ?> target="_blank" style="text-decoration:none;"><?php echo $k; ?></a>
        <?php } ?>
    </div>



    <div class="lett-tab-con f12">
        <?php
            $i = 0;
            foreach ($randwords as $k => $v) {
                $zimu = strtoupper($k);
                $style = (strtoupper($letter) == $zimu) ? '' : 'curro disn';
        ?>
                <div switc-ass="<?php echo $zimu; ?>" class="lett-tab-<?php echo $zimu; ?> hotwords <?php echo $style; ?>"  >
                    <?php
                    if (count($v) > 1) {
                        foreach ($v as $kk => $vv) {
                            $url = sprintf('%s%s/', $URL->searchurl, str_replace(' ', '', $vv['pinyin']));
                            echo '<a href="' . $url . '" title="' . $vv['keywords'] . '">' . $vv['keywords'] . '</a>';
                        }
                    }
                    ?>
                </div>
        <?php
            $i++;
            } 
        ?>
    </div>
    <script>
        $('.currm').mousemove(function(){
            var zimu = $(this).attr('switc');
            var className = ".lett-tab-" + zimu;
            $('.move').removeClass('move');
            $(this).addClass('move');
            var div = $(".lett-tab-con").find(className);
            $(".lett-tab-con div").addClass('curro');
            if (div) {
                div.removeClass('curro');
            }
        }).click(function(){
            //return false;
        });
    </script>

</div>