<?php


namespace app\modules\user_management\models;


use app\models\User;
use Exception;
use Yii;
use yii\base\Model;

class UserForm extends Model
{
    public $id;
    public $login;
    public $password;
    public $role;
    public $status;
    public $isBanned = false;
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



    public function validateActive()
    {
        if ($this->validate()) {
            if(\Yii::$app->authManager->getRolesByUser($this->id)!='banned') {
                $this->isBanned = true;
            }
        }
        $this->isBanned = false;
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