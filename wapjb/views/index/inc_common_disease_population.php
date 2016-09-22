<?php

use yii\helpers\Url;
use librarys\helpers\utils\String;
?>
<article class="male">
    <?php
    if (isset($category_disease_article)) {
        $i = 1;
        foreach ($category_disease_article as $k => $v) {
            $disn = ($i == 1) ? '' : 'disn';
            
            ?>
    <section class="sechoi <?php echo $disn;?>">
        <ul class="rade">
                    <?php
                    foreach ($v['disease'] as $kd => $vd) {
                        $url_disease = Url::to('/' . $vd['pinyin_initial'] . '/', true);
                        ?>

                        <li><a href="<?php echo $url_disease; ?>"><?php echo $vd['name']; ?></a>
                            <?php
                        }
                        ?>
                </ul>
                <div class="defal">
                    <?php
                    if (!empty($v['article'])) {
                        foreach ($v['article'] as $ka => $va) {
                            $url_article = '/article/' . date("Y/md", $va["inputtime"]) . '/' . $va['id'] . '.shtml';
                            ?>
                            <a href="<?php echo $url_article; ?>"><?php echo $va['title']; ?></a>

                            <?php
                        }
                    }
                    ?>
                </div>
    </section>
    
    <?php
    $i++;
        }
    }
    ?>
</article>
