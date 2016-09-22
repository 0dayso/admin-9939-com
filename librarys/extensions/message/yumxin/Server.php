<?php

namespace librarys\extensions\message\yunxin;

use \librarys\extensions\message\ImInterface;

require_once 'ServerAPI.php';

/**
 * 网易云信IM
 */
class Server extends \ServerAPI implements ImInterface {

    public $AppKey;                //开发者平台分配的AppKey
    public $AppSecret;             //开发者平台分配的AppSecret,可刷新
    public $RequestType = 'curl';  //[选择php请求方式，fsockopen或curl,若为curl方式，请检查php配置是否开启]

    public function __construct($config = []) {
        if (!empty($config)) {
            $this->configure($config);
        }
        parent::__construct($this->AppKey, $this->AppSecret, $this->RequestType);
        $this->init();
    }

    public function configure($properties) {
        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }
        return $this;
    }

    public function init() {
        
    }

    public function createuser($params) {
        $accid = isset($params['accid']) ? $params['accid'] : '';
        $name = isset($params['name']) ? $params['name'] : '';
        $props = isset($params['props']) ? $params['props'] : '{}';
        $icon = isset($params['icon']) ? $params['icon'] : '';
        $token = isset($params['token']) ? $params['token'] : '';
        $ret = $this->createUserId($accid, $name, $props, $icon, $token);
        return $ret;
    }

}
