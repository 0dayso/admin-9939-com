<?php

namespace librarys\extensions\message\rongcloud;

use \librarys\extensions\message\ImInterface;

require_once 'ServerAPI.php';

/**
 * 融云IM
 */
class Server extends \ServerAPI implements ImInterface {

    public $AppKey;                //开发者平台分配的AppKey
    public $AppSecret;             //开发者平台分配的AppSecret,可刷新
    public $Format = 'json';  //

    public function __construct($config = []) {
        if (!empty($config)) {
            $this->configure($config);
        }
        parent::__construct($this->AppKey, $this->AppSecret, $this->Format);
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
    /*
     * 注册融云账号
     */
    public function createuser($params) {
        $userId = isset($params['userid']) ? $params['userid'] : '';
        $name = isset($params['name']) ? $params['name'] : '';
        $avatar = isset($params['avatar']) ? $params['avatar'] : ''; //用户头像
        $ret = $this->getToken($userId, $name, $avatar);
        return json_decode($ret, true);
    }

}
