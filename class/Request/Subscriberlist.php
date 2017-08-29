<?php

class ottTrinity_Request_Subscriberlist extends ottTrinity_Request
{
        public function __construct()
        {
                
        }
        
        public function query($partnerid, $salt)
        {
                $requestid = $this->generate_request_ID();
                
                $s = 'subscriberlist';
                $s.= '?requestid='.$requestid;
                $s.= '&partnerid='.$partnerid;
                $s.= '&hash='.md5($requestid.$partnerid.$salt);
                
                return $s;
        }
        
        public function response($json)
        {
                return new ottTrinity_Response_Subscriberlist($json);
        }
}