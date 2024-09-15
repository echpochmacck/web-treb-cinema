<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property string $password
 * @property string $email
 * @property string $login
 * @property string $phone
 * @property string $authKey
 * @property int $id
 */
class User extends \yii\db\ActiveRecord  implements \yii\web\IdentityInterface
{


    public $password_repeat;
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
            [['name', 'surname', 'password', 'email', 'login', 'phone'], 'required'],
            [['name', 'surname', 'patronymic', 'password', 'email', 'login', 'phone', 'authKey'], 'string', 'max' => 255],
            ['email', 'email'],
            [['login', 'email'], 'unique'],
            ['password', 'string', 'min' => 4],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['phone', 'match', 'pattern' => '/^\+7\([0-9]{3}\)\-[0-9]{3}\-[0-9]{2}$/', 'message' => 'Формат +7(999)-999-99']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'password' => 'Пароль',
            'email' => 'Почта',
            'login' => 'Login',
            'phone' => 'Телефон',
            'authKey' => 'Auth Key',
            'id' => 'ID',
        ];
    }

    public static function findByUsername($login)
    {


        return self::findOne(['login' => $login]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }


    public function setAuth($save = false)
    {
        $this->authKey = Yii::$app->security->generateRandomString();
        $save && $this->save(false);
    }

    public function register()
    {
        $this->password = Yii::$app->security->generatePasswordHash($this->password);
        $this->setAuth();
        return $this->save(false);
    }
}
