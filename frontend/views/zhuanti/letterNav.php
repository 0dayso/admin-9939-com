<?php
$letter_list = $letterNav['return_list'];
$curr_cssname = $letterNav['curr_cssname'];
$curr_letter = $letterNav['curr_letter'];

?>
<?php foreach($letter_list as $k=>$v) {
    $class_name =($v['selected']==1? 'class="'.$curr_cssname.'"':''); 
?>
<a href="<?php echo $v['url']; ?>" <?php echo $class_name; ?> ><?php echo $k; ?></a>
<?php } ?>