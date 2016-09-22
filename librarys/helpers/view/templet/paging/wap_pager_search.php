<?php
$page_num_list = $this->getPageNumList();//获取要显示的页码
$current_page=$this->getCurrent();//获取当前页码
$total_page = $this->getPageNum();//获取总页码
if(count($page_num_list)>0){
    $html = '';
    if ($current_page > 1) {
		$html.='<a href="' . $this->getUrl($this->getPrev()) . '" target="_self" ><<上一页</a>';
    }

    $html.='<span><b>'.$current_page.'</b>/'.$total_page.'</span>';

    if ($current_page < $total_page) {
		$html.='<a href="' . $this->getUrl($this->getNext()) . '" target="_self">下一页>></a>';
    }
    echo $html;
}