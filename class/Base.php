<?php

class ottTrinity_Base
{
        protected $etc;
        
        public function __construct()
        {
                $this->etc = realpath(dirname(__FILE__).'/../etc/');
        }
        
        public function getEtcPath()
        {
                return $this->etc;
        }
}
