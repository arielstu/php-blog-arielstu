<?php

class ControllerArticle
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelArticle();
    }

    public function cre($article_data = array())
    {
        $validador = new ValidatorArticle();

        if ($validador->validate_cre_upd($article_data)) {
            $this->model->cre($validador->article);
            return true;
        } else {
            return $validador->error_list;
        }
    }

    public function upd($article_data = array())
    {
        $validador = new ValidatorArticle();

        if ($validador->validate_cre_upd($article_data)) {
            $this->model->upd($validador->article);
            return true;
        } else {
            return $validador->error_list;
        }
    }
    public function rea($article_data = array(), $inicio = 0, $post_por_pagina = 5)
    {

        return $this->model->rea($article_data, $inicio, $post_por_pagina);
    }
    public function rea_buscar($article_data = array(), $inicio = 0, $post_por_pagina = 5)
    {
        return $this->model->rea_buscar($article_data, $inicio, $post_por_pagina);
    }
    public function rea_for_user($article_data = array())
    {
        return $this->model->rea_for_user($article_data);
    }
    public function ban($article_data = array())
    {
        $this->model->ban($article_data);
    }

    public function del($article_data = array())
    {
        $this->model->del($article_data);
    }
    public function plus_score($article_data = array(), $point_data = array(), $flat = false)
    {
        $this->model->plus_score($article_data, $point_data, $flat);
    }

    public function less_score($article_data = array(), $point_data = array())
    {

        $this->model->less_score($article_data, $point_data);
    }

    public function plus_comment($article_data = array())
    {
        $this->model->plus_comment($article_data);
    }

    public function less_comment($article_data = array())
    {
        $this->model->less_comment($article_data);
    }

    public function plus_views($article_data = array(), $article = '')
    {
        $this->model->plus_views($article_data, $article);
    }
    public function publish($article_data = array())
    {
        $article = $this->model->rea_for_user([':article_id' => $article_data[':article_id']]);
        if ($article[0]['public_date'] == null) {
            $article_data[':public_date'] = date('Y-m-d H:i:s', time());
        } else {
            $article_data[':public_date'] = $article[0]['public_date'];
        }
        $this->model->publish($article_data);
    }
    public function privatize($article_data = array())
    {
        $this->model->privatize($article_data);
    }
    public function get_articles_for_like($article_data = array(), $inicio = 0, $post_por_pagina = 5)
    {
        return $this->model->get_articles_for_like($article_data, $inicio, $post_por_pagina);
    }
}