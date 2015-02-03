<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Edbouser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edbouser-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <!--?= $form->field($model, 'sessionguid')->textInput(['maxlength' => 36]) ?-->

    <!--?= $form->field($model, 'sessionguid_updated_at')->textInput() ?-->

    <!--?= $form->field($model, 'status')->textInput() ?-->

    <!--?= $form->field($model, 'created_at')->textInput() ?-->

    <!--?= $form->field($model, 'updated_at')->textInput() ?-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
