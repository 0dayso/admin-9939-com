<?php
namespace api\models;

class Common {
    
    /**
     * 返回数据
     * @param type $code 状态码
     * @param type $message 提示信息
     * @param type $data 数据
     * @return array
     */
	public static function result($code, $message = null, $data = null) {
		return array(
				'code' => $code,
				'message' => $message,
				'data' => $data
		);
	}

}
