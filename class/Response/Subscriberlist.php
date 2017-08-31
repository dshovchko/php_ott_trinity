<?php

class ottTrinity_Response_Subscriberlist extends ottTrinity_Response
{
        protected $subscribers = array();
        
        public function __construct($request, $json)
        {
                $data = json_decode($json, true);
                
                $this->requestid = $this->findElement($data, 'requestid');
                $this->result = $this->findElement($data, 'result');
                $this->subscribers = $this->findElement($data, 'subscribers');
                
                if ( ! isset($this->requestid, $this->result, $this->subscribers))
                {
                        $this->corrupted('badresponse', 'Response does not contain the required fields');
                        
                        return;
                }
                if ( ! $this->match_request($request))
                {
                        $this->corrupted('badresponse', 'This is the response to another request');
                        
                        return;
                }
                if ( ! $this->is_correct_subscribers())
                {
                        $this->corrupted('badresponse', 'Response contains an incorrect field \'subscribers\'');
                        
                        return;
                }
        }
        
        public function subscribers()
        {
                return $this->subscribers;
        }
        
        protected function is_correct_subscribers()
        {
                if ( ! is_array($this->subscribers))
                {
                        return false;
                }
                
                foreach($this->subscribers as $id=>$ar)
                {
                        if ( ! is_array($ar))
                        {
                                return false;
                        }
                        if ( ! array_key_exists('subscrid', $ar))
                        {
                                return false;
                        }
                        if ( ! array_key_exists('subscrprice', $ar))
                        {
                                return false;
                        }
                        if ( ! array_key_exists('subscrstatusid', $ar))
                        {
                                return false;
                        }
                }
                return true;
        }
}