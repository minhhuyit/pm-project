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
class ResetPasswordForm extends Model {

    public $email;
    private $_email = false;

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
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'validateEmail'],
        ];
    }

    /**
     * Validates the email.
     * This method serves as the inline validation for email.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateEmail($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, Yii::t('login','No email founded in our system or user is not activated yet!.'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'email' => Yii::t('login', 'Registered email'),
        ];
    }

    /**
     * Reset user password and send created random password to user's email
     *
     * @return boolean
     */
    public function resetPassword() {
        if ($this->validate()) {
            $this->sendEmail();
            return true;
        }
        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser() {
        if ($this->_email === false) {
            $module = Yii::$app->getModule('login');
            $userClass = $module->userClass;
            $this->_email = $userClass::findByEmail($this->email);
        }

        return $this->_email;
    }

    /**
     * Send new random password to User by Email
     *
     * @return boolean
     */
    public function sendEmail() {

        $module = Yii::$app->getModule('login');
        $userClass = $module->userClass;

        $user = $userClass::findOne([
                    'active_key' => '',
                    'email' => $this->email,
        ]);

        if ($user) {

            $random_password = User::generateRandomPassword(8);

            $userClass::setRandomPassword($user['username'], $random_password);
            $content = Yii::t('login', 'Your new password:').' <b>' . $random_password . '</b>';

            Yii::$app->mailer->compose(['html' => '@app/mail/layouts/html',], ['content' => $content])
                    ->setFrom(Yii::$app->params["fromEmail"])
                    ->setTo($this->email)
                    ->setSubject("[Cominit CMS] ".Yii::t('login', 'Reset password'))
                    ->send();

            Yii::$app->getSession()->setFlash('status', 'success');

            return true;
        }

        return false;
    }


}
