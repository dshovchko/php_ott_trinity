<?php

class ottTrinity_Response_No extends ottTrinity_Response
{
        public function __construct($request, $errormsg=null)
        {
                $this->requestid = $request->id();
                $this->corrupted('notresponse', $errormsg);
        }
}