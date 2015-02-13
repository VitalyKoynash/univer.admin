<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EDBOKOATUUL1 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edbokoatuul1-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Id_KOATUU')->textInput() ?>

    <?= $form->field($model, 'KOATUUCode')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'Type')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'Id_KOATUUName')->textInput() ?>

    <?= $form->field($model, 'KOATUUName')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'KOATUUFullName')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'KOATUUDateBegin')->textInput() ?>

    <?= $form->field($model, 'KOATUUDateEnd')->textInput() ?>

    <?= $form->field($model, 'Id_Language')->textInput() ?>

    <?= $form->field($model, 'KOATUUCodeL1')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'KOATUUCodeL2')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'KOATUUCodeL3')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
