<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\EdboDirectorytables */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edbo-directorytables-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_directory')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'description')->textArea(['rows'=>2, 'cols'=>50]) ?>
    <?= $form->field($model, 'function')->textArea(['rows'=>3, 'cols'=>50]) ?>

    <!--?= $form->field($model, 'created_at')->textInput() ?-->

    <!--?= $form->field($model, 'updated_at')->textInput() ?-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
