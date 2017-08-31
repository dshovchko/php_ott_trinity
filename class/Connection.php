<?php

class ottTrinity_Connection extends ottTrinity_Base
{
        protected $partnerid = 0;
        
        protected $salt = 'abcdef';
        
        public function __construct($debug = false, $settingsfile = null)
        {
                parent::__construct($debug);
                
                $path = $this->getEtcPath();
                if (!$settingsfile)
                {
                        $settingsfile = 'ottTrinity.ini';
                }
                
                $sf = pathinfo($settingsfile);
                if ($sf['dirname'] != '.')
                {
                        $path = $sf['dirname'];
                        $settingsfile = $sf['basename'];
                }
                
                if ($settings = $this->loadSettings($path, $settingsfile))
                {
                        if (array_key_exists('partnerID', $settings))
                        {
                                $this->partnerid = $settings['partnerID'];
                        }
                        if (array_key_exists('SALT', $settings))
                        {
                                $this->salt = $settings['SALT'];
                        }
                }
        }
        
        public function send($request)
        {
                $query = $request->query($this->partnerid, $this->salt);
                ottTrinity_Log::getInstance()->debug("query: {$query}");
                ottTrinity_Log::getInstance()->add("send request '{$request->name()}'");
                
                $json = @file_get_contents('http://partners.trinity-tv.net/partners/user/'.$query);
                if ($json === false)
                {
                        // not response
                        return  new ottTrinity_Response_No($request, 'Can not receive a response to a request');
                }
                ottTrinity_Log::getInstance()->debug("get json: {$json}");
                
                $response = $request->response($json);
                
                return $response;
        }
        
        protected function loadSettings($directory, $settingsfile)
        {
                $result = array();
                if (is_readable($directory . '/' . $settingsfile))
                {
                        $settings = file($directory . '/' . $settingsfile, FILE_IGNORE_NEW_LINES);
                        foreach ($settings as $setting)
                        {
                                list($param, $value) = explode('=', $setting, 2);
                                $param = trim($param);
                                $value = trim($value);
                                $result[$param] = $value;
                        }
                        return $result;
                }
                return null;
        }
}