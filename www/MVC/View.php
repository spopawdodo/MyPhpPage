<?php

class View{

    private $data = [];

    public function display($templateName, bool $active = false, bool $displayNav = true){

        if ($displayNav) {
            if ($active) {
                //We have a user logged in
                $this->displayNavBar();
            } else {
                //Guest user
                $this->displayLogo();
            }
        }

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

    private function displayNavBar(){
        $fileName = __DIR__.DIRECTORY_SEPARATOR."Templates".DIRECTORY_SEPARATOR."Navbar.php";
        if (!file_exists($fileName)){
            throw new Exception( "Template not found!");
        }
        require ($fileName);
    }

    private function displayLogo(){
        $fileName = __DIR__.DIRECTORY_SEPARATOR."Templates".DIRECTORY_SEPARATOR."Logo.php";
        if (!file_exists($fileName)){
            throw new Exception( "Template not found!");
        }
        require ($fileName);
    }
}