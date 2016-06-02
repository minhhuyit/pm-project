<?php

namespace app\modules\login\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $display_name
 * @property string $activation_key
 * @property integer $status
 * @property string $created_date
 */
class LoginForm extends Model {

    public $rememberMe = true;
    public $email;
    public $username;
    public $pass;
    private $_user = false;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        $module = Yii::$app->getModule('login');
        $loginType = $module->loginType;

        if ($loginType == 'username') {
            return [
                [['username', 'pass'], 'required'],
                [['username'], 'string', 'max' => 60],
                [['pass'], 'string', 'max' => 255],
                ['rememberMe', 'boolean'],
                ['pass', 'validatePassword'],
            ];
        } elseif ($loginType == 'email') {
            return [
                [['pass', 'email'], 'required'],
                ['email', 'email'],
                [['email'], 'string', 'max' => 100],
                [['pass'], 'string', 'max' => 255],
                ['rememberMe', 'boolean'],
                ['pass', 'validatePassword'],
            ];
        }
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, Yii::t('login', 'Incorrect username or user is not activated yet!.'));
            } elseif (!User::validateHashPassword($this->pass, $user->pass)) {
                $this->addError($attribute, Yii::t('login', 'Incorrect password.'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'username' => Yii::t('login', 'Username'),
            'email' => Yii::t('login', 'Email'),
            'pass' => Yii::t('login', 'Password'),
            'rememberMe' => Yii::t('login', 'Remember me?'),
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login() {

        if ($this->validate()) {
            $module = Yii::$app->getModule('login');
            $loginType = $module->loginType;
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() {
        if ($this->_user === false) {
            $module = Yii::$app->getModule('login');
            $userClass = $module->userClass;
            $loginType = $module->loginType;
            if ($loginType == 'email') {
                $this->_user = $userClass::findByEmail($this->email);
            } elseif ($loginType == 'username') {
                $this->_user = $userClass::findByUsername($this->username);
            }
        }

        return $this->_user;
    }

}
