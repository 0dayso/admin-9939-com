<?php

$page_num_list = $this->getPageNumList(); //获取要显示的页码
$current_page = $this->getCurrent(); //获取当前页码
$total_page = $this->getPageNum(); //获取总页码
if (count($page_num_list) > 0 && $total_page <= 9) {
    $html = '';
    if ($current_page > 1) {
        $html.='<a href="' . $this->getUrl($this->getPrev()) . '" target="_self" class="lpage_a" title="上一页">&lt;&lt;上一页</a>';
    }
    foreach ($page_num_list as $i) {
        if ($current_page == $i) {
            $html.='<a href="' . $this->getUrl($i) . '" class="cust" target="_self" >' . $i . '</a>';    //输出页数
        } else {
            $html.='<a href="' . $this->getUrl($i) . '"  target="_self" >' . $i . '</a>';    //输出页数
        }
    }
    if ($current_page < $total_page) {
        $html .= '<a href="' . $this->getUrl($this->getNext()) . '" target="_self" class="lpage_a" title="下一页">&gt;&gt;下一页</a>';
    }
    echo $html;
} elseif ($total_page > 9) {
    $html = '';
    $html .= '<a href="' . $this->getUrl(1) . '">首页</a>';
    if ($current_page > 1) {
        $html.='<a href="' . $this->getUrl($this->getPrev()) . '" target="_self" class="lpage_a" title="上一页">&lt;&lt;</a>';
    }
    foreach ($page_num_list as $i) {
        if ($current_page == $i) {
            $html.='<a href="' . $this->getUrl($i) . '" class="cust" target="_self" >' . $i . '</a>';    //输出页数
        } else {
            $html.='<a href="' . $this->getUrl($i) . '"  target="_self" >' . $i . '</a>';    //输出页数
        }
    }
    if (end($page_num_list) < $total_page) {
        $html .= '<span>...</span>';
        $html .= '<a href="' . $this->getUrl($total_page) . '">' . $total_page . '</a>';
    }
    if ($current_page < $total_page) {
        $html .= '<a href="' . $this->getUrl($this->getNext()) . '" target="_self" class="lpage_a" title="下一页">&gt;&gt;</a>';
    }
    $html .= '<input type="text" placeholder="1" value="" id="jump_num"><a href="javascript:;" urlformat = "'.$this->urlformat.'" id="page_jump" maxpage="' . $total_page . '">跳转</a>';
    $html .= '<a href="' . $this->getUrl($total_page) . '">尾页</a>';
    echo $html;
}