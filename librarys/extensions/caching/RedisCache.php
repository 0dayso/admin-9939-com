<?php
namespace librarys\extensions\caching;

use yii\base\Component;
class RedisCache extends Component {
    
    public $keyPrefix;
    /**
     * @var array list of redis server configurations
     */
    private $_servers = [];
    private $_cache;
    
    public function init(){
        $this->_cache = new \Redis();
        if(!empty($this->servers)){
            $rd = rand(0, count($this->servers)-1);
            $server = $this->servers[$rd];
            $this->_cache->connect($server['host'], $server['port']);
        }
    }
    
    /**
     * 
     * @return type
     */
    public function getServers()
    {
        return $this->_servers;
    }

    /**
     * 
     * @param array $config
     */
    public function setServers($config)
    {
        foreach ($config as $c) {
            $this->_servers[] = $c;
        }
    }
    
    /**
     * 
     * @return 获取缓存前缀
     */
    public function getKeyPrefix(){
        return $this->keyPrefix;
    }
    
    /**
     * 
     * @return 获取缓存前缀
     */
    public function setKeyPrefix($value){
        $this->keyPrefix = $value;
    }
    
    
    /**
    * Call a sphinx function
    *
    * @param string $method the method to call
    * @param array $params the parameters
    * @return mixed
    */
	public function __call($method, $params)
	{
        if(method_exists($this, $method)){
            return call_user_func_array(array($this,$method), $params);
        }
		if (is_object($this->_cache) && get_class($this->_cache)==='Redis') {
            return call_user_func_array(array($this->_cache, $method), $params);
        }else{
            throw new \Exception('Can not call a method of a non existent object');
        }
	}
    
    
    /**
	 * 存入缓存数据
	 *
	 * @param String $key
	 * @param Mixed $val
	 * @param Integer $expiration
	 * @return boolean
	 */
	public function set($key, $val, $expire = 0) {
        $val = json_encode($val);//base64_encode(serialize($val));// 
        $cache_key = $this->makeCacheKey($key);
		return $this->_cache->setex($cache_key, intval($expire),$val);
	}
	
	/**
	 * 获取缓存
	 *
	 * @param String 
	 * @return Mixed
	 */
	public function get($key) {
		$results = false;
		if (!empty($key) && is_string($key)) {
            $cache_key = $this->makeCacheKey($key);
			$results = $this->_cache->get($cache_key);
            $results =   json_decode($results,true);//unserialize(base64_decode($results));//
		}
		return $results;
	}
	
	/**
	 * 删除缓存
	 *
	 * @param String $key
	 * @param Integer $delay
	 */
	public function delete( $key ){
        $cache_key = $this->makeCacheKey($key);
        $this->_cache->expire($cache_key,0);
        return $this->_cache->delete($cache_key);
    }
    
	/**
	 * 自动减一
	 *
	 * @param String $key
	 * @param Integer $offset
	 * @return bool
	 */
	public function decrement($key, $offset = 1) {
        $cache_key = $this->makeCacheKey($key);
		return $this->_cache->decrBy($cache_key, $offset);
	}
	
	/**
	 * 自动加一
	 *
	 * @param String $key
	 * @param Integer $offset
	 * @return bool
	 */
	public function increment($key, $offset = 1) {
        $cache_key = $this->makeCacheKey($key);
		return $this->_cache->incrBy($cache_key, $offset);
	}
    
    /** 
     * 清空数据 
     */  
    public function flushAll() {  
        $this->_cache->flushAll();  
        $this->_cache->flushDB();
    }
    
    public function lPush($key, $value) {
        $cache_key = $this->makeCacheKey($key);
		return $this->_cache->lPush($cache_key, $value);
	}
	
	public function rPop($key) {
        $cache_key = $this->makeCacheKey($key);
		return $this->_cache->rPop($cache_key);
	}
    
    
    /**
	 * 存入缓存数据
	 *
	 * @param String $key
	 * @param Mixed $val
	 * @param Integer $expire
	 * @return boolean
	 */
	public function hMset($key, $val, $expire = 0) { 
        $cache_key = $this->makeCacheKey($key);
		$this->_cache->hMset($cache_key, $val);
        $this->_cache->expire($cache_key,intval($expire));
	}
	
	/**
     * 
     * @param type $key
     * @param array $fields
     * @return type
     */
	public function hMget($key,$fields=array()) {
		$results = false;
		if (!empty($key) && is_string($key)) {
            $cache_key = $this->makeCacheKey($key);
            if(count($fields)>0){
                $results = $this->_cache->hMget($cache_key,$fields);
            }else{
                $results = $this->_cache->hGetAll($cache_key);
            }
		}
		return $results;
	}
    
    
    
    /**
	 * 删除hash缓存
	 *
	 * @param String $key
	 */
	public function hDel( $key){
        $cache_key = $this->makeCacheKey($key);
        return $this->_cache->expire($cache_key,1);
    }
	
	
	public function keys($keys) {
        $cache_key = $this->makeCacheKey($keys);
		return $this->_cache->keys($cache_key);
	}
	
	public function select($db = 9) {
		return $this->_cache->select($db);
	}
    
    public function makeCacheKey($key){
        return $this->_keyPrefix() . '.' . md5($key);
    }
    
    /**
	 * 制作 key 前缀
	 *
	 * @return String
	 */
	protected function _keyPrefix() {
        $tn = empty($this->keyPrefix) ? '' : '_q_tags';
        return md5($tn);
    }
    
    
}