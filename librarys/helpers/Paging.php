<?php
namespace librarys\helpers;

/**
 * 分页基类
 *
 */

class Paging {
    
    
	
	/**
	 * 总分页数
	 *
	 * @var Integer
	 */
	private $total;
	
	/**
	 * 每页记录数
	 *
	 * @var Integer
	 */
	private $size;
	
	/**
	 * 当前页
	 * @var Integer
	 */
	protected $currentPage = 1;
    
    
    /**
	 * 显示的页码数
	 *
	 * @var Integer
	 */
	private $pageSetSize = 5;
    
    /**
	 * 模板路径
	 * 
	 * @var String
	 */
	private $templatePath = '';
    
    
    /**
	 * 路径
	 *
	 * @var String
	 */
	private $path = '';
    
    
    /**
	 * 子串
	 *
	 * @var String
	 */
	private $substring = '?';
	
	/**
	 * 连接符号
	 *
	 * @var String
	 */
	private $sign = '=';
    
    /**
	 * 对符
	 *
	 * @var String
	 */
	private $pairs = '&';
    
    /**
	 * 设置分页链接中的关键字
	 *
	 * @var String
	 */
	private $keyword = 'page';
    
    /**
	 * 查询参数
	 * String or Array
	 * @var mixed
	 */
	private $query;
    
    /**
	 * url格式
	 * String
	 * @var mixed
	 */
	private $urlformat;
    
    
    /**
	 * 当前选中的按钮样式
	 * String
	 * @var mixed
	 */
    private $currentclassname='curt';
    
    
    /**
	 * 分页中代码当前页码的常量
	 *
	 */
	const PAGER_VARIABLE_STRING = "%{PAGE_NO}";
    
    
	/**
	 * 重载当前页方法
	 * @return Integer
	 */
	public function getCurrent() {
        $pageNo = $this->getParam($this->keyword, 1);
		if ($pageNo <= 0) {
			$pageNo = 1;
		}
		$this->currentPage = min($pageNo, $this->getPageNum());
		return $this->currentPage;
	}
	
	/**
	 * 设置当前页
	 * @param Integer $pageNo
	 * @return Q_Paging
	 */
	public function setCurrent( $pageNo ) {
		$cur = (int) intval($pageNo);
		if ($cur <= 0) {
			$cur = 1;
		}
		$this->currentPage = $cur;
		return $this;
	}
	
	/**
	 * 下一页
	 * @return Integer
	 */
	public function getNext() {
		$pageNum = $this->getPageNum();
		$current = $this->getCurrent();
		return $current < $pageNum ? ($current + 1) : $pageNum;
	}
	
	/**
	 * 上一页
	 * @return Integer
	 */
	public function getPrev() {
		$current = $this->getCurrent();
		return $current > 1 ? ($current - 1) : 1;
	}
    
    /**
	 * 新的获取当前偏移
	 * @return Integer
	 */
	public function getOffset() {
        $pageno = $this->getParam($this->keyword, 0);
		$offset = (int) (intval($pageno) * $this->getSize()) - $this->getSize();
		return $offset < 0 ? 0 : $offset;
	}
	
	
	/**
	 * 设置总记录数
	 *
	 * @param Integer $total
	 * @return Q_Paging
	 */
	public function setTotal( $total ) {
		$this->total = (int) intval($total);
		return $this;
	}
	/**
	 * 获取总数
	 * @return Integer
	 */
	public function getTotal() {
		return (int) intval($this->total);
	}
	
	/**
	 * 获取每页显示数
	 * @return Integer
	 */
	public function getSize() {
		return (int) intval($this->size);
	}
	
	/**
	 * 设置每页记录数
	 *
	 * @param Integer $size
	 * @return Q_Paging
	 */
	public function setSize( $size ) {
		if ($size > 0) {
			$this->size = (int) intval($size);
		}
		return $this;
	}
	
	/**
	 * 获取起始数
	 * @return Integer
	 **/
	public function getStarting() {
		return $this->getOffset();
	}
	
	/**
	 * 获取终点数
	 * @return Integer
	 **/
	public function getEnding() {
		return $this->getOffset() + $this->getSize();
	}
    
	
	/**
	 * 取得总分页数
	 *
	 * @return Integer
	 */
	public function getPageNum() {
		if ($this->getSize() == 0) {
			return 0;
		}
		return ceil($this->getTotal() / $this->getSize());
	}
    
    /**
	 * 设置模板路径
	 * 
	 * @param String $path
	 * @return Paging
	 */
	public function setTemplate($path) {
		$this->templatePath = $path;
		return $this;
	}
    
    /**
	 * 设置分页集尺寸
	 *
	 * @param integer $num 大于1
	 * @return Paging
	 */
	public function setPageSetSize($num) {
		$this->pageSetSize = (int) intval($num);
		return $this;
	}
    
    /**
	 * 取得分页集尺寸
	 *
	 * @return integer
	 */
	public function getPageSetSize() {
		return $this->pageSetSize;
	}
    
    
    
    /**
	 * 获取关键词
	 * @return String
	 */
	public function getKeyword() {
		return $this->keyword;
	}
	
	/**
	 * 设置关键词
	 *
	 * @param String $keyword
	 * @return Paging
	 */
	public function setKeyword($keyword) {
		if (!empty($keyword)) {
			$this->keyword = $keyword;
		}
		return $this;
	}
    
    /**
	 *
	 * 设置链接的路径
	 *
	 * @param String $path
	 * @return Paging
	 */
	public function setPath($path) {
		if (!empty($path)) {
			$this->path = trim($path);
		}
		return $this;
	}
    
    /**
	 * 设置链接的路径
	 * @return String
	 */
	public function getPath() {
		return $this->path;
	}
    
    /**
	 * 获取查询参数
	 * @return String
	 */
	public function getQuery() {
		if (empty($this->query)) {
			$this->query = $this->autoUrl();
		}
		if (is_array($this->query) && count($this->query) > 0) {
			$_query = array();
			foreach ($this->query as $key => $value) {
				if ($key == $this->getKeyword()) {
					continue;
				}
				if (is_array($value)) {
					foreach ($value as $k => $val) {
						$_query[] = "{$key}[]" . $this->sign . $val;
					}
				}
				else {
					$_query[] = "{$key}" . $this->sign . $value;
				}
			}
			$this->query = $this->pairs . implode($this->pairs, $_query);
		}
		return $this->query ? $this->query : '';
	}
    /**
	 * 设置查询参数
	 *
	 * @param mixed $query String or Array
	 * @return Paging
	 */
	public function setQuery($query) {
		$this->query = $query;
		return $this;
	}
    
    /**
	 * 获取URL
	 * 
	 * @param Integer $pageNo
	 * @return String
	 */
	public function getUrl($pageNo) {
        if(!empty($this->urlformat)){
            return sprintf($this->urlformat,$pageNo);
        }
        
		$query = $this->getQuery();
		if (strstr($query, self::PAGER_VARIABLE_STRING) && is_string($query)) {
			$query = str_replace(self::PAGER_VARIABLE_STRING, $pageNo, $query);
		}
		else {
			if (empty($query)) {
				$query = $this->getKeyword() . $this->sign . $pageNo;
			}
			else {
				$query = $this->getKeyword() . $this->sign . $pageNo . $query;
			}
		}
		$url = $this->getPath() . $this->substring . $query;
		return $url;
	}
    
     /**
	 *
	 * 设置链接的路径
	 *
	 * @param String $format
	 * @return Paging
	 */
	public function setUrlFormat($format) {
		if (!empty($format)) {
            $this->urlformat = trim($format);
		}
		return $this;
	}
    
    /**
	 * 设置链接的路径
	 * @return String
	 */
	public function getUrlFormat() {
		return $this->urlformat;
	}
    
    /**
	 *
	 * 设置链接的路径
	 *
	 * @param String $classname
	 * @return Paging
	 */
	public function setCurrentClass($classname) {
		if (!empty($classname)) {
            $this->currentclassname = trim($classname);
		}
		return $this;
	}
    
    /**
	 * 设置链接的路径
	 * @return String
	 */
	public function getCurrentClass() {
		return $this->currentclassname;
	}
    
    
    
    /**
	 * 自动组织 URL
	 * @return Array
	 */
	private function autoUrl() {
		$queryOpt = $_SERVER['REQUEST_URI'];
		$queryArg = parse_url($queryOpt);
		$queryOpt = isset($queryArg['query']) ? explode('&', $queryArg['query']) : array();
		$query = array();
		foreach ($queryOpt as $key => $val) {
			$strTmp = explode('=', $val);
			if (empty($strTmp[0]) || $strTmp[1] == '' || $strTmp[0] == $this->getKeyword()) {
				continue;
			}
			$query[$strTmp[0]] = $strTmp[1];
		}
		return $query;
	}
    /**
     * 获取显示的页面数据
     * @return type
     */
    public function getPageNumList(){
        $total_page = $this->getPageNum(); #总分页数
        $current_page = $this->getCurrent(); #当前页
        $dis_page_count = $this->getPageSetSize(); #分页集数
        $page_num_list = array();
        if ($total_page > 1) {
            $start = min(floor(max(($current_page - floor($dis_page_count / 2)), 1)), max(($total_page - $dis_page_count + 1), 1));
            $end = min(($start + $dis_page_count - 1), $total_page);
            $page_num_list =  range($start, $end);
        }
        return $page_num_list;
    }
    
    
    protected function getParam($key, $default = null) {
        return isset($_GET[$key]) ? $_GET[$key] : (isset($_POST[$key]) ? $_POST[$key] : $default);
    }
	
    
    /**
	 * 输出模板
	 */
	public function view() {
		if ($this->getTotal() > 0) {
			include ($this->templatePath);
		}
	}

	/**
	 * 输出模板
	 */
	public function view_2($partKey='',$departmentKey='',$typeId='') {
		if ($this->getTotal() > 0) {
			include ($this->templatePath);
		}
	}
}