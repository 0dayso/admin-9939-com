<?php
$page_num_list = $this->getPageNumList();//获取要显示的页码
$current_page=$this->getCurrent();//获取当前页码
$total_page = $this->getPageNum();//获取总页码
if(count($page_num_list)>0){
    $html = '';
    if ($current_page > 1) {
        $html .='<a href="javascript:void(0);" class="hko kos" onclick="trunpage(\''. $this->getPrev() .'\')">&lt;&lt;</a>';
    }
    
    foreach($page_num_list as $i){
        if ($current_page == $i) {
            $html .='<a href="javascript:void(0);" class="curt">' . $i . '</a>';    //输出页数
        } else {
            $html .='<a href="javascript:void(0);" onclick="trunpage(\''.$i.'\')">' . $i . '</a>';    //输出页数
        }
    }
    $html .= '<span>...</span>';
    $html .= '<a href="javascript:void(0);" onclick="trunpage(\''.$total_page.'\')">' . $total_page . '</a>';
    if ($current_page < $total_page) {
        $html .='<a href="javascript:void(0);" onclick="trunpage(\''.$this->getNext().'\')" class="hko">&gt;&gt;</a>';
    }
    echo $html;
}    
