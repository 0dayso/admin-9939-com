<?php

namespace librarys\helpers\plugin;

class Paging {

    public $pageNo = 1;             //页码
    public $pageSize = 10;          //页大小
    public $pageCount = 0;          //总页数
    public $totalNum = 0;           //总记录数
    public $showPageCount = 7;      //页码条显示页码数（奇数）

    /**
     * @param unknown_type $count 总行数
     * @param unknown_type $size 分页大小
     * @param unknown_type $string
     */
    public function __construct($count = 0, $size = 20, $pageNo = 1, $showPageCount = 7) {

        $this->totalNum = $count;
        $this->pageSize = $size;
        $this->pageNo = $pageNo;

        //计算总页数
        $this->pageCount = ceil($this->totalNum / $this->pageSize);
        $this->pageCount = ($this->pageCount <= 0) ? 1 : $this->pageCount;

        //检查pageNo
        $this->pageNo = $this->pageNo == 0 ? 1 : $this->pageNo;
        $this->pageNo = ($this->pageNo > $this->pageCount) ? $this->pageCount : $this->pageNo;

        //页面显示的页码的数目
        $this->showPageCount = ($showPageCount >= $this->pageCount) ? $this->pageCount : $showPageCount;
    }

    /**
     * 分页算法
     * @return
     */
    private function generatePageList() {

        $pageList = array();
        $halfCount = $this->showPageCount / 2;

        if ($this->pageCount <= $this->showPageCount) {
            $pageList = range(1, $this->pageCount);
        } else {

            if ($this->pageNo <= $halfCount) {
                $pageList = range(1, $this->showPageCount);
            } else if ($this->pageNo > $this->pageCount - $halfCount) {
                $pageList = range(($this->pageCount - $this->showPageCount + 1), $this->pageCount);
            } else if ($this->pageNo > $halfCount && $this->pageNo <= ($this->pageCount - $halfCount)) {
                $pageList = range(($this->pageNo - $halfCount), ($this->pageNo + $halfCount));
            }
        }
        return $pageList;
    }

    /*     * *
     * 创建分页控件
     * @param
     * @return String
     */

    public function pageToHtml() {
        $pageList = $this->generatePageList();
        $pageStr = '';
        if (!empty($pageList)) {
            if ($this->pageCount >= 1) {
                //上一页
                $pageStr .= '<a href="javascript:;" class="hko kos" id="pre_page">&lt;&lt;</a>';
                foreach ($pageList as $k => $v) {
                    if ($this->pageNo == $v) {
                        $pageStr .= '<a href="javascript:;" class="curt curt_dep page_click">' . $this->pageNo . '</a>';
                        continue;
                    }
                    $pageStr .= '<a href="javascript:;" class="page_click">' . $v . '</a>';
                }
                //下一页
                $pageStr .= '<a href="javascript:;" class="hko" id="next_page">&gt;&gt;</a>';
            }
            return $pageStr;
        }
    }

}
