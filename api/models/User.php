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

class User extends Common {

    //用户信息
    private $info = [];
    //注册来源
    private $source = [
        1 => 'web',
        2 => 'wap',
        3 => 'app'
    ];

    private static function getImApi() {
        return \Yii::$app->im;
    }

    /**
     * 创建普通用户
     * @param type $params
     */
    public static function create($params) {
        $user = new self();
        $info = $user->getFormdata($params);
        if ($info) {
            //1、在问答库9939_com_v2sns用户表member里注册
            $utype = $user->info['utype'];
            if ($utype == '1') {//普通用户
                $res = $user->createGeneralAccount();
            } elseif ($utype == '2') {//医生用户
                $res = $user->createDoctorAccount();
            }
            if ($res['code'] == 200) {
                $user->info['userid'] = $params['uid'] = $userid = $res['data']['uid'];
            } else {
                $errData = isset($res['data']) ? $res['data'] : null;
                return self::result($res['code'], $res['message'], $errData);
            }

            //2、添加第三方IM账号
            $im = $user->createThirdpartyIMAccount($userid);
            if (!isset($im)) {
                return self::result($im['code'], $im['message'], $im['data']);
            }
            $params = array_merge($params, $im);

            //3、返回注册成功信息
            return self::result(200, '账号注册成功', $params);
        }
        return self::result(500, 'Unauthorized');
    }

    public static function login($params) {
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
                'uid' => $IMUser->uid,
                'token' => $IMUser->token,
                'username'=>$IMUser->username,
                'nickname' => $IMUser->nickname,
                'utype' => $IMUser->utype,
                'avatar' => $IMUser->avatar
            ];
        }
        return self::result($code, $msg, $params);
    }

    /**
     * 根据用户userid创建第三方IM账号，及创建本地第三方IM账号信息
     * @param type $userid
     * @return type 返回信息码及信息
     */
    private function createThirdpartyIMAccount($userid) {
        $info = $this->info;
        $username = $info['username'];
        $nickname = $info['nickname'];
        $utype = $info['utype'];
        $avatar = "http://ask.9939.com/images/default.jpg";

        $ret = [];
        $params = array(
            'userid' => $userid,
            'name' => $nickname,
            'avatar' => $avatar
        );
        //2、添加用户信息给第三方系统
        $im = self::getImApi();
        $res = $im->createuser($params); //
        if ($res['code'] !== 200) {
            $result = [
                'code' => $res['code'],
                'message' => $res['desc'],
                'data' => $res
            ];
            return $result;
        }
        $ret['token'] = $token = $res['token'];
        //3、完成第三方IM账户在本网站的注册
        $isUserExists = Users::getById($userid);
        if (!isset($isUserExists)) {
            $status = 1;
            $ret['uid'] = Users::addUsers($userid, $username, $nickname, $utype, $avatar, $status, array('token' => $token));
        }
        return $ret;
    }
    /**
     * 批量同步用户到IM
     * @return array
     */
    public static function batch_create_imaccount() {
        $condition = ['status' => 0];
        $return_info = Users::search($condition);

        $list = $return_info['list'];

        $updatecount = 0;
        if (count($list) > 0) {
            $im = self::getImApi();
            foreach ($list as $k => $v) {
                $uid = $v['uid'];
                $param = array(
                    'userid' => $uid,
                    'name' => $v['nickname'],
                    'avatar' => $v['avatar']
                );

                $ret = $im->createuser($param);
                if ($ret['code'] == 200) {
                    $ret = Users::updateUsers($uid, array(
                                'token' => $ret['token'],
                                'status' => 1
                    ));
                    if ($ret > 0) {
                        $updatecount++;
                    }
                }
            }
        }

        $message = '未包含有待注册IM的用户';
        $result = [
            'code' => 201,
            'message' => $message,
            'data' => ''
        ];
        if ($updatecount > 0) {
            $result['code'] = 200;
            $result['message'] = sprintf('共注册%s个用户到IM', $updatecount);
        }
        return $result;
    }

    /**
     * 接受表单数据
     * @param type $params
     * @return boolean
     */
    private function getFormdata($params) {
        $info = $params;
        if (isset($params['utype'])) {
            $info['dateline'] = time();
            //获取医生真实信息
            if ($info['utype'] == '2') {
                $info['truename'] = $params['truename'];
                $info['doc_hos'] = $params['doc_hos'];
                //            $info['doc_keshi'] = $params['doc_keshi'];
                $info['qh'] = $params['qh'];
                $info['dwdh'] = $params['dwdh'];
                $info['phone'] = $params['phone'];
                $info['dis'] = isset($params['dis']) ? $params['dis'] : '';
                if (!empty($info['dis'])) {
                    $dis_str = is_array($info['dis']) ? implode(',', $info['dis']) : $info['dis'];
                    $info['dis'] = $dis_str;
                }
            }

            $info['source'] = $params['source'];
            $this->info = $info;
            return true;
        }
        return false;
    }

    /**
     * 验证表单数据
     * @return string|boolean
     */
    private function checkUserInfo() {
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
            if ($data['qh'] == "")
                return "请填写区号";
            if ($data['dwdh'] == "")
                return "请填写电话号码";
            if ($data['phone'] == "")
                return "请填写手机号";
        }
        return true;
    }

    /**
     * 创建普通用户账号
     * @param type $info
     * @return type array 返回信息码及信息
     */
    private function createGeneralAccount() {
        $memberObj = new Member();
        $detailObj = new MemberDetail();
        $info = $this->info;
        $sourceNum = $info['source'];

        if (($error = $this->checkUserInfo()) === true) {
            $where = [
                'or', ['email' => $info['email']], ['username' => $info['username']]
            ];
            $member = $memberObj->get_one($where);
//            print_r($info);exit;
            if (isset($member)) {
                $result = [
                    'code' => 500,
                    'message' => '用户名或E-mail存在请更改',
                    'data' => ['source' => $this->source[$sourceNum]]
                ];
                return $result;
            }
        } else {
            $result = [
                'code' => 500,
                'message' => $error,
                'data' => ['source' => $this->source[$sourceNum]]
            ];
            return $result;
        }

        $password = $info['password'];
        $addInfo = $info;
        $addInfo['password'] = md5($password);
        $addDetial['utype'] = $info['utype'];
        unset($addInfo['password1']);
        $uid = $memberObj->add_one($addInfo);     //插入基本信息
        $addDetial['uid'] = $uid;
        unset($addDetial['utype']);
        $detailObj->add_one($addDetial); //插入详细信息
        $result = [
            'code' => 200,
            'message' => '注册成功',
            'data' => ['source' => $this->source[$sourceNum], 'uid' => $uid]
        ];
        return $result;
    }

    /**
     * 创建医生账号
     * @param type $info 经过验证的表单数据
     */
    private function createDoctorAccount() {
        $memberObj = new Member();
        $doctorDetailObj = new MemberDetailDoctor();
        $doctorObj = new Doctor();
        $hospitalObj = new Hospital();
        $firstInfo = $this->info;
        $sourceNum = $firstInfo['source'];

        $info['truename'] = $firstInfo['truename'];
        $info['doc_hos'] = $firstInfo['doc_hos'];
//        $info['doc_keshi'] = $firstInfo['doc_keshi'];
        if ($firstInfo['truename']) {//如果有数据提交
            if (($error = $this->checkUserInfo()) === true) {
                $where = [
                    'or', ['email' => $firstInfo['email']], ['username' => $firstInfo['username']]
                ];
                $member = $memberObj->get_one($where);
                if ($member) {
                    $result = [
                        'code' => 4001,
                        'message' => '用户名或E-mail存在请更改',
                        'data' => ['source' => $this->source[$sourceNum]]
                    ];
                    return $result;
                }
            } else {
                $result = [
                    'code' => 4000,
                    'message' => $error,
                    'data' => ['source' => $this->source[$sourceNum]]
                ];
                return $result;
            }
            $info['username'] = $firstInfo['username'];
            $info['email'] = $firstInfo['email'];
            $info['nickname'] = $firstInfo['nickname'];
            $info['utype'] = $firstInfo['utype'];
            $info['password'] = md5($firstInfo['password']);
            $info['dateline'] = $firstInfo['dateline'];
            $info['dis'] = $firstInfo['dis'];
            $addInfo = $info;
            unset($addInfo['truename']);
            unset($addInfo['doc_hos']);
//            unset($addInfo['doc_keshi']);
            unset($addInfo['dis']);
            unset($addInfo['password1']);
            $uid = $memberObj->add_one($addInfo); //插入用户基本信息
            $addDetial = [
                'truename' => $firstInfo['truename'],
                'doc_hos' => $firstInfo['doc_hos'],
//                'doc_keshi' => $firstInfo['doc_keshi'],
                'uid' => $uid,
                'dis' => rtrim($firstInfo['dis'], ",")
            ];
            $doctorDetailObj->add_one($addDetial); //插入详细信息

            $condition = ['name_hospital' => trim($info['doc_hos'])];
            $hospital = $hospitalObj->get_one_get($condition);
            $hospital_id = $hospital['hospital_id'];

            $qh = $firstInfo['qh'];
            $dwdh = $firstInfo['dwdh'];
            $doctorInfo = [
                'jiayuanID' => isset($uid) ? $uid : '',
                'hospital' => $hospital_id,
                'username' => $firstInfo['username'],
                'name_doctor' => $firstInfo['truename'],
                'inputtime' => time(),
                'rlphone' => $qh . "-" . $dwdh . "," . $firstInfo['phone'],
                'status' => 3,
            ];
            $doctor_id = $doctorObj->add_one($doctorInfo);

            $result = [
                'code' => 200,
                'message' => '注册成功',
                'data' => ['source' => $this->source[$sourceNum], 'uid' => $uid]
            ];
            return $result;
        } else {
            if (($error = $this->checkUserInfo()) === true) {
                $where = [
                    'or', ['email' => $info['username']], ['username' => $info['username']]
                ];
                $member = $memberObj->get_one($where);
                if ($member) {
                    $result = [
                        'code' => 4001,
                        'message' => '用户名或E-mail存在请更改',
                        'data' => ['source' => $this->source[$sourceNum]]
                    ];
                    return $result;
                }
            } else {
                $result = [
                    'code' => 4000,
                    'message' => $error,
                    'data' => ['source' => $this->source[$sourceNum]]
                ];
                return $result;
            }

            $result = [
                'code' => 200,
                'message' => '注册成功',
                'data' => ['source' => $this->source[$sourceNum], 'uid' => $uid]
            ];
            return $result;
        }
    }

    /**
     * 用户提问题
     * @param type $params
     * @return type
     */
    public static function addQuestion($params) {
        $self = new self();
        $ask = new Ask();
        $askinfo = [];
        $result = $self->checkQuestion($params);
        if ($result === true) {
            $subject = $params['subject'];
            $sender_uid = $params['sender_uid'];
            $sender_name = $params['sender_name'];
            $receiver_uid = 0;
            $receiver_name = '';
            $askinfo['content'] = $subject;
            $class = $ask->triage($askinfo); //对用户提问的问题进行分诊
            //创建问题群组
            $extend_info = array('receiver_uid'=>$receiver_uid,'receiver_name'=>$receiver_name);
            $res = Talks::addTasks($subject, $sender_uid, $sender_name,$extend_info);
            if ($res > 0) {
                return self::result(200, '问题提交成功', $class);
            } else {
                return self::result(201, '问题提交失败', $class);
            }
        } else {
            $code = $result['code'];
            $message = $result['message'];
            return self::result($code, $message);
        }
    }

    /**
     * 校验用户提交的问题
     * @param type $params
     * @return int|boolean
     */
    private function checkQuestion($params) {
        $result = [];
        if ($params['sender_uid'] == '' || $params['sender_name'] == '') {
            $result = [
                'code' => 1001,
                'message' => '请登录之后再提交问题。',
            ];
        }
        if ($params['subject'] == '') {
            $result = [
                'code' => 1002,
                'message' => '问题不能为空',
            ];
        } elseif (strlen($params['subject']) < 30) {
            $result = [
                'code' => 1003,
                'message' => '问题不少于10个字，否则医生无法准确解答',
            ];
        } elseif (strlen($params['subject']) > 360) {
            $result = [
                'code' => 1004,
                'message' => '问题字数请控制在120个字以内',
            ];
        }
        if (isset($result['code'])) {
            return $result;
        } else {
            return true;
        }
    }

}
