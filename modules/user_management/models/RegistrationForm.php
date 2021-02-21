<?php


namespace app\modules\user_management\models;


use app\models\User;
use Exception;
use Yii;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $login;
    public $password;
    public $isAdmin = true;
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['login', 'password'], 'required'],

            ['login', 'unique',
                'targetClass' => '\app\models\User',
                'message' => 'This username has already been taken.'
            ],

        ];
    }



    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function createUser(): bool
    {
        if ($this->validate()) {
            $user = new User();
            $user->setLogin($this->login);
            $user->setPassword($this->password);
            $user->generateAccessToken();
            $user->save(false);
            $auth = Yii::$app->authManager;
            if($this->isAdmin){
                $authorRole = $auth->getRole('admin');
            } else {
                $authorRole = $auth->getRole('user');
            }
            $auth->assign($authorRole, $user->getId());

            return true;
        }
        return false;
    }
    public function register(): bool
    {
        if ($this->validate()) {
            return true;
        }
        return false;
    }
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

}