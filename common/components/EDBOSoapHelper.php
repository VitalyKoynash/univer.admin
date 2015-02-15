<?php
namespace common\components;
use yii\base\Object;

/**
 * Soap for DEBO
 *
 * @author VItaly Koynash
 */
class EDBOSoapHelper extends Object 
{
    
    private $soapClient ;
    private $debug = TRUE;
    private $_status_message = '';


    public function __construct($soap_address) {

            try {
                \Yii::beginProfile(__METHOD__);
                $this->soapClient = new \SoapClient ($soap_address, [
                    'encoding'=>'utf-8',
                    "exceptions" => 1,
                    'cache_wsdl' => \WSDL_CACHE_MEMORY,
                    ]);
                \Yii::endProfile('_soapClient');
                \Yii::trace("succesfully connect to ".$soap_address);
             } catch (\SoapFault  $ex) { /*SoapFault*/
                
                $this->soapClient = NULL;
                $this->_status_message = $ex->faultstring;
                \Yii::warning("error connect to ".$soap_address.' '.$this->_status_message);
            }   

    }


   
    public function getStatusSoap() {
        return !is_null($this->soapClient);
    }


    private function buildObject($data) {

        if (!(is_array($data) || is_object($data) || is_null($data))) return $data;

        $res = array();
        foreach ($data as $key => $value) {
            switch (gettype($value)){
                case "string":
                    $res[$key] = $value; break;
                case "integer":
                    $res[$key] = $value; break;
                case "int":
                    $res[$key] = $value; break;
                case "any":
                    $res[$key] = simplexml_load_string("<?xml version=\"1.0\"?><document>".$value."</document>"); break;
                default:
                    $res[$key] = $this->buildObject($value);  break;
            }
        }
        return $res;
    }

    public function invoke ($method, $params) {
        
        $res = array('status' => FALSE,'message' => $this->_status_message,'res' => NULL, 'soap' => NULL);
        
        if (!$this->statusSoap) return  $res;

        if ($this->debug)
            \Yii::beginProfile($method);
        
        $message = '';
        try {
                        
            $invs = $this->soapClient->__soapCall ($method, array($params));
            $result_from_soap = $invs->{$method."Result"};
            $result = $this->buildObject($result_from_soap);

            $res['status'] = TRUE;
            $res['message'] = $message;
            $res['res'] = $result;
            $res['soap'] = $result_from_soap;
            
        } catch (\Exception $ex) {
            
            $message = $ex->getMessage() .'\n'.print_r($params, true) ;
            
            \Yii::warning($message);
            
            $res['status'] = FALSE;
            $res['message'] = $message;
            $res['res'] = NULL;
        }
        if ($this->debug)
            \Yii::endProfile($method);
        return $res;
    }


    static public function check_guid ($sessionId) {
        if (is_null($sessionId)) {
            return FALSE;
        }
        return preg_match("/([a-f\d]{8})-([a-f\d]{4})-([a-f\d]{4})-([a-f\d]{4})-([a-f\d]{12})/i", $sessionId)==0?FALSE:TRUE;
    }

    static public function getDateNow () {
        return date ("d.m.Y h:i:s");
    }
      

}
