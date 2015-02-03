<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'password_hash')->passwordInput() ?>
    <?= $form->field($model, 'email')->input('email') ?>
    <?= $form->field($model, 'password_reset_token')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(
            $model->getStatusArray('dropDownList'),           // Flat array ('id'=>'label')
            ['prompt'=>'',
            'default'=>2,
            ]    // options
        );

    ?>
    <?= $form->field($model, 'edbouser')->dropDownList(
            $model->getEDBOUsersArray(),           // Flat array ('id'=>'label')
            ['prompt'=>'',
            'default'=>$model->getEDBOUserId(),
            ]    // options
        );

    ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
