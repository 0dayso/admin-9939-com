<?php
$page_num_list = $this->getPageNumList();//获取要显示的页码
$current_page=$this->getCurrent();//获取当前页码
$total_page = $this->getPageNum();//获取总页码
if(count($page_num_list)>0){
    $html = '';
    $html.='<a href="javascript:" onclick="return turnpage(\''.$this->getPrev().'\',this);" target="_self"><<上一页</a>';
    $html .= '<span><b id="current">'. $current_page .'</b>/<a id="total">'. $total_page .'</a></span>';
    $html.='<a href="javascript:" onclick="return turnpage(\''.$this->getNext().'\',this);" target="_self">下一页>></a>';
    echo $html;
}