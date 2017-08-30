<?php

function __autoload_ottTrinity($class_name) 
{
        if (substr($class_name, 0, 11) != 'ottTrinity_')
        {
                return FALSE;
        }
        $filename = str_replace('_', DIRECTORY_SEPARATOR, substr($class_name, 11));

        $file = dirname(__FILE__).'/class/'.$filename.'.php';

        if ( ! file_exists($file))
        {
                return FALSE;
        }
        require $file;
}

spl_autoload_extensions('.php');
spl_autoload_register('__autoload_ottTrinity');