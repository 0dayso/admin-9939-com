<!-- 栏目关注 -->
<?php
if (isset($disease) && !empty($disease)) {
    $dname = \librarys\helpers\utils\String::cutString($disease['name'], 4, 0);
    $dpinyin = $disease['pinyin_initial'];
    if ($isSymptom == 1) {
        ?>
        <p class="a_pso">
            <span>栏目关注：</span>
            <a href="/zhengzhuang/<?php echo $dpinyin; ?>/zzqy/"><?php echo $dname; ?>的原因</a>
            <a href="/zhengzhuang/<?php echo $dpinyin; ?>/zzqy/"><?php echo $dname; ?>怎么回事</a>
            <a href="/zhengzhuang/<?php echo $dpinyin; ?>/shiliao/"><?php echo $dname; ?>吃什么好</a>
            <a href="/zhengzhuang/<?php echo $dpinyin; ?>/yiyao/"><?php echo $dname; ?>用药</a>
            <a href="/zhengzhuang/<?php echo $dpinyin; ?>/zzqy/"><?php echo $dname; ?>症状表现</a>
        </p>

        <p class="a_pst">
            <a href="/zhengzhuang/<?php echo $dpinyin; ?>/zzqy/"><?php echo $dname; ?>是怎么引起的</a>
            <a href="/zhengzhuang/<?php echo $dpinyin; ?>/shiliao/"><?php echo $dname; ?>食疗方法</a>
            <a href="/zhengzhuang/<?php echo $dpinyin; ?>/"><?php echo $dname; ?>症状详解</a>
            <a href="/zhengzhuang/<?php echo $dpinyin; ?>/yiyao/"><?php echo $dname; ?>吃什么药</a>
            <a href="/zhengzhuang/<?php echo $dpinyin; ?>/zixun/"><?php echo $dname; ?>在线咨询</a>
        </p>
        <?php
    } else {
        ?>
        <p class="a_pso">
            <span>栏目关注：</span>
            <a href="/<?php echo $dpinyin; ?>/by/"><?php echo $dname; ?>病因</a>
            <a href="/<?php echo $dpinyin; ?>/zz/"><?php echo $dname; ?>症状</a>
            <a href="/<?php echo $dpinyin; ?>/lcjc/"><?php echo $dname; ?>检查</a>
            <a href="/<?php echo $dpinyin; ?>/zl/"><?php echo $dname; ?>怎么治疗</a>
            <a href="/<?php echo $dpinyin; ?>/zl/"><?php echo $dname; ?>治疗方法</a>
        </p>

        <p class="a_pst">
            <a href="/<?php echo $dpinyin; ?>/yshl/"><?php echo $dname; ?>饮食</a>
            <a href="/<?php echo $dpinyin; ?>/yaopin/"><?php echo $dname; ?>用药</a>
            <a href="/<?php echo $dpinyin; ?>/jianjie/"><?php echo $dname; ?>是什么病</a>
            <a href="/<?php echo $dpinyin; ?>/zl/"><?php echo $dname; ?>自我治疗</a>
            <a href="/<?php echo $dpinyin; ?>/zz/"><?php echo $dname; ?>早期症状</a>
        </p>
        <?php
    }
}
?>


