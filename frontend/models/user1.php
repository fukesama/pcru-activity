<?php

namespace frontend\models;

use Yii;

use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use frontend\models\User;
use yii\db\Expression;
use common\models\ThaiDate;
/**
* This is the model class for table "user".
* @property UserCollegian $userCollegian
* @property UserOfficer $userOfficer
*/
class User1 extends \yii\db\ActiveRecord
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const ADMIN = '0';
    const OFFICER = '1';
    const COLLEGIAN = '2';


    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'user';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['password_hash'],'string'],
          /*  [['username'], 'required','message'=>'กรุณากรอกชื่อผู้ใช้'],*/
           /* [['status'], 'integer'],
            ['status', 'default', 'value' => 10],
            [['created_at', 'updated_at'], 'datetime'],
            [['level_user'], 'integer'],

            [['username',  'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique','message'=>'ชื่อผู้ใช้ซ้ำ'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],*/
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
            
            'username' => Yii::t('app', 'ชื่อผู้ใช้'),
           
        ];
    }

   
}
