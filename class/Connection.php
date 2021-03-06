<?php

class ottTrinity_Connection
{
        protected $partnerid = 0;
        
        protected $salt = 'abcdef';
        
        protected $logpath;
        protected $logprefix = 'ottTrinity';
        
        public function __construct($debug = false, $settingsfile = null)
        {
                $this->logpath = realpath(dirname(__FILE__).'/../log/');
                $path = realpath(dirname(__FILE__).'/../etc/');
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
                        if (array_key_exists('logpath', $settings))
                        {
                                $this->logpath = $settings['logpath'];
                        }
                        if (array_key_exists('logprefix', $settings))
                        {
                                $this->logprefix = $settings['logprefix'];
                        }
                }
                
                ottTrinity_Log::$path = $this->logpath;
                ottTrinity_Log::$prefix = $this->logprefix;
                ottTrinity_Log::$debug = $debug;
                ottTrinity_Log::getInstance()->debug("connection initialized");
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
                                if (substr($param, 0, 1) != '#')
                                {
                                        $result[$param] = $value;
                                }
                        }
                        return $result;
                }
                return null;
        }
}