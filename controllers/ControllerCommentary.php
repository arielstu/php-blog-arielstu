<?php

class ControllerCommentary
{
    private $model;
    public function __construct()
    {
        $this->model = new ModelCommentary();
    }

    public function cre($comment_data = array())
    {
        $validador = new ValidatorCommentary();
        if ($validador->validate_cre_upd($comment_data)) {
            $this->model->cre($validador->comment);
            return true;
        } else {
            return $validador->error_list;
        }
    }

    public function upd($comment_data = array())
    {
        $validador = new ValidatorCommentary();
        if ($validador->validate_cre_upd($comment_data)) {
            $this->model->upd($validador->comment);
            return true;
        } else {
            return $validador->error_list;
        }
    }

    public function rea($comment_data = array())
    {
        return $this->model->rea($comment_data);
    }

    public function del($comment_data = array(), $article = '')
    {
        $this->model->del($comment_data, $article);
    }
}