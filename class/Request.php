<?php

class ottTrinity_Request
{
        public function __construct()
        {
                
        }
        
        public function generate_request_ID()
        {
                $requestid = time();
                                
                return $requestid;
        }
}