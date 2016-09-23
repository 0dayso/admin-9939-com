<?php

namespace api\models;

use api\models\Common;
use common\models\Feedback as d_feedback;

class Feedback extends Common {

    public static function add($params){

        $userid = intval($params['userid']);
        $username = $params['username'];
        $data = [
            'surgets'=>4,
            'content'=>$params['content'],
            'contact'=>$params['contact'],
            'userid'=>$params['userid'],
            'username'=>$params['username'],
            'createtime'=>time(),
        ];
        $feebback = new d_feedback();
        $res = $feebback->feedbackAdd($data);
        $code = $res ? 200 : 500;
        $message = $res ? '意见反馈成功！' : '意见反馈失败，请再次提交！';
        return Common::result($code,$message,array());
    }
}
