<?php

namespace app\models;

use Yii;

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
class ResetPassword extends \yii\db\ActiveRecord {

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
                $this->addError($attribute, 'No email founded in our system or user is not activated yet!.');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'email' => 'Registered email',
        ];
    }

    public function resetPassword() {
        if ($this->validate()) {
            $this->sendEmail();
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
            $this->_email = User::findByEmail($this->email);
        }

        return $this->_email;
    }

    /**
     * Send new random password to User by Email
     *
     * @return boolean
     */
    public function sendEmail() {

        $user = User::findOne([
                    'active_key' => '',
                    'email' => $this->email,
        ]);

        if ($user) {

            $random_password = $this->randomPassword();

            User::setRandomPassword($user['username'], $random_password);

            Yii::$app->mailer->compose()
                    ->setFrom('dev01@dev.co-mit.com')
                    ->setTo($this->email)
                    ->setSubject("[Cominit CMS] Reset password")
                    ->setTextBody('Your new password: ' . $random_password)
                    ->send();
            
            Yii::$app->getSession()->setFlash('success', 'success');

            return true;
        }

        return false;
    }

    /**
     * Create a random password
     *
     * @return random password
     */
    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
