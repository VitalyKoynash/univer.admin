<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Edbouser */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Edbouser',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Edbousers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edbouser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
