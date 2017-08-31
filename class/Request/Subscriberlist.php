<?php

class ottTrinity_Request_Subscriberlist extends ottTrinity_Request
{
        protected $name = 'subscriberlist';
        
        public function __construct()
        {
                parent::__construct();
        }
        
        public function query($partnerid, $salt)
        {
                return $this->name()
                . '?requestid='.$this->id()
                . '&partnerid='.$partnerid
                . '&hash='.md5($this->id().$partnerid.$salt);
        }
        
        public function response($json)
        {
                return new ottTrinity_Response_Subscriberlist($this, $json);
        }
}