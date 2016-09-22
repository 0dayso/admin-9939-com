<?php

namespace api\models;

use api\models\Common;
use common\models\im\Talks;
use common\models\im\TalksDetail;

class Ask extends Common {

    public static function getlist($params) {
        return self::result(200, '获取数据成功', $params);
    }

    /**
     * 获取问题信息
     * @param type $params
     * @return type
     */
    public static function gettalks($params) {
        $offset = intval($params['offset']);
        $size = intval($params['size']);
        $sender_uid = isset($params['sender_uid']) ? $params['sender_uid'] : '';
        $receiver_uid = isset($params['receiver_uid']) ? $params['receiver_uid'] : '';
        $state = isset($params['state']) ? $params['state'] : -1;
        $condition = array();

        if (is_array($state)) {
            $state = array_intersect(array(0, 1, 2), $state);
            $condition['state'] = $state;
        } else {
            $state = intval($state);
            if (in_array($state, array(0, 1, 2), true)) {
                $condition['state'] = $state;
            }
        }
        if (!empty($sender_uid)) {
            $condition['sender_uid'] = $sender_uid;
        }
        if (!empty($receiver_uid)) {
            $condition['receiver_uid'] = $receiver_uid;
        }
        $orderby = array('updatetime' => SORT_DESC);
        $ret = Talks::search($condition, $offset, $size, $orderby);
        $data = $ret['list'];
        if (empty($data)) {
            return self::result(200, '获取数据失败', $data);
        }
        return self::result(200, '获取数据成功', $data);
    }

    /**
     * 创建问题的回复信息
     * @param type $params
     * @return type
     */
    public static function create_talksdetail($params) {
        $talks_id = intval($params['talks_id']);
        $uid = $params['uid'];
        $username = $params['username'];
        $flag = $params['flag'];
        $body = $params['body'];
        $from_flag = $params['from_flag'];
        $msg_id = $params['im_msg_id'];
        $msg_time = $params['im_msg_time'];
        $extend_params = array('im_msg_id' => $msg_id, 'im_msg_time' => $msg_time);
        $detail_id = TalksDetail::addDetail($body, $flag, $uid, $username, $talks_id, $from_flag, $extend_params);
        if ($detail_id > 0) {
            $row_talks = Talks::getById($talks_id);
            if (!empty($row_talks)) {
                if ($row_talks['sender_uid'] != $uid) {
                    $update_params = array(
                        'receiver_uid' => $uid,
                        'receiver_name' => $username,
                        'state' => 1,
                        'last_reply' => $body,
                        'last_msg_id' => $msg_id,
                        'endtime' => $msg_time
                    );
                    if ($row_talks['state'] === 0) {
                        $update_params['begintime'] = $msg_time;
                    }
                    Talks::updateTalks($talks_id, $update_params);
                }
            }
            return self::result(200, '同步回复数据成功', $detail_id);
        } else {
            return self::result(500, '同步回复数据失败', $detail_id);
        }
    }

    /**
     * 获取问题回复列表
     * @param type $params
     * @return type
     */
    public static function gettalksdetail($params) {
        $offset = intval($params['offset']);
        $size = intval($params['size']);
        $talks_id = isset($params['talks_id']) ? $params['talks_id'] : 0;
        $condition = array();
        if ($talks_id > 0) {
            $condition['talks_id'] = $talks_id;
            $orderby = array('createtime' => SORT_DESC);
            $ret = TalksDetail::search($condition, $offset, $size, $orderby, true);
            return self::result(200, '获取数据成功', $ret);
        } else {
            return self::result(201, '参数失败:问题ID不存在!', null);
        }
    }

}
