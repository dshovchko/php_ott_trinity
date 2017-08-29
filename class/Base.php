<?php

class ottTrinity_Base
{
        protected $etc;
        
        public function __construct()
        {
                $this->setEtcPath(realpath(dirname(__FILE__).'/../etc/'));
        }
        
        protected function setEtcPath($path)
        {
                $this->etc = $path;
        }
        
        public function getEtcPath()
        {
                return $this->etc;
        }
}
