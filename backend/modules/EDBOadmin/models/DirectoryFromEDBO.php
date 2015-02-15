<?php

namespace app\modules\EDBOadmin\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;

use app\modules\EDBOadmin\models\EdboDirectorytables;

class DirectoryFromEDBO extends Model
{

    private $_result;
    public $id_directory; // ID справочника
    public $show_table = true;
    private $_array_provider;
    private $directory;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_directory', 'show_table'], 'required'],

        ];
    }

    public function loadEDBO (){

        return !is_null($this->loadFromEDBO($this->id_directory));

    }

    private function loadFromEDBO($id) {
        
        
        //$this->_result = \Yii::$app->edbo->EDBOGuides->KOATUUGetL1();
        //return $this->_result;

        $this->directory = EdboDirectorytables::find()
                        ->where(['id' => $id])
                        ->one();
        if (is_null($this->directory))
            return  NULL;

        $name_directory = $this->directory->name_directory;

        if ($name_directory == 'KOATUUL1') {

            $this->getFromCache ('KOATUUL1', 'KOATUUGetL1');
          
        } elseif ($name_directory == 'Universities') {

            $this->getFromCache ('Universities', 'UniversitiesGet');
            //$this->_result = \Yii::$app->edbo->EDBOGuides->UniversitiesGet();
        } elseif ( $name_directory == 'GlobaliInfo') {

            $this->getFromCache ('GlobaliInfo', 'GlobaliInfoGet');
            //$this->_result = \Yii::$app->edbo->EDBOGuides->GlobaliInfoGet();
        } elseif ( $name_directory == 'EducationTypes') {

            $this->getFromCache ('EducationTypes', 'EducationTypesGet');
            //$this->_result = \Yii::$app->edbo->EDBOGuides->EducationTypesGet();
        } elseif ( $name_directory == 'StreetTypes') {

            $this->getFromCache ('StreetTypes', 'StreetTypesGet');
            //$this->_result = \Yii::$app->edbo->EDBOGuides->StreetTypesGet();
        } elseif ( $name_directory == 'SpecRedactions') {

            $this->getFromCache ('SpecRedactions', 'SpecRedactionsGet');
            //$this->_result = \Yii::$app->edbo->EDBOGuides->SpecRedactionsGet();
        }
        return $this->_result;
    }

    private function getFromCache ($name, $funcName, $expired = 3600, $useCache = true) {
        $cache = \Yii::$app->cache;
        $data = $cache->get($name);
        if ( $useCache && ($data === false) && empty(trim($data))) {
            $this->_result = \Yii::$app->edbo->EDBOGuides->{$funcName}();
            $cache->set($name, $this->_result, $expired);
            //\Yii::trace('Use cache for ' . $name);
        } else {
            $this->_result = $cache->get($name);
            \Yii::trace('Use cache for ' . $name);
        }
    }

    public function getTableName () {
        if (is_null($this->directory))
            return  NULL;
        return $this->directory->name_directory;
    }

    public function getTableDescription () {
        if (is_null($this->directory))
            return  NULL;
        return $this->directory->description;
    }

    private function initProvider() {
       
        if (is_null($this->_result))
           return NULL;

        if (!is_null($this->_array_provider))
            return $this->_array_provider;
        
        $arr = NULL;
        if (array_key_exists(0,$this->_result)){
            $arr = $this->_result;
        } elseif (is_array($this->_result)) {
            $arr[] = $this->_result;
        }

        $this->_array_provider = new ArrayDataProvider([
        'allModels' => $arr,
        
        'sort' =>  [
            'attributes' => $this->EDBOTableColumns,
        ],
        'pagination' => [
            'pageSize' => 10,
        ],
        ]);
    }
    public function getEDBOTableProvider (){
        
        $this->initProvider();
        
        //if (is_null($this->_array_provider))
        //    $this->loadEDBO ();
        return $this->_array_provider;
    }

    public function getEDBOTableColumns (){
        
        if (is_null($this->_result))
            return [];

        $col = [];

        if (array_key_exists(0,$this->_result)){
            foreach ($this->_result[0] as $key => $value) {
                $col[] = $key;
            }
        } elseif (is_array($this->_result)) {
            foreach ($this->_result as $key => $value) {
                $col[] = $key;
            }
        }

        return $col;
    }

    public function getEDBORequest (){
        //return [];
        //if (is_null($this->_array_provider))
        //    $this->loadEDBO ();

        //return ['id_directory' => $this->id_directory];
        return  $this->_result;
    }

    //private function getEDBOFunctionResult
    /**
     * @inheritdoc
     */
    /*
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_directory' => Yii::t('app', 'Name Directory'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    */



}
