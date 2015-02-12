<?php

namespace app\modules\EDBOadmin;
//namespace mdm\admin;

/**
 * AdminAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class EDBOAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/modules/EDBOadmin/assets';

    /**
     * @inheritdoc
     */
    /*
    public $css = [
        'main.css',
    ];
    */
    public $js = [
    ];

    public $depends = [
       'yii\web\YiiAsset',
       'yii\bootstrap\BootstrapAsset',
    ];
}
