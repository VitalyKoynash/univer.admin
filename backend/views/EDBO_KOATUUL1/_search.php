<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EDBO_KOATUUL1Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edbo--koatuul1-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'Id_KOATUU') ?>

    <?= $form->field($model, 'KOATUUCode') ?>

    <?= $form->field($model, 'Type') ?>

    <?= $form->field($model, 'Id_KOATUUName') ?>

    <?php // echo $form->field($model, 'KOATUUName') ?>

    <?php // echo $form->field($model, 'KOATUUFullName') ?>

    <?php // echo $form->field($model, 'KOATUUDateBegin') ?>

    <?php // echo $form->field($model, 'KOATUUDateEnd') ?>

    <?php // echo $form->field($model, 'Id_Language') ?>

    <?php // echo $form->field($model, 'KOATUUCodeL1') ?>

    <?php // echo $form->field($model, 'KOATUUCodeL2') ?>

    <?php // echo $form->field($model, 'KOATUUCodeL3') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
