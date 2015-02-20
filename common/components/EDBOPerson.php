<?php

namespace common\components;

use Yii;
use yii\base\Component;
//use yii\base\Event;
use common\components\EDBOSoapHelper;

/**
 * 
 *
 * @author Vitaly Koynash <vitaly.koynash@gmail.com>
 * @since 1.0
 */
class EDBOPerson extends Component
{
    private $_soap = NULL; // EDBOSOapHelper

    /* флаг, сигнализирующий, что была попытка инициализировать SOAP
    *  Предотвращает повторную загрузку при сбоях соединения с СОАП
    */
    private $firstInit = true; 

    
    private function initSoap(){

        // не первая инициализация и создан объект соап
        if (!$this->firstInit && !is_null($this->_soap)) {
            return $this->_soap;
        } elseif (!$this->firstInit && is_null($this->_soap)) {
            \Yii::warning("initSoap (1) - NULL");
            return NULL;
        }
        
        
        $this->firstInit = false; // ставим флаг попытки инициализации

        $this->_soap = new EDBOSoapHelper( \Yii::$app->edbo->hostEDBOPerson );
        
        if (!$this->_soap->statusSoap) {
            $this->_soap = NULL;
            \Yii::warning("initSoap (2) - NULL");
            return NULL;
        }
        return $this->_soap ;
    }

    public function getStatus() {
        return !is_null($this->initSoap());
    }

    public function getSoap() {
        return $this->initSoap();
    }
    

    

    static private function getResult ($res, $param = NULL) {
        
        if (is_null($res) || !is_array($res))
            return NULL;

        if (is_null($param))
            return $res['res'];

        if ($res['res'] && array_key_exists($param, $res['res']))
            return $res['res'][$param];

        return NULL;
    }

    /*
     * Получения  справочников  школьных  предметов.
     */
    public function  SubjectsGet($SessionGUID = NULL, $Id_Language = NULL, $ActualDate = NULL) {
        
        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        if (is_null($Id_Language))
            $Id_Language = 1;

        if (is_null($ActualDate))
            $ActualDate = EDBOSoapHelper::getDateNow();
        
        $res = $this->soap->invoke ( "SubjectsGet", array (
            "SessionGUID" => $SessionGUID,
            "Id_Language" => $Id_Language, 
            "ActualDate" => $ActualDate,  
            ));



        return $this->getResult($res, 'dSubjects');
        
    }

}
