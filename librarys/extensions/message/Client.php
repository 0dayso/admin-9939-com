<?php

namespace librarys\extensions\message;

use yii\base\Component;
use yii\base\InvalidConfigException;

class Client extends Component {

    private $_config = [];

    private $_server;
    public function init() {
        if(empty($this->_config)){
            throw new InvalidConfigException('The "config" must be set');
        }
        if(isset($this->_config['ClassPath'])){
            $class_name = $this->_config['ClassPath'];
            $this->_server = new $class_name($this->_config);
        }else{
            throw new InvalidConfigException('Object configuration must be an array containing a "ClassPath" element.');
        }
    }

    public function setConfig($config) {
        foreach ($config as $k=>$v) {
            $this->_config[$k] = $v;
        }
    }

    public function getConfig() {
        return $this->_config;
    }

    /**
     * Call a ServerAPI function
     *
     * @param string $method the method to call
     * @param array $params the parameters
     * @return mixed
     */
    public function __call($method, $params) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        if (is_object($this->_server)) {
            return call_user_func_array(array($this->_server, $method), $params);
        } else {
            throw new \Exception('Can not call a method of a non existent object');
        }
    }

}
