<?php

namespace common\components;

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
    private $_soap = NULL;
    private $_try_init_flag = false;

    
    public function init(){

        if ($this->_try_init_flag && is_null($this->_soap)) // SOAP ERROR!
            return FALSE;
        
        $this->_try_init_flag = TRUE;

        $soap_address = \Yii::$app->edbo->hostEDBOGuides;
        if (is_null($this->_soap))
            $this->_soap = new EDBOSoapHelper($soap_address);
        
        if (!$this->_soap->status) {
            $this->_soap = NULL;
            return FALSE;
        }
        return TRUE;
    }

    public function info(){
        return $this->init() ? 'true' : 'false';
    }

    public function getStatus() {
        return $this->init();
    }

}
