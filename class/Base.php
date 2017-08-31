<?php

class ottTrinity_Base
{
        protected $etc;
        
        public function __construct($debug=false)
        {
                $this->etc = realpath(dirname(__FILE__).'/../etc/');
                ottTrinity_Log::$path = realpath(dirname(__FILE__).'/../log/');
                ottTrinity_Log::$prefix = 'ottTrinity';
                ottTrinity_Log::$debug = $debug;
        }
        
        public function getEtcPath()
        {
                return $this->etc;
        }
}
