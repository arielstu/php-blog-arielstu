<?php

class ControllerSession
{
    private $session;
    public function __construct()
    {
        $this->session = new ModelUser();
    }

    
}