<?php

namespace api\models;

use api\models\Common;
use common\models\im\Users;
use common\models\ask\Member;
use common\models\ask\MemberDetail;
use common\models\ask\MemberDetailDoctor;
use common\models\disease\Doctor;
use common\models\disease\Hospital;
use common\models\im\Talks;
use common\models\ask\Ask;

class Userp extends Common
{

    //用户信息
    private $info = [];

    /**
     * 个人中心
     * @param $params
     * @return array
     */
    public static function center($params)
    {
        $res = array();
        return self::result($res);
    }

    /**头像上传
     * @param $file
     */
    public static function portrait($file)
    {
        //接收file文件
    }

    /**
     * 昵称 修改、设置
     * @param array $params
     * @return array
     */
    public static function nickname($params)
    {
        $userid = intval($params['userid']);
        $nickname = $params['nickname'];
        $updates = array(
            'nickname' => $nickname
        );
        $res = Member::updateInfo($userid, $updates);
        $status = $res ? 200 : 500;
        $message = $res ? '设置昵称成功' : '设置昵称失败';
        return self::result($status, $message, array());
    }

    /** 性别 设置、修改
     * @param $params
     * @return array
     */
    public static function sex($params)
    {
        $userid = intval($params['userid']);
        $sex = $params['sex'];
        $updates = array(
            'sex' => $sex
        );
        $res = Member::updateInfo($userid, $updates);
        $status = $res ? 200 : 500;
        $message = $res ? '设置性别成功' : '设置性别失败';
        return self::result($status, $message, array());
    }

    /**
     * 用户是否已经绑定手机号
     * @param $userid
     * @return array
     */
    public static function isBindMobile($userid){
        $member = new Member();
        $res = $member->get_one(['uid'=>$userid]);
        if($res){
            return Common::result(200,'',['isbinding'=>$res['is_binding_mobile']]);
        }
        return Common::result(500,'',[]);
    }

    /**
     * 绑定手机号---获取验证码
     * @param $params ['mobile'=>'110']
     */
    public static function bindSmsVerification($params)
    {
        //手机号合法性
        $validate = Mobile::validateMobile($params['mobile']);
        if ($validate) {
            //手机号是否存在
            $member = new Member();
            $res = $member->get_one(['mobile' => $params['mobile'], 'source' => 3]);
            if ($res) {
                return Common::result(200, '该手机号已经使用！', []);
            }
            //发送
            return Mobile::smsVerification($params);
        }
    }

    /**
     * 绑定手机号 ['mobile'=>110,'userid'=>1001]
     */
    public static function bindMobile($params)
    {
        $mobile = $params['mobile'];
        $userid = $params['userid'];
        $validate = Mobile::validateMobile($mobile);
        if ($validate) {
            $res = Member::updateInfo($userid, ['mobile' => $mobile, 'is_binding_mobile' => 1]);
            if ($res) {
                return Common::result(200, '绑定成功！', []);
            }
        }
        return Common::result(500, '绑定失败！', []);
    }

    /**手机号 设置、修改
     * @param $params
     * @return array
     */
    public static function mobile($params)
    {
        //captcha(验证码)
        $userid = intval($params['userid']);
        $captcha = $params['captcha'];
        $captcha_validate = Mobile::validateSmsVerification($userid, $captcha);//后台验证码
        //phone验证
        if (!$captcha_validate) {
            return self::result(500, '验证码不正确！', array());
        }

        $mobile = $params['mobile'];
        $vmobile = Mobile::validateMobile($mobile);
        if (!$vmobile) {
            return self::result(500, '手机号格式不正确！', array());
        }
        $updates = array(
            'mobile' => $mobile
        );
        $res = Member::updateInfo($userid, $updates);
        $status = $res ? 200 : 500;
        $message = $res ? '手机号修改成功' : '手机号修改失败';
        return self::result($status, $message, array());
    }

    /**密码 修改
     * @param $params
     */
    public static function passwords($params)
    {
        // newpw oldpw
    }


    public static function login($params)
    {
        $member = new Member();
        $username = $params['username'];
        $password = $params['password'];

        $uid = $member->checkLogin($username, $password);
        if (empty($uid)) {
            $code = 500;
            $msg = '登录失败，用户名或密码错误';
            $params = null;
        } else {
            $IMUser = Users::getById($uid);
            $code = 200;
            $msg = '登录验证通过';
            $params = [
                'nickname' => $IMUser->nickname,
                'accid' => $IMUser->accid,
                'token' => $IMUser->token,
                'utype' => $IMUser->utype,
                'avatar' => $IMUser->avatar
            ];
        }
        return self::result($code, $msg, $params);
    }


    /**
     * 验证表单数据
     * @return string|boolean
     */
    private function check()
    {
        $data = $this->info;
        if ($data['username'] == "")
            return "请填写用户名";
        if (!preg_match("/^[\w]+$/", $data['username']))
            return "用户名只能是下划线，数字，字母";

        if (strlen($data['username']) < 4 || strlen($data['username']) > 16)
            return "用户名长度必须是4到16个字符";
        if ($data['email'] != "") {
            if (!preg_match("/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/", $data['email']))
                return "E－mail格式不正确";
        }
        if ($data['nickname'] == "")
            return "请填写昵称";
        if (!preg_match("/^[\w|\x80-\xff]+$/", $data['nickname']))
            return "昵称只能是下划线，数字，字母，中文";
        if ($data['password'] == "")
            return "请填写密码";
        if ($data['password'] != $data['password1'])
            return "俩次输入密码不一致";
        if (strlen($data['password']) < 6)
            return "密码长度不小于6个字符";


        //验证医生真实信息
        if ($data['utype'] == '2') {
            if ($data['truename'] == "")
                return "请填写真实姓名";
            if ($data['doc_hos'] == "")
                return "请填写就职医院";
//            if ($data['doc_keshi'] == "")
//                return "请填写所在科室";

            if ($data['qh'] == "")
                return "请填写区号";
            if ($data['dwdh'] == "")
                return "请填写电话号码";
            if ($data['phone'] == "")
                return "请填写手机号";
        }
        return true;
    }


}
