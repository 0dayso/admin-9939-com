<?php
$page_num_list = $this->getPageNumList();//获取要显示的页码
$current_page=$this->getCurrent();//获取当前页码
$total_page = $this->getPageNum();//获取总页码
$hrefs='';
if(count($page_num_list)>0){
    $html = '';
    $page_flag='';
        if(!empty($partKey) && !empty($departmentKey)){
            if(!empty($typeId)){
                $hrefs = $partKey.'/'.$departmentKey.'_'.$typeId.'/';
            }else{
                $hrefs = $partKey.'/'.$departmentKey.'/';
            }
        }elseif(!empty($partKey)){
            if(!empty($typeId)){
                $hrefs= $partKey.'_'.$typeId.'/';
            }else{
                $hrefs= $partKey.'/';
            }
	}elseif(!empty($departmentKey)){
            if(!empty($typeId)){
		$hrefs= $departmentKey.'_'.$typeId.'/';
            }else{
                $hrefs= $departmentKey.'/';
            }
        }elseif(!empty($typeId)){
            $page_flag = '_'.$typeId;
        }else{
            $page_flag='';
        }
    if ($current_page > 1) {
        $html.='<a href="/jbzz'.$page_flag.'/'.$hrefs.$this->getUrl($this->getPrev()) . '" target="_self" class="lpage_a" title="上一页">&lt;&lt;上一页</a>';
    }
    foreach($page_num_list as $i){
        if ($current_page == $i) {
			
            $html.='<a href="/jbzz'.$page_flag.'/'.$hrefs.$this->getUrl($i) . '" style="background:#49C066 none repeat scroll 0 0;color:#fff" target="_self" >' . $i . '</a>';    //输出页数
        } else {
            $html.='<a href="/jbzz'.$page_flag.'/'.$hrefs. $this->getUrl($i) . '"  target="_self" >' . $i . '</a>';    //输出页数s
        }
    }
    $html .= '<span>...</span>';
    $html .= '<a target="_self" href="/jbzz'.$page_flag.'/'.$hrefs. $this->getUrl($total_page) . '">' . $total_page . '</a>';
    if ($current_page < $total_page) {
        $html .= '<a href="/jbzz'.$page_flag.'/'.$hrefs.$this->getUrl($this->getNext()) . '" target="_self" class="lpage_a" title="下一页">下一页&gt;&gt;</a>';
    }
    echo $html;
}