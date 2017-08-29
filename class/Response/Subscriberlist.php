<?php

class ottTrinity_Response_Subscriberlist extends ottTrinity_Response
{
        protected $subscribers = array();
        
        public function __construct($json)
        {
                $ar = json_decode($json, true);
                var_dump($ar);
                
                if (array_key_exists('requestid', $ar))
                {
                        $this->setRequestID($ar['requestid']);
                }
                
                if (array_key_exists('result', $ar))
                {
                        $this->setResult($ar['result']);
                }
                
                if (array_key_exists('subscribers', $ar))
                {
                        foreach($ar['subscribers'] as $localid=>$arl)
                        {
                                $this->addSubscriber($arl);
                        }
                }
        }
        
        protected function addSubscriber($subscriber)
        {
                $this->subscribers[] = $subscriber;
        }
}