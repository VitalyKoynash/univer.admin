<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
//Yii::$app->session->removeAllFlashes();
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create User', [
    'modelClass' => 'User',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

     
    <?php if(Yii::$app->session->hasFlash('error')):         
        echo '<div class="error-summary info">';
        echo Yii::$app->session->getFlash('error'); 
        echo '</div>';
    endif; ?>
    <!--?= Yii::$app->session->getFlash('error'); ?-->
    
    
    <?php 
        // 'myHideEffect'
        $this->registerJs('$(".info").animate({opacity: 1.0}, 20000).fadeOut("slow");');
    ?>
   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            //'auth_key',
            //'password_hash',
            'password_reset_token',
            'email:email',
            [
                'attribute' => 'status',
                'format' => 'html',
                'label' => Yii::t('app', 'Status'),
                'value' => function ($model) {
                    return $model->getStatusArray()[$model->status]['label'];
                    /*return UserColumn::widget([
                        'userId' => $model->id
                    ]);*/
                }
            ],
            //'status',
            //'created_at',
            [
                'attribute' => 'created_at',
                'format' => 'html',
                'label' => Yii::t('app', 'Created_at'),
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, "php:d-m-Y H:i:s");
                    //$date = new DateTime($model->created_at, new DateTimeZone("UTC"));
                    //return $date->format('Y-m-d H:i:s');
                }
            ],
            //'updated_at',
             [
                'attribute' => 'updated_at',
                'format' => 'html',
                'label' => Yii::t('app', 'Updated_at'),
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at, "php:d-m-Y H:i:s");
                    //$date = new DateTime($model->created_at, new DateTimeZone("UTC"));
                    //return $date->format('Y-m-d H:i:s');
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
