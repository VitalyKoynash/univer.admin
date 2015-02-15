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
    */
    public function Login($User = NULL, $Password = NULL, $remembe = true) {

        if (!$this->status)
            return NULL;

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

        //return;
        
        $res = $this->soap->invoke ( "Logout", array (
                "SessionGUID" => $SessionGUID));
            
        if (strlen($res['res']) == 0)
            return TRUE;

        return $res['res'];
    }
    
    /*
     * Получения списка доступных языков используемых ЄДЕБО
     */
    public function LanguagesGet($SessionGUID = NULL) {
        return;
        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

         $res = $this->soap->invoke ( "LanguagesGet", array (
                "SessionGUID" => $SessionGUID));
        
        return $res;

        if (isset($res['res']) && isset( $res['res']['dLanguages']))
            return $res['res']['dLanguages'];


        return NULL;
    }

        /*
    * Получение информации об ошибке при неудачном вызове всех методов web  сервиса, кроме  Login и Logout.
    */
    public function GetLastError($SessionGUID = NULL) {
        return;
        if (is_null($SessionGUID))
            if(!$SessionGUID = $this->Login()) return NULL;

        $res = $this->soap->invoke ( "GetLastError", array (
                "GUIDSession" => $SessionGUID));
        /*
        if ($res == NULL) {
            //error getting error
            $res = $this->soap->invoke ( "GetLastError", array (
                "SessionGUID" => $GUIDSession));
            if ($res == NULL) {
                return "Unknow EDBO error";
            }

        }
        */
        return $res;
        if (isset($res['res']) && isset( $res['res']['dLastError']))
            return $res['res']['dLastError'];
        return NULL;
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

        if ($res['res'] && array_key_exists('dGloabalInfo', $res['res']))
            return $res['res']['dGloabalInfo'];

        return NULL;
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

        if ($res['res'] && array_key_exists('dKOATUU', $res['res']))
            return $res['res']['dKOATUU'];
        return NULL;
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

        
        if ($res['res'] && array_key_exists('dUniversities', $res['res']))
            return $res['res']['dUniversities'];
        return NULL;
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

        if ($res['res'] && array_key_exists('dEducationTypes', $res['res']))
            return $res['res']['dEducationTypes'];
        return NULL;
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

        if ($res['res'] && array_key_exists('dStreetTypes', $res['res']))
            return $res['res']['dStreetTypes'];
        return NULL;
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

        if ($res['res'] && array_key_exists('dSpecRedactions', $res['res']))
            return $res['res']['dSpecRedactions'];
        return NULL;
    }   

}
