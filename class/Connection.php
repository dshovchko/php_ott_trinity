<?php

class ottTrinity_Connection extends ottTrinity_Base
{
        protected $partnerid = 0;
        
        protected $salt = 'abcdef';
        
        public function __construct($logging = false, $settingsfile = null)
        {
                parent::__construct();
                
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
                        $this->setPartnerID($settings['partnerID']);
                        $this->setSalt($settings['SALT']);
                }
        }
        
        public function setPartnerID($partnerid)
        {
                $this->partnerid = $partnerid;
        }
        
        public function getPartnerID()
        {
                return $this->partnerid;
        }
        
        public function setSalt($salt)
        {
                $this->salt = $salt;
        }
        
        public function getSalt()
        {
                return $this->salt;
        }
        
        public function send($request)
        {
                $query = $request->query($this->getPartnerID(), $this->getSalt());
                
                $json = @file_get_contents('http://partners.trinity-tv.net/partners/user/'.$query);
                if ($json === false)
                {
                        //$response = new
                        return null;
                }
                $response = $request->response($json);
                print_r($response);
                
                return $response;
        }
        
        protected function loadSettings($directory, $settingsfile)
        {
                $result = array();
                if (is_readable($directory . '/'.$settingsfile))
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