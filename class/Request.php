<?php

class ottTrinity_Request
{
        protected $name;
        protected $id;
        
        public function __construct()
        {
                /*
                 *      generation of a request id
                 */
                $m = microtime(true);
                                
                $this->id = sprintf("%d%07d", floor($m), ($m-floor($m))*1000000);
        }
        
        public function name()
        {
                return (isset($this->name)?$this->name:'unknown');
        }
        
        public function id()
        {
                return $this->id;
        }
}