<?php
namespace frontend\models;

use common\models\Role;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirm_password;


    const SCENARIO_WITH_PASSWORD = 'withPassword';


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            [['email'], 'email'],
            [['password', 'confirm_password'], 'required',
                'on' => [self::SCENARIO_WITH_PASSWORD],
                'when' => function ($model) { return empty($model->confirm_password) && empty($model->password); },
                'whenClient' => 'function (attribute, value) { return !(' . (int) !empty($this->confirm_password) . ' || value != "") || $("#user-password").val() != ""; }',
            ],
            [['password', 'confirm_password'], 'string', 'min' => 8],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User(['scenario' => User::SCENARIO_USER]);
        $user->username = $this->username;
        $user->email = $this->email;
        $user->role = Role::ROLE_USER;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user->save() && $this->sendEmail($user);

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
