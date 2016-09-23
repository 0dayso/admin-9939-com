<?php

namespace api\models;

use api\models\Common;
use common\models\ask\Member;
use librarys\extensions\message\message\sms\Client as Sms;

class Mobile extends Common
{

    const REDIS_PREFIX = 'h5_redis';
    const MD5_PREFIX = 'h5_9939_com';

    public static function getCache($userid, $key)
    {
        return \Yii::$app->redis->hGet(self::REDIS_PREFIX . $userid, $key);
    }

    public static function setCache($userid, $key, $value)
    {
        \Yii::$app->redis->hSet(self::REDIS_PREFIX . $userid, $key, $value);
    }

    /**
     * 短信验证码
     * @param array $params
     * @return array
     */
    public static function smsVerification($params)
    {

        $cur_time = time();
        //验证数据
        $validation = static::validateData($params);
        if (!$validation) {
            return Common::result(500, '请求数据不规范！', []);
        }

        //一天内次数设置
        $day_time = static::getCache($params['userid'], 'day_time');
        if (!$day_time || (date('Ymd', $day_time) != date('Ymd', $cur_time))) {
            static::setCache($params['userid'], 'day_time', $cur_time);
            static::setCache($params['userid'], 'day_num', 0);
        }

        $day_num = static::getCache($params['userid'], 'day_num') ?: 0;
        if ($day_num >= 5) {
            return Common::result(500, '当天请求次数超过5次！', []);
        }

        //60秒内禁止提交
        $sms_time = static::getCache($params['userid'], 'sms_time');
        if ($sms_time && ($cur_time - $sms_time) < 60) {
            return Common::result(500, '60秒内不要重复请求！', array());
        }
        //生成验证码、发送给用户、后台存储验证码(跨域session不可用)
        $code = rand(100000, 999999);
        $content = '您正在绑定手机号，校验码' . $code . '，请于30分钟内输入，工作人员不会索取，请勿泄漏';
        $mobile = Sms::send($params['mobile'], $content);

        static::setCache($params['userid'], 'sms_verification_code', $code);
        static::setCache($params['userid'], 'sms_time', $cur_time);
        static::setCache($params['userid'], 'day_num', ($day_num++));

        return Common::result(200, '发送成功！', ['sms_time' => $cur_time]);
    }

    private static function validateData($params = array())
    {
        if (!empty($params)) {
            $keys = ['userid', 'mobile'];
            foreach ($keys as $key) {
                if (!array_key_exists($key, $params) || empty($params[$key])) {
                    return false;
                }
            }
            //验证手机号格式 mobile
            if (!static::validateMobile($params['mobile'])) {
                return false;
            }
            //验证 userid
            $member = new Member();
            $user = $member->get_one(['uid' => $params['userid']]);
            if (!$user) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * 验证手机验证码的一致性
     * @param $userid
     * @param $smsVerificationCode
     * @return bool
     */
    public static function validateSmsVerification($userid,$smsVerificationCode){
        $res = static::getCache($userid,'sms_verification_code');
        if($res && $res == $smsVerificationCode){
            return true;
        }
        return false;
    }

    /** 验证手机号合法性
     * @param $mobile
     * @return bool
     */
    public static function validateMobile($mobile)
    {
        if (!preg_match("/^1[3|4|5|7|8][0-9]\d{8}$/", $mobile)) {
            return false;
        }
        return true;
    }

}
