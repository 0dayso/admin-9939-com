<?php
namespace librarys\extensions\search;

use yii\base\Component;
class Sphinx extends Component {
    /**
     * @var array list of Sphinx server configurations
     */
    private $_servers = [];
    private $_search;
    
    public function init(){
        require_once 'sphinxapi.php';
        $this->_search = new \SphinxClient();
        if(!empty($this->servers)){
            $rd = rand(0, count($this->servers)-1);
            $server = $this->servers[$rd];
            $this->SetServer($server['host'],intval($server['port']));
            $this->SetConnectTimeout(60);
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
		if (is_object($this->_search) && get_class($this->_search)==='SphinxClient') {
            return call_user_func_array(array($this->_search, $method), $params);
        }else{
            throw new \Exception('Can not call a method of a non existent object');
        }
	}
}