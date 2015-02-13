<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\EdboDirectorytables */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Edbo Directorytables',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Edbo Directorytables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edbo-directorytables-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
