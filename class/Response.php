<?php

class ottTrinity_Response
{
        protected $error;
        protected $requestid;
        protected $result;
        
        public function __construct()
        {
                
        }
        
        protected function setRequestID($requestid)
        {
                $this->requestid = $requestid;
        }
        
        protected function setResult($result)
        {
                $this->result = $result;
        }
}