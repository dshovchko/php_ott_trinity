<?php

class ottTrinity_Response_Subscriberlist extends ottTrinity_Response
{
        protected $subscribers = array();
        
        public function __construct($request, $json)
        {
                $data = json_decode($json, true);
                
                $this->requestid = $this->findElement($data, 'requestid');
                $this->result = $this->findElement($data, 'result');
                $this->subscribers = $this->findElement($data, 'subscribers2');
                
                if ( ! isset($this->requestid, $this->result, $this->subscribers))
                {
                        $this->corrupted('badresponse', 'Response does not contain the required fields');
                        
                        return;
                }
                if ( ! $this->match($request))
                {
                        $this->corrupted('badresponse', 'This is the response to another request');
                        
                        return;
                }
        }
}