<?php
/* * ********************************************************************************************
 * 								Open Real Estate
 * 								----------------
 * 	version				:	V1.29.0
 * 	copyright			:	(c) 2016 Monoray
 * 							http://monoray.net
 * 							http://monoray.ru
 *
 * 	website				:	http://open-real-estate.info/en
 *
 * 	contact us			:	http://open-real-estate.info/en/contact-us
 *
 * 	license:			:	http://open-real-estate.info/en/license
 * 							http://open-real-estate.info/ru/license
 *
 * This file is part of Open Real Estate
 *
 * ********************************************************************************************* */

class LoginForm extends CFormModel
{

    public $username;
    public $password;
    public $rememberMe;
    public $verifyCode;

    const ATTEMPTSLOGIN = 3;

    private $_identity;

    public function rules()
    {
        $rules = array(
            array('username', 'filter', 'filter' => 'trim'),
            array('username, password', 'required'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );

        $rules[] = array('verifyCode', 'required', 'on' => 'withCaptcha');

        $rules[] = array('verifyCode', 'CustomCaptchaValidatorFactory', 'on' => 'withCaptcha');

        return $rules;
    }

    public function attributeLabels()
    {
        return array(
            'username' => Yii::t('common', 'E-mail'),
            'password' => Yii::t('common', 'Password'),
            'rememberMe' => Yii::t('common', 'Remember me next time'),
            'verifyCode' => tc('Verify Code'),
        );
    }

    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate()) {
                $this->addError('password', Yii::t('common', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else
            return false;
    }

    /**
     * Logs from social account in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function loginSocial($id = '')
    {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentitySocial($id);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_UNKNOWN_IDENTITY) {
            return 'deactivate';
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else
            return false;
    }
}
