<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacStartController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        // добавляем разрешение "createTelemetry"
        $createTelemetry = $auth->createPermission('createTelemetry');
        $createTelemetry->description = 'Create a telemetry';
        $auth->add($createTelemetry);

        // добавляем разрешение "createUser"
        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create a user';
        $auth->add($createUser);

        // добавляем разрешение "editUser"
        $editUser = $auth->createPermission('editUser');
        $editUser->description = 'Edit a user';
        $auth->add($editUser);

        // добавляем разрешение "browseTelemmetry"
        $browseTelemetry = $auth->createPermission('browseTelemetry');
        $browseTelemetry->description = 'Browse telemetry';
        $auth->add($browseTelemetry);

        // добавляем роль "user" и даём роли разрешение "createTelemetry"
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $createTelemetry);
        $auth->addChild($user, $browseTelemetry);

        // добавляем роль "admin" и даём роли разрешение "createUser" и "editUser",
        // а также все разрешения роли "user"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $editUser);
        $auth->addChild($admin, $user);

        $bannedUser = $auth->createRole('bannedUser');
        $auth->add($bannedUser);
    }

}