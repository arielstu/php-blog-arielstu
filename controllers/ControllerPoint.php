<?php

class ControllerPoint
{
    private $model;
    public function __construct()
    {
        $this->model = new ModelPoint();
    }

    public function cre($point_data = array())
    {
        $this->model->cre($point_data);
    }
    public function rea($point_data = array())
    {
        return ($this->model->rea($point_data) != null) ? $this->model->rea($point_data) : false;
    }
    public function upd($point_data = array())
    {
        $this->model->upd($point_data);
    }

}