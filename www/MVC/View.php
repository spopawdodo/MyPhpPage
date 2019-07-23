<?php

class View{

    private $data = [];

    public function display($templateName){
        $fileName = __DIR__.DIRECTORY_SEPARATOR."Templates".DIRECTORY_SEPARATOR.$templateName.".php";
        if (!file_exists($fileName)){
            throw new Exception( "Template not found!");
        }
        require ($fileName);
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function get($key)
    {
        return $this->data[$key];
    }
}