<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

//use common\models\EDBOKOATUUL1;
use app\modules\EDBOadmin\models\KOATUUL1Search;

//use app\modules\EDBOadmin\widgets\UpdateEDBOTablesWidget;
use nirvana\showloading\ShowLoadingAsset;
ShowLoadingAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EdboDirectorytablesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Edbo Directorytables');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edbo-directorytables-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Edbo Directorytables',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin([ 'enablePushState'=>false,  'options' => ['class' => 'pjax-wraper'] ]);   ?>
    
    <?php 
       

    ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'class'=>'kartik\grid\ExpandRowColumn',
                'value'=>function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'=>function ($model, $key, $index, $column) {
                   
                    $class = 'app\\modules\\EDBOadmin\\models\\'.$model->name_directory."Search";

                    if (class_exists($class)) {
                        $searchModel_detail = new $class();
                        $dataProvider_detail = $searchModel_detail->search(Yii::$app->request->queryParams);

                        return Yii::$app->controller->renderPartial('_expand-table-details', 
                            ['dataProvider'=> $dataProvider_detail,
                            'searchModel' => $searchModel_detail,
                            ]);
                    } else {
                        return "";
                    }
                },
                //'headerOptions'=>['class'=>'kartik-sheet-style'] 
                //'disabled'=>true,
                //'detailUrl'=>Url::to(['/site/test-expand'])
            ],

            //'id',
            //'name_directory',
            [
            'attribute' => 'name_directory',
                'format' => 'html',
                'label' => Yii::t('app', 'Name_directory'),
            ],
            [
            'attribute' => 'description',
                'format' => 'html',
                'label' => Yii::t('app', 'description'),
                'value' => function ($model) {
                    if (is_null($model->description))
                        return NULL;
                    return substr($model->description, 0, 100);
                }
            ],
            [
            'attribute' => 'function',
                'format' => 'html',
                'label' => Yii::t('app', 'function'),
                'value' => function ($model) {
                    if (is_null($model->function))
                        return NULL;
                    return substr($model->function, 0, 100);
                }
            ],
            /*
           [
                'attribute' => 'created_at',
                'format' => 'html',
                'label' => Yii::t('app', 'Created_at'),
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, "php:d-m-Y H:i:s");
                    //$date = new DateTime($model->created_at, new DateTimeZone("UTC"));
                    //return $date->format('Y-m-d H:i:s');
                }
            ],*/
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
            /*
            [
            'format' => 'html',
                //'label' => Yii::t('app', ''),
                'value' => function ($model) {
                    return UpdateEDBOTablesWidget::widget(['table' => 'KOATOUUL1']);
                }
            ],*/

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{refresh}&nbsp; {view} {update} {delete}',
                'buttons' => [
                    'refresh' => function ($url, $model, $key) {
                        $url = \yii\helpers\Url::toRoute(['updatetable', 'id' => $model->id]);
                        return Html::a('<span class="glyphicon glyphicon-refresh"></span><span></span>', $url, [
                        'title' => 'Перезагрузить из ЕДБО',
                        'data-pjax' => '0', // нужно для отключения для данной ссылки стандартного обработчика pjax. Поверьте, он все портит
                        'class' => 'grid-action' // указываем ссылке класс, чтобы потом можно было на него повесить нужный JS-обработчик

                    ]);

                    }
                ],
            ],
        ],

        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
        'floatHeaderOptions' => ['scrollingTop' => true],
        //'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY
        ],

    ]); ?>
    <?php  Pjax::end();   ?>

    <?php
        $js = "
        $(function(){
            $('body').on('click', '.grid-action', function(e){
                var href = $(this).attr('href');
                var self = this;
    
                $(self).find('span').showLoading();
                //$('w1').showLoading();

                $.ajax({
                    type: 'GET',
                    url: href,
                    //data: 'action=set_allow&sessionId='+sessionId,
                    dataType: 'json',
                    timeout: 30000,
                    cache: false,
                    async: true,
                    // Выводим то что вернул PHP
                    success: function(res) {
                        $(self).find('span').hideLoading();
                        var pjax_id = $(self).closest('.pjax-wraper').attr('id');
                        $.pjax.reload('#' + pjax_id);
                        //console.log(self);
                        console.log(res)
                                                                   
                    },
                    errrep:true,//отображение ошибок error если true
                    error: function(jqXHR, exception) {
                        $(self).find('span').hideLoading();
                        //$('w1').hideLoading();
                        if (jqXHR.status === 0) {
                            alert('Not connect. Verify Network.');
                        } else if (jqXHR.status == 404) {
                            alert('Requested page not found. [404]');
                        } else if (jqXHR.status == 500) {
                            alert('Internal Server Error [500].');
                        } else if (exception === 'parsererror') {
                            alert('Requested JSON parse failed.');
                        } else if (exception === 'timeout') {
                            alert('Time out error.');
                        } else if (exception === 'abort') {
                            alert('Ajax request aborted.');
                        } else {
                            alert('Uncaught Error.' + jqXHR.responseText);
                        }
                    }
                });
                return false;
            })
        });";
        $this->registerJs($js);
    ?>

</div>
