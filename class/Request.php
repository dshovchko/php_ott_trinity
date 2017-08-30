<?php

class ottTrinity_Request
{
        public function __construct()
        {
                
        }
        
        public function generate_request_ID()
        {
                $m = microtime(true);
                                
                return sprintf("%d%07d", floor($m), ($m-floor($m))*1000000);
        }
}