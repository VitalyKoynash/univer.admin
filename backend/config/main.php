<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'DSEA EDBO admin panel',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU', 
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu', // default null. other avaliable value 'right-menu'
            /*
            'assignment' => [
                    'label' => 'Grand Access' // change label
                ],
                'route' => null, // disable menu
            */
        ],
        'EDBOadmin' => [
            'class' => 'app\modules\EDBOadmin\Module',
            'layout' => 'left-menu', // default null. other avaliable value 'right-menu'
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
         'authManager' => [
            'class' => 'yii\rbac\DbManager', //'yii\rbac\PhpManager',
        ],
        'urlManager' => [
            //'enablePrettyUrl' => true,
            //'showScriptName' => false,
            //'rules' => [
             //   '<controller>/<action>' => '<controller>/<action>',
            //]
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'admin/*', // add or remove allowed actions to this list
        ]
    ],
    'params' => $params,
];
