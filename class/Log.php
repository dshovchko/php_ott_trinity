<?php

class ottTrinity_Log
{
        private static $_log;
        
        public static $path;
        public static $prefix;
        public static $debug = false;
        
        protected $_messages = array();
        protected $_errors = array();
        protected $_debugs = array();
        
        public static function getInstance()
        {
                if (null === self::$_log) {
                        self::$_log = new self();
                        
                        // Write the logs at shutdown
                        register_shutdown_function(array(self::$_log, 'write'));
                }
                
                return self::$_log;
        }
        
        private function __construct()
        {
                $this->_messages[] = $this->format('start');
                if (self::$debug === TRUE)
                {
                        $this->_debugs[] = 'start debugging at ' . strftime('%d.%m.%Y %H:%M:%S') . PHP_EOL;
                }
        }
        
        private function __clone()
        {
        }
        
        private function __wakeup()
        {
        }
        
        public function add($message)
        {
                $this->_messages[] = $this->format($message);
        }
        
        public function error($message)
        {
                $this->_errors[] = $this->format($message);
        }
        
        public function debug($message)
        {
                $this->_debugs[] = $this->format($message);
        }
        
        public function write()
        {
                $this->_messages[] = $this->format('stop');
                if (self::$debug === TRUE)
                {
                        $this->_debugs[] = 'stop debugging at ' . strftime('%d.%m.%Y %H:%M:%S') . PHP_EOL;
                        $this->_debugs[] = PHP_EOL . PHP_EOL;
                }
                
                if (!empty($this->_messages))
                {
                    $this->_write($this->_messages, self::$path . '/' . self::$prefix . '.log');
                    $this->_messages = array();
                }
                if (!empty($this->_debugs))
                {
                    $this->_write($this->_debugs, self::$path . '/' . self::$prefix . '_debug.log');
                    $this->_debugs = array();
                }
                if (!empty($this->_errors))
                {
                    $this->_write($this->_errors, self::$path . '/' . self::$prefix . '_error.log');
                    $this->_errors = array();
                }
        }
        
        protected function _write($messages, $file)
        {
                $f = @fopen($file, 'a');
                if ($f === false)
                {
                        throw new Exception("Logfile $file is not writeable!");
                }
                
                foreach($messages as $msg)
                {
                        fwrite($f, $msg);
                }
                
                fclose($f);
        }
        
        protected function format($message)
        {
                return sprintf("%s [%05d]: %s".PHP_EOL, strftime('%d.%m.%Y %H:%M:%S'), getmypid(), $message);
        }
}