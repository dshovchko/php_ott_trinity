<?php

class ottTrinity_Response
{
        protected $error;
        protected $requestid;
        protected $result;
        
        public function __construct()
        {
                
        }
        
        public function requestid()
        {
                return $this->requestid;
        }
        
        public function result()
        {
                return $this->result;
        }
        
        public function error()
        {
                return $this->error;
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
        
        protected function match_request($request)
        {
                if ($this->requestid != $request->id())
                {
                        return false;
                }
                return true;
        }
}