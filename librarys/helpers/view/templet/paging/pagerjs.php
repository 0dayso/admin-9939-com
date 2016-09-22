<?php
$page_num_list = $this->getPageNumList();//获取要显示的页码
$current_page=$this->getCurrent();//获取当前页码
$total_page = $this->getPageNum();//获取总页码
if(count($page_num_list)>0){
    $html = '';
    if ($current_page > 1) {
        $html.='<a href="javascript:" onclick="return turnpage(\''.$this->getPrev().'\',this);" target="_self" class="lpage_a" title="上一页">&lt;&lt;上一页</a>';
    }
    foreach($page_num_list as $i){
        if ($current_page == $i) {
            $html.='<a href="javascript:" class="'.$this->getCurrentClass().'" target="_self" >' . $i . '</a>';    //输出页数
        } else {
            $html.='<a href="javascript:"   onclick="return turnpage(\''.$i.'\',this);"   target="_self" >' . $i . '</a>';    //输出页数
        }
    }
    if ($current_page < $total_page) {
        $html .= '<a href="javascript:"   onclick="return turnpage(\''.$this->getNext().'\',this);"   target="_self" class="lpage_a" title="下一页">下一页&gt;&gt;</a>';
    }
    echo $html;
}