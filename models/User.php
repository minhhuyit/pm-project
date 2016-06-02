<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $pass
 * @property string $display_name
 * @property string $active_key
 * @property string $created_date
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface 
{
    public $authKey;
    public $new_pass;
    public $re_pass;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['username', 'email'],'required'],
            [['username', 'email'],'unique'],
            [['username','new_pass'], 'string', 'max' => 60],
//            array('repeat_password', 'compare', 'compareAttribute'=>'user_pass'),
//                        array('user_pass, repeat_password','required','on'=>'create'),
            [['pass'],'required','on'=>'create'],
            [['re_pass'],'compare','compareAttribute'=>'pass','on'=>'update'],
            [['email'], 'string', 'max' => 100],
            ['email','email'],
            [['pass', 'active_key'], 'string', 'max' => 255],
            [['display_name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => Yii::t('user', 'User Name'),
            'email' => Yii::t('user', 'Email'),
            'pass' => Yii::t('user', 'Pass'),
            'display_name' =>Yii::t('user', 'Display Name') ,
            'active_key' => Yii::t('user', 'Active Key'),
            'created_date' => Yii::t('user', 'Created Date'),
        ];
    }
    
     /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
    return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username) {
        $user = User::find()
                ->where(['username' => $username])
                ->andWhere(['=', 'active_key', ''])
                ->one();
        return $user;
    }

    public static function findByEmail($email) {
        $user = User::find()
                ->where(['email' => $email])
                ->andWhere(['=', 'active_key', ''])
                ->one();
        return $user;
    }
       
    public function setRandomPassword($username, $password){
         $user = User::updateAll(array('pass' => User::generateHashPassword($password)), "username = '".$username."'");
         return null;
    }
    
    public static function generateHashPassword($password)
    {
        return \Yii::$app->security->generatePasswordHash($password);
    }
 
    public static function validateHashPassword($password, $hash)
    {
        return \Yii::$app->security->validatePassword($password, $hash);
    }  
    
    public static function generateRandomPassword($length)
    {
        return \Yii::$app->security->generateRandomString($length);
    }  
   
    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        return $this->authKey;
    }

    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password) {
        return $this->pass === $password;
    }
    
    public function getUsermeta()
    {
        return $this->hasMany(Usermeta::className(), ['user_id' => 'id']);
    }
    

}
