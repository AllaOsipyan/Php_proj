<?php
use yii\helpers\Html;
?>
<div>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::a('Create new user', ['/user_management/user/register'], ['class'=>'btn btn-primary']) ?>
        </div>
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::a('Show users', ['/user_management/user/showusers'], ['class'=>'btn btn-primary']) ?>
        </div>
    </div>
</div>
