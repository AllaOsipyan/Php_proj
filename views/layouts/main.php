<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\VueAsset;
use app\widgets\Alert;
use webvimark\modules\UserManagement\models\User;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
VueAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    use webvimark\modules\UserManagement\components\GhostMenu;
    use webvimark\modules\UserManagement\UserManagementModule;
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
    $userRole=empty($array) ? null: reset($array);

    echo Nav::widget([
        'encodeLabels'=>false,
        'activateParents'=>true,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                'label' => 'Menu',
                'items'=>[
                    ['label'=>'Rest-api', 'url'=>['/api/main/index']],
                    ['label'=>'Browsing telemetries', 'url'=>['/ui/webtelemetry/index'],
                        'visible' => $userRole!==null],
                    ['label'=>'Web-socket', 'url'=>['/socket/socket/index'],
                        'visible' => $userRole!==null],
                    ['label'=>'User management', 'url'=>['/user_management/user/index'],
                        'visible' => $userRole!==null && $userRole->name=='admin'],
                ],
            ],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->login . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();

    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
