<!-- wapjb 中，疾病文章列表页，分页部分 -->

<?php
$page_num_list = $this->getPageNumList(); //获取要显示的页码
$current_page = $this->getCurrent(); //获取当前页码
$total_page = $this->getPageNum(); //获取总页码
?>
<a href="<?php echo $this->getUrl($this->getPrev()); ?>" title="上一页">&lt;&lt;上一页</a>
<span> <b><?php echo $current_page; ?></b>/<?php echo $total_page; ?></span>
<a href="<?php echo $this->getUrl($this->getNext()); ?>" title="下一页">下一页&gt;&gt;</a>