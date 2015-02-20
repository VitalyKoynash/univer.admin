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
class EDBOGuides extends Component
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

        $this->_soap = new EDBOSoapHelper( \Yii::$app->edbo->hostEDBOGuides );
        
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
    

    /*
    * Регистрация нового пользователя на  web  сервисе
    */
    // parameters: string  User,  string Password,  
    // int ClearPreviewSession, string  ApplicationKey
    // result: string GUID сессии пользователя 
    /*
     * В случае успеха, метод возвращает GUID сессии пользователя ,  который используется при 
вызове всех последующих методов.  Возвращаемый идентификатор имеет 
фиксированный размер  в 36 байт,  (например  4FD18E5D-AAF7-4522-84D6-03AC56C35D2F).
В случае ошибки,  метод возвращает строку с кодом и описанием ошибки. 
Ошибочным считается вызов метода,  который возвращает строку  длинной  не равной  36-и
байтам. 

    по умолчанию параметры берем из базы
    */
    public function Login($User = NULL, $Password = NULL, $remembe = true) {
        // проверка статуса соап
        if (!$this->status)
            return NULL;
        // запрос пароля 
        if (is_null($Password))
            $Password = \Yii::$app->user->identity->getEdbouser()->getEDBOPassword();
        
        if (is_null($User))
            $User = \Yii::$app->user->identity->getEdbouser('email');
        
        $GUIDSession = \Yii::$app->user->identity->getGUIDSession();

        if ($remembe && EDBOSoapHelper::check_guid($GUIDSession))
        {
            \Yii::trace(__METHOD__.' guid found = '.$GUIDSession);
            return $GUIDSession;
        } 

        \Yii::trace(__METHOD__.' guid not found = '.$GUIDSession);
        
        if (!$this->status) {
            \Yii::trace(__METHOD__.' guid not init - soap error !!! ');
            return NULL;
        }

        $ApplicationKey = Yii::$app->edbo->applicationKey;
        $ClearPreviewSession = Yii::$app->edbo->clearPreviewSession;
       
        $res = $this->soap->invoke ("Login", array (
                "User" => $User ,
                "Password"=>$Password, 
                "ClearPreviewSession"=>$ClearPreviewSession,
                "ApplicationKey"=>$ApplicationKey));

        if (!$res['status'])
        {
            \Yii::trace(__METHOD__.' failed getting guid = '.$GUIDSession);
            return NULL;
        }
        
        \Yii::$app->user->identity->setGUIDSession($res['res']);

        $GUIDSession = \Yii::$app->user->identity->getGUIDSession();
        
        \Yii::trace(__METHOD__.' created guid = '.$GUIDSession);
        
        return $GUIDSession;

/*
            $languages = $this->soap->invoke("LanguagesGet", array("SessionGUID"=>$this->sessionId));

            print_r($languages);
        } else {
            echo '</br>session ID</br>';
            print $this->sessionId;
        }*/
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

    public function Logout ($SessionGUID = NULL) {
        if (is_null($SessionGUID))
            $SessionGUID = $this->Login();

        $edbouser = \Yii::$app->user->identity->getEdbouser();
        \Yii::trace(__METHOD__,Yii::$app->user->identity->username);
        if (!is_null($edbouser))
        {
            if (Yii::$app->user->identity->username == 'admin') {
                //$edbouser->password = NULL;            
                $edbouser->sessionguid = NULL;
                $edbouser->save();
            }  else {
                //check multiply users connected by edbuuser
                if (count(\Yii::$app->user->identity->getEdbouser()->getEDBOUsers(2)) <= 1)
                {
                    $edbouser->sessionguid = NULL;
                    $edbouser->save();
                }
            }

            
            
        }

        if (is_null($this->soap))
            return NULL;
        
        $res = $this->soap->invoke ( "Logout", array (
                "SessionGUID" => $SessionGUID));
        
        $data = $this->getResult($res);
        if (!is_null($data) && is_string($data) && strlen($data) == 0)
            return TRUE;

        return $data;
    }
    
    /*
     * Получения списка доступных языков используемых ЄДЕБО
     */
    public function LanguagesGet($SessionGUID = NULL) {
        
        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

         $res = $this->soap->invoke ( "LanguagesGet", array (
                "SessionGUID" => $SessionGUID));
        
        //return $res;
        return $this->getResult($res, 'dLanguages');
        //if (isset($res['res']) && isset( $res['res']['dLanguages']))
            //return $res['res']['dLanguages'];


        return NULL;
    }

        /*
    * Получение информации об ошибке при неудачном вызове всех методов web  сервиса, кроме  Login и Logout.
    */
    public function GetLastError($SessionGUID = NULL) {
        //return;
        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        $res = $this->soap->invoke ( "GetLastError", array (
                "GUIDSession" => $SessionGUID));

        return $this->getResult($res, 'dLastError');

        /*if (isset($res['res']) && isset( $res['res']['dLastError']))
            return $res['res']['dLastError'];
        return NULL;*/
    }

    /*
    * Получения информации о системе + выполняет роль контроля за состоянием подключения
    */
    public function  GlobaliInfoGet($SessionGUID = NULL) {
        $res = $this->_GlobaliInfoGet($SessionGUID);

        if (!is_null($res))
            return $res;

        if(!$this->Login(NULL, NULL, false)) 
            return NULL;

        return $this->_GlobaliInfoGet($SessionGUID);
    }

    private function  _GlobaliInfoGet($SessionGUID = NULL) {

        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;
        
         $res = $this->soap->invoke ( "GlobaliInfoGet", array (
                "SessionGUID" => $SessionGUID));

        return $this->getResult($res, 'dGloabalInfo');
        //if ($res['res'] && array_key_exists('dGloabalInfo', $res['res']))
        //    return $res['res']['dGloabalInfo'];

        //return NULL;
    }


    /*
    * Получения данных со справочника КОАТУУ  только 1-го уровня
    */
    public function  KOATUUGetL1($SessionGUID = NULL, $ActualDate = NULL, $Id_Language = NULL) {
        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        if (is_null($ActualDate))
            $ActualDate = EDBOSoapHelper::getDateNow();

        if (is_null($Id_Language))
            $Id_Language = 1; // default

        $res = $this->soap->invoke ( "KOATUUGetL1", array (
                "SessionGUID" => $SessionGUID,
                "ActualDate" => $ActualDate,
                "Id_Language" => $Id_Language      
                 )
                 );
        return $this->getResult($res, 'dKOATUU');
        
        /*if ($res['res'] && array_key_exists('dKOATUU', $res['res']))
            return $res['res']['dKOATUU'];
        return NULL;*/
    }


     /*
     * UniversitiesGet
     */
    
    public function  UniversitiesGet($SessionGUID = NULL, $UniversityKode = '', 
            $Id_Language = NULL,  $ActualDate = NULL, $UniversityName = '') {

        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        if (is_null($ActualDate))
            $ActualDate = EDBOSoapHelper::getDateNow();

        if (is_null($Id_Language))
            $Id_Language = 1;

      $res = $this->soap->invoke ( "UniversitiesGet", array (
            "SessionGUID" => $SessionGUID,
            "UniversityKode" => $UniversityKode,
            "Id_Language" => $Id_Language, 
            "ActualDate" => $ActualDate, 
            "UniversityName" => $UniversityName,
            
            ));

        return $this->getResult($res, 'dUniversities');

        /*if ($res['res'] && array_key_exists('dUniversities', $res['res']))
            return $res['res']['dUniversities'];
        return NULL;*/
    }

        /*
     * Получения справочников типов учебных заведений
     */
    public function  EducationTypesGet($SessionGUID = NULL, $Id_Language = NULL) {

         if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        if (is_null($Id_Language))
            $Id_Language = 1;


      $res = $this->soap->invoke ( "EducationTypesGet", array (
             "SessionGUID" => $SessionGUID,
             "Id_Language" => $Id_Language
              )
              );

        //return $res;
        return $this->getResult($res, 'dEducationTypes');

        /*if ($res['res'] && array_key_exists('dEducationTypes', $res['res']))
            return $res['res']['dEducationTypes'];
        return NULL;*/
    }

        /*
     * Получения справочников  типов  улиц.
     */
    public function  StreetTypesGet($SessionGUID = NULL, $Id_Language = NULL) {

        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        if (is_null($Id_Language))
            $Id_Language = 1;

        $res = $this->soap->invoke ( "StreetTypesGet", array (
             "SessionGUID" => $SessionGUID,
             "Id_Language" => $Id_Language
              )
              );

        //return $res;
        return $this->getResult($res, 'dStreetTypes');

        /*if ($res['res'] && array_key_exists('dStreetTypes', $res['res']))
            return $res['res']['dStreetTypes'];
        return NULL;*/
    }


    /*
     * Получения списка редакций специальностей
     */
    public function  SpecRedactionsGet($SessionGUID = NULL) {

        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        $res = $this->soap->invoke ( "SpecRedactionsGet", array (
             "SessionGUID" => $SessionGUID
              )
              );

        //return $res;
        return $this->getResult($res, 'dSpecRedactions');

        /*if ($res['res'] && array_key_exists('dSpecRedactions', $res['res']))
            return $res['res']['dSpecRedactions'];
        return NULL;*/
    }   


    /*
    * Получения справочников  специальностей указанной редакции
    */
    public function  SpecGet($SessionGUID = NULL, $SpecRedactionCode = '09.12.2010',  $SpecIndastryCode = '',  
            $SpecDirectionsCode = '',  $SpecSpecialityCode = '',  $SpecCode = '',  
            $SpecScecializationCode = '', $Id_Language = 1, $ActualDate = NULL,  $SpecClasifierCode = '') {

        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        if (is_null($Id_Language))
            $Id_Language = 1;

        if (is_null($ActualDate))
            $ActualDate = EDBOSoapHelper::getDateNow();

        $res = $this->soap->invoke ( "SpecGet", array (
            "SessionGUID" => $SessionGUID,
            "SpecRedactionCode" => $SpecRedactionCode,  
            "SpecIndastryCode" => $SpecIndastryCode,  
            "SpecDirectionsCode" => $SpecDirectionsCode,  
            "SpecSpecialityCode" => $SpecSpecialityCode,  
            "SpecCode" => $SpecCode,  
            "SpecScecializationCode" => $SpecScecializationCode, 
            "Id_Language" => $Id_Language, 
            "ActualDate" => $ActualDate,  
            "SpecClasifierCode" => $SpecClasifierCode
        ));

        return $this->getResult($res, 'dSpec');
        //return $res;
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
        //return $res;
    }

}
