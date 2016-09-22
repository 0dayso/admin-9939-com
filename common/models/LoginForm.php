<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $verifycode;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required','message'=>'用户名不能为空！'],
            ['password', 'required','message'=>'密码不能为空！'],
            ['verifycode','required','message'=>'验证码不能为空！'],
            ['verifycode','captcha','message'=>'验证码不正确！'],
            ['password', 'validatePassword']
        ];
    }
    
    public function validate($attributes = null, $clearErrors = true) {
        parent::validate($attributes,$clearErrors);
        
        //每次只返回一个错误
        $error = $this->getErrors();
        $i=0;
        foreach($error as $key=>$value){
            if($i>0):
                $this->clearErrors($key);
            endif;
            $i++;
        }
        return !$this->hasErrors();
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或者密码不正确!');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
