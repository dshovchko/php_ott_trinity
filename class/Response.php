<?php

class ottTrinity_Response
{
        protected $error;
        protected $requestid;
        protected $result;
        
        public function __construct()
        {
                
        }
        
        protected function corrupted($result, $message=null)
        {
                $this->result = $result;
                $this->error = $message;
                
                ottTrinity_Log::getInstance()->debug("Error: {$message}");
                ottTrinity_Log::getInstance()->error($message);
        }
        
        protected function findElement($ar, $name)
        {
                if (array_key_exists($name, $ar))
                {
                        return $ar[$name];
                }
                return null;
        }
}