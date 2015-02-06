<?php

namespace app\modules\EDBOtest;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\EDBOtest\controllers';


    /**
     * @inheritdoc
     */
    public $defaultRoute = 'assignment';

    /**
     * @var array 
     * @see [[items]]
     */
    private $_menus;

    /**
    * @var string Main layout using for module. Default to layout of parent module.
    * Its used when `layout` set to 'left-menu', 'right-menu' or 'top-menu'.
    */
    public $mainLayout ='@backend/modules/EDBOTest/views/layouts/main.php';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
