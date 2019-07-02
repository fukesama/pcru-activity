<?php
namespace frontend\models;

use yii\base\Model;
use frontend\models\User;
use Yii;

/**
* Signup form
*/
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required','message'=>'โปรดระบุ {attribute}'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 6, 'message'=>'{attribute} ควรประกอบด้วยอักขระอย่างน้อย 6 อักขระ'],
            ['username', 'string', 'max' => 14,'message'=>'{attribute} ควรประกอบด้วยอักขระอย่างมาก 14 อักขระ'],



            /*['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],*/


            //['password', 'required','message'=>'โปรดระบุ {attribute}'],
            ['password', 'string', 'min' => 6],
        ];
    }
    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสผู้ใช'),
            'username' => Yii::t('app', 'ชื่อผู้ใช'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password' => Yii::t('app', 'รหัสผ่าน'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'status' => Yii::t('app', 'Status'),
            'level_user' => Yii::t('app', 'สถานะผู้ใช้0-ADMIN 1-EMPLOYEE 2-STUDENT'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }


    /**
    * Signs user up.
    *
    * @return User|null the saved model or null if saving fails
    */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        if($this->password===null||$this->password===''){
            $this->password='12345678';
        }
        //$user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
