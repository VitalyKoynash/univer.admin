<?php
namespace app\modules\EDBOadmin\components;


use Yii;
use yii\base\Object;


/**
 * 
 *
 * @author Vitaly Koynash <vitaly.koynash@gmail.com>
 * @since 1.0
 */
class UpdateFromEDBO extends Object
{
    
    static public function update($id) {

        $model = EdboDirectorytables::findOne($id);

        $class = 'common\\models\\EDBO'.$model->name_directory;

        if (!class_exists($class)) return false;

        //{$class}::find()->asArray()->all();

        if ($model)
            $model->save();

        return true;
    }

}

/*
    static public function LoadTableFromEDBO($id) {

        $model = EdboDirectorytables::findOne($id);

        $class = 'common\\models\\EDBO'.$model->name_directory;

        if (!class_exists($class)) return false;

        if ($model)
            $model->save();

        return true;
    }
*/